<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\ORM\TableRegistry;

/**
 * Exhibition Controller
 *
 * @property \App\Model\Table\ExhibitionTable $Exhibition
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test'])

        $uri = substr($_SERVER['REQUEST_URI'], 0, 16);
        if ($uri != '/exhibition/send') {
            $this->request->getSession()->delete('result');
        }
    }   

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $exhibition = $this->paginate($this->Exhibition->find()->where(['users_id' => 1]));
        $this->set(compact('exhibition'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['Banner', 'ExhibitionFile', 'ExhibitionGroup', 'ExhibitionStream', 'ExhibitionSurvey'],
        ]);
        $exhibitiongroups = $this->getTableLocator()->get('ExhibitionGroup');
        $groups = $exhibitiongroups->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['exhibition_id' => $id]);

        $this->set(compact('exhibition', 'groups'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition = $this->Exhibition->newEmptyEntity();

        if ($this->request->is('post')) {
            $exhibition = $this->Exhibition->patchEntity($exhibition, $this->request->getData(), ['associated' => ['ExhibitionGroup', 'ExhibitionSurvey']]);

            if ($result = $this->Exhibition->save($exhibition)) {
                $img = $this->request->getData('image');
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    $imgName = $result->id . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);
                    
                    if ($connection->update('exhibition', ['image_path' => $path, 'image_name' => $imgName], ['id' => $result->id])) {
                        $parentId = 0;
                        $whereId = 0;
                        $count = count($result->exhibition_survey);

                        for ($i =0; $i < $count; $i++) {

                            if ($result->exhibition_survey[$i]->survey_type != null && $result->exhibition_survey[$i]->is_duplicate != null) {
                                $parentId = $result->exhibition_survey[$i]->id;
                                $surveyType = $result->exhibition_survey[$i]->survey_type;
                                $isDuplicate = $result->exhibition_survey[$i]->is_duplicate;
                                $isMultiple = $result->exhibition_survey[$i]->is_multiple;
                            } else {
                                $whereId = $result->exhibition_survey[$i]->id;

                                if (!$connection->update('exhibition_survey', [
                                    'parent_id' => $parentId, 'survey_type' => $surveyType,
                                    'is_duplicate' => $isDuplicate, 'is_multiple' => $isMultiple], ['id' => $whereId])) {

                                        $connection->rollback(); 
                                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                                }
                            }
                        }
                        $connection->commit();
                        $this->Flash->success(__('The exhibition has been saved.'));
                        return $this->redirect(['action' => 'index']);
                        
                    } else {
                        $connection->rollback(); 
                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                    }
                
                }else {
                    $connection->rollback();
                    $this->Flash->error(__('Incorrect image type.'));
                    return $this->redirect(['action' => 'add']);
                }

            } else {
                $connection->rollback(); 
                $this->Flash->error(__('The exhibition could not be saved. Please, try again.'));
            }       
        }
        $commonCategory = $this->getTableLocator()->get('CommonCategory');
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $categories = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'category']);
        $types = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'type']);
        $this->set(compact('exhibition', 'users', 'categories', 'types'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['ExhibitionGroup', 'ExhibitionSurvey'],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $exhibition = $this->Exhibition->patchEntity($exhibition, $this->request->getData(), ['associated' => ['ExhibitionGroup', 'ExhibitionSurvey']]);

            if ($result = $this->Exhibition->save($exhibition)) {
                $img = $this->request->getData('image');
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    $imgName = $result->id . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);
    
                    if ($connection->update('exhibition', ['image_path' => $path, 'image_name' => $imgName], ['id' => $result->id])) {
                        
                        $count = count($exhibition->exhibition_group);

                        for ($i = 0; $i < $count; $i++) {
                    
                            if ($this->request->getData('exhibition_group')[$i]['is_delete'] == 'Y') {
                                    
                                if (!$connection->delete('exhibition_group', ['id' => $this->request->getData('exhibition_group')[$i]['id']])) {
                                    $connection->rollback(); 
                                    $this->Flash->error(__('The exhibition group could not be saved. Please, try again.'));
                                }
                            }
                        }
                        
                        $count = count($exhibition->exhibition_survey);

                        for ($i = 0; $i < $count; $i++) {
                            
                            if ($this->request->getData('exhibition_survey')[$i]['is_delete'] != 'multiple view') {
                                
                                if ($this->request->getData('exhibition_survey')[$i]['is_delete'] == 'Y') {
                                
                                    if ($connection->delete('exhibition_survey', ['parent_id' => $this->request->getData('exhibition_survey')[$i]['id']])) {
                                            
                                        if (!$connection->delete('exhibition_survey', ['id' => $this->request->getData('exhibition_survey')[$i]['id']])) {
                                            $connection->rollback(); 
                                            $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                                        }

                                    } else {
                                        $connection->rollback(); 
                                        $this->Flash->error(__('The exhibition group could not be saved. Please, try again.'));
                                    }
                                }
                            }
                        }
                        $connection->commit();
                        $this->Flash->success(__('The exhibition has been saved.'));
                        return $this->redirect(['action' => 'index']);
                        
                    } else {
                        $connection->rollback(); 
                        $this->Flash->error(__('The exhibition could not be saved. Please, try again.'));
                    }
                
                }else {
                    $connection->rollback();
                    $this->Flash->error(__('Incorrect image type.'));
                    return $this->redirect(['action' => 'add']);
                }

            } else {
                $connection->rollback(); 
                $this->Flash->error(__('The exhibition could not be saved. Please, try again.'));
            }     
        }
        $commonCategory = $this->getTableLocator()->get('CommonCategory');
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $categories = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'category']);
        $types = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'type']);
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')->where(['exhibition_id' => $id]);
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id]);
        $this->set(compact('exhibition', 'users', 'categories', 'types', 'exhibitionSurveys', 'exhibitionGroups'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['get', 'post', 'delete']);
        
        $exhibition = $this->Exhibition->get($id);
        
        if ($this->Exhibition->delete($exhibition)) {
            $this->Flash->success(__('The exhibition has been deleted.')); 
        
        } else {
            $this->Flash->error(__('The exhibition could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);    
    }

    public function managerPerson($id = null)
    {
        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_users = $exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status !=' => 4])->toArray();
        debug($exhibition_users);

        $this->set(compact('exhibition_users'));
    }

    public function exhibitionUsersStatus($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => '4'], ['id' => $id])) {
            $connection->commit();
            $this->Flash->success(__('Your post has been saved.'));
        } else {
            $connection->rollback();
            $this->Flash->error(__('Unable to add you post.'));
        }

        return $this->redirect(['action' => 'managerPerson', $exhibition_user->exhibition_id]);
    }

    public function userSurveyView($id = null)
    {
        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        return $this->redirect(['controller' => 'exhibitionSurvey', 'action' => 'view', $exhibition_user->user_id]);
    }

    public function sendEmailToParticipant($id = null)
    {
        $session = $this->request->getSession();
        
        if ($session->read('result')) {
            $exhibitionUsers = $session->read('result');

        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('put')) {
            
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $users = $this->request->getData('users_email');
            $count = count($users);
            $to[] ='';

            for ($i = 0; $i < $count; $i++) {
                $to[$i] = $exhibitionUsers[$users[$i]]['users_email'];
            }

            try {                   
                // $host = HOST;
                // $sender = SEND_EMAIL;
                // $view = new \Cake\View\View($this->request, $this->response);
                // $view->set(compact('sender')); //이메일 템플릿에 파라미터 전달
                // $content = $view->element('email/findPw'); //이메일 템블릿 불러오기
                if ($res = $mailer->setFrom([getEnv('EXON_EMAIL_ADDRESS') => $this->request->getData('name')])
                    ->setEmailFormat('html')
                    ->setTo($to)
                    ->setSubject('Exon Test Email')
                    ->deliver($this->request->getData('email_content'))) 
                    {
                        $this->Flash->success(__('The Email has been delivered.'));
                        $session->delete('result');
                        return $this->redirect(['action' => 'sendEmailToParticipant', $id]);

                    } else {
                        $this->Flash->error(__('The Email could not be delivered.'));
                    }
    
            } catch (Exception $e) {
                // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
            }
        }
        $this->set(compact('exhibitionUsers'));
    }

    public function sendSmsToParticipant($id = null)
    {
        require_once("solapi-php/lib/message.php");
        $session = $this->request->getSession();

        if ($session->read('result')) {
            $exhibitionUsers = $session->read('result'); 
        
        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('put')) {
            
            $users = $this->request->getData('users_hp');
            $count = count($users);
            $to[] ='';

            for ($i = 0; $i < $count; $i++) {
                $to[$i] = $exhibitionUsers[$users[$i]]['users_hp'];
            }

            $messages = [
                [
                'to' => $to,
                'from' => getEnv('EXON_PHONE_NUMBER'),
                'text' => $this->request->getData('sms_content')
                ]
            ];

            if (send_messages($messages)) {
                $this->Flash->success(__('The SMS has been delivered.'));
                $session->delete('result');
                return $this->redirect(['action' => 'sendSmsToParticipant', $id]);
            
            } else {
                $this->Flash->error(__('The SMS could not be delivered.'));
            }
        }
        $this->set(compact('exhibitionUsers'));
    }

    public function participantList($id = null, $type = null)
    {
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id])->toArray();
        if ($this->request->is('put')) {
            $data = $this->request->getData('data');
            $count = count($data);
            $result[] = '';

            for ($i = 0; $i < $count; $i++) {
                $result[$i] = $exhibitionUsers[$data[$i]];
            }
            $this->request->getSession()->write('result', $result);
            
            if ($type == 'email') {
                return $this->redirect(['action' => 'sendEmailToParticipant', $id]);
            
            } else {
                return $this->redirect(['action' => 'sendSmsToParticipant', $id]);
            }
        }
        $this->set(compact('exhibitionUsers'));
    }
}
