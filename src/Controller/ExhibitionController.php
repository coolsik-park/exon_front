<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Iamport;

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
    }   

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', ['actions' => ['search'],]);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $exhibition = $this->paginate($this->Exhibition->find()->where(['users_id' => $this->Auth->user('id')]));
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

                //메인 사진 업로드
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

                        //설문 생성
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

    public function managerPerson($id = null, $word = null)
    {
        $this->paginate = ['limit' => 10];

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status !=' => 8]))->toArray();

        // if($word == null) {
        //     $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status !=' => 8]))->toArray();
        // } else {
        //     // $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['Exhibition_id.exhibition_id' => $id, 'ExhibitionUsers.status !=' => 8, 'ExhibitionUsers.users_email' => $word]))->toArray();
        //     return $this->redirect(['action' => 'index']);
        // }

        $this->set(compact('id', 'exhibition_users'));
    }

    public function wordSearch()
    {
        $id = $this->request->getData('id');
        $word = $this->request->getData('word');

        echo($this->request->getData());
        exit;

        return $this->redirect(['action' => 'index']);
    }

    public function exhibitionUsersStatus($id = null, $email = null, $pay_id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {

            $Pay = $this->getTableLocator()->get('Pay');
            $pay = $Pay->get($pay_id);
            
            require_once("iamport-rest-client-php/src/iamport.php");
            
            $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));

            $result = $iamport->cancel(array(
                'imp_uid'		=> $pay->imp_uid, 		
                'merchant_uid'	=> $pay->merchant_uid, 	
                'amount' 		=> 0,				
                'reason'		=> '행사 관리자 취소',			
            ));
            if ( $result->success ) {
            
                $payment_data = $result->data;
                $now = FrozenTime::now();
                

                $pay->cancel_reason = '행사 관리자 취소';
                $pay->cancel_date = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
                
                if ($Pay->save($pay)) {
                    $connection->commit();

                    $mailer = new Mailer();
                    $mailer->setTransport('mailjet');

                    $to = $email;

                    try {                   
                        // $host = HOST;
                        // $sender = SEND_EMAIL;
                        // $view = new \Cake\View\View($this->request, $this->response);
                        // $view->set(compact('sender')); //이메일 템플릿에 파라미터 전달
                        // $content = $view->element('email/findPw'); //이메일 템블릿 불러오기
                        if ($res = $mailer->setFrom([getEnv('EXON_EMAIL_ADDRESS') => '엑손 관리자'])
                            ->setEmailFormat('html')
                            ->setTo($to)
                            ->setSubject('Exon Test Email')
                            ->deliver('행사취소, 취소금액 : ' . $payment_data->cancel_amount)) 
                            {

                            } else {
                                $this->Flash->error(__('The Email could not be delivered.'));
                            }
            
                    } catch (Exception $e) {
                        // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                        echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
                    }
                    $this->Flash->success(__('Your post has been saved and email delivered'));
                
                } else {
                    $this->Flash->error(__('Pay could not be saved'));
                }
                
            } else {
                $this->Flash->error(__('The payment could not be canceled.'));
            }
        
        } else {
            $connection->rollback();
            $this->Flash->error(__('Unable to add you post.'));
        }

        return $this->redirect(['action' => 'managerPerson', $exhibition_user->exhibition_id]);
    }

    public function exhibitionUsersApproval($id = null, $status = null)
    {
        $id = $this->request->getData('id');
        $status = $this->request->getData('status');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => $status], ['id' => $id])) {
            $connection->commit();

            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $to = $this->request->getData('email');

            try {                   
                // $host = HOST;
                // $sender = SEND_EMAIL;
                // $view = new \Cake\View\View($this->request, $this->response);
                // $view->set(compact('sender')); //이메일 템플릿에 파라미터 전달
                // $content = $view->element('email/findPw'); //이메일 템블릿 불러오기
                if ($res = $mailer->setFrom([getEnv('EXON_EMAIL_ADDRESS') => '엑손 관리자'])
                    ->setEmailFormat('html')
                    ->setTo($to)
                    ->setSubject('Exon Test Email')
                    ->deliver('행사신청 - 참가 확정')) 
                    {

                    } else {
                        $this->Flash->error(__('The Email could not be delivered.'));
                    }
    
            } catch (Exception $e) {
                // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
            }

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

        return $this->redirect(['controller' => 'exhibitionSurvey', 'action' => 'surveyUserAnswer', $exhibition_user->exhibition_id]);
    }

    // public function search()
    // {
    //     $this->paginate['maxLimit'] = 999;
    //     $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
    //     $exhibition_users = $this->paginate($exhibition_users_table->find('search', ['search' => $this->request->getQuery()]))->toArray();

    //     $this->set(compact('exhibition_users'));
    //     $this->set('_serialize', ['exhibition_users']);

    //     return $this->redirect(['action' => 'managerPerson', $exhibition_user->exhibition_id]);
    // }

    public function sendEmailToParticipant($id = null, $exhibition_users_id = null)
    {
        if ($exhibition_users_id != null) {
            $lists = explode(",", $exhibition_users_id);
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();

        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $users_email = $this->request->getData('users_email');
            $to = explode(",", $users_email);

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
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                        return $response;

                    } else {
                        $this->Flash->error(__('The Email could not be delivered.'));
                    }
    
            } catch (Exception $e) {
                // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
            }
        }
        $this->set(compact('id', 'exhibitionUsers', 'exhibition_users_id'));
    }

    public function sendSmsToParticipant($id = null, $exhibition_users_id = null)
    {
        require_once("solapi-php/lib/message.php");
        
        if ($exhibition_users_id != null) {
            $lists = explode(",", $exhibition_users_id);
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();
        
        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('post')) {
            
            $users_hp = $this->request->getData('users_hp');
            $to = explode(",", $users_hp);

            $messages = [
                [
                'to' => $to,
                'from' => getEnv('EXON_PHONE_NUMBER'), //현재 대표님 번호로 설정되어 있음.
                'text' => $this->request->getData('sms_content')
                ]
            ];

            if (send_messages($messages)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            
            } else {
                $this->Flash->error(__('The SMS could not be delivered.'));
            }
        }
        $this->set(compact('id', 'exhibitionUsers', 'exhibition_users_id'));
    }

    public function participantList($id = null, $type = null)
    {
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        
        if ($this->request->is('post')) {
            $data = $this->request->getData('data');
            
            if ($type == 'email') {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'type' => 'email', 'data' => $data]));
                return $response;
            
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'type' => 'sms', 'data' => $data]));
                return $response;
            }
        }
        $this->set(compact('exhibitionUsers', 'exhibitionGroups', 'id', 'type'));
    }

    public function surveyData($id = null)
    {
        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);

        //사전설문 데이터

        $exhibitionSurveys = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 
                'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'B'])
            ->toArray();
        
        $parent_id = 0;
        $i = 0;
        $j = 0;
        $beforeParentData[] = null;
        $beforeChildData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $beforeParentData[$i] = $exhibitionSurvey;
                $i++;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $beforeChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }
        
        //일반설문 데이터

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);

        //사전설문 데이터

        $exhibitionSurveys = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 
                'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'B'])
            ->toArray();
        
        $parent_id = 0;
        $i = 0;
        $j = 0;
        // $beforeParentData[] = null;
        // $beforeChildData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $beforeParentData[$i] = $exhibitionSurvey;
                $i++;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $beforeChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }
        
        //일반설문 데이터

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);

        $exhibitionSurveys = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 
                'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'N'])
            ->toArray();
        
        
        $parent_id = 0;
        $i = 0;
        $j = 0;
        // $normalParentData[] = null;
        // $normalChildData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $normalParentData[$i] = $exhibitionSurvey;
                $i++;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $normalChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }

        if ($this->request->is('post')) {
            
            $data = $this->request->getData('checked');
            $count = count($data);

            //엑셀 파일 저장
            $spreadsheet = new Spreadsheet();

            //Specify the properties for this document
            $spreadsheet->getProperties()
                ->setTitle('설문 데이터')
                ->setCreator('EXON.com')
                ->setLastModifiedBy('EXON.com');

            for ($i = 0; $i < ($count-1); $i++) {
                $spreadsheet->createSheet();
            }

            for ($i = 0; $i < $count; $i++) {
                $spreadsheet->setActiveSheetIndex($i)
                ->setTitle('질문' . ($i+1))
                ->setCellValue('A1', '');

                $spreadsheet->getActiveSheet($i)
                ->setCellValue('B1', '이름')
                ->setCellValue('C1', '이메일')
                ->setCellValue('D1', '질문' . ($i+1));
            }

            $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
            $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id])->toArray();
            $rowCount = count($exhibitionUsers);

            $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
            $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');

            $exhibitionSurvey = $ExhibitionSurvey->find('all', [
                'conditions' => [
                    'or' => [
                        'id IN' => $data,
                        'parent_id IN' => $data
                    ]
                ]
            ])->select(['id'])->toArray();

            $checkedCount = count($exhibitionSurvey);
            for ($i = 0; $i < $checkedCount; $i++) {
                $checked[$i] = $exhibitionSurvey[$i]['id'];
            }

            $answered[] = '';
            for ($i = 0; $i < $rowCount; $i++) {
                $exhibitionSurveyUsersAnswer = $ExhibitionSurveyUsersAnswer->find('all', [
                    'conditions' => [
                        'text IS NOT' => 'question',
                        'exhibition_survey_id IN' => $checked,
                        'or' => [
                            'text' => 'Y',
                            'text IS NOT' => ''
                        ]
                    ]
                ])->where(['users_id' => $exhibitionUsers[$i]['users_id']])->toArray();
                
                $answerCount = count($exhibitionSurveyUsersAnswer);
                
                if ($answerCount != 0) {
                    for ($j = 0; $j < $answerCount; $j++) {
                        
                        if ($exhibitionSurveyUsersAnswer[$j]['text'] == 'Y') {
                            $answered[$j] = (int)$exhibitionSurveyUsersAnswer[$j]['exhibition_survey_id'];
                            
                        } else {
                            $answered[$j] = $exhibitionSurveyUsersAnswer[$j]['text'];
                        }
                    } 
                } else {
                    $answered[0] = '';
                }
            
                $answerData[$i] = [
                    'users_id' => $exhibitionUsers[$i]['users_id'],
                    'answered' => $answered 
                ];
            }
            
            for ($i = 0; $i < $count; $i++) {
                $exhibitionSurvey = $ExhibitionSurvey->find('all')->where(['id' => $data[$i]])->toArray();
                $question = $exhibitionSurvey[0]['text'];

                $spreadsheet->setActiveSheetIndex($i)
                ->setTitle($question)
                ->setCellValue('A1', '');

                $spreadsheet->setActiveSheetIndex($i)
                ->getColumnDimension('C')->setWidth(30);	

                $spreadsheet->setActiveSheetIndex($i)
                ->getColumnDimension('D')->setWidth(30);

                $spreadsheet->getActiveSheet($i)
                ->setCellValue('B1', '이름')
                ->setCellValue('C1', '이메일')
                ->setCellValue('D1', $question);

                for ($j = 0; $j < $rowCount; $j++) {
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('A' . ($j+2), ($j+1))
                        ->setCellValue('B' . ($j+2), $exhibitionUsers[$j]['users_name'])
                        ->setCellValue('C' . ($j+2), $exhibitionUsers[$j]['users_email']);           
                }
                for ($j = 0; $j < $rowCount; $j++) {
                    if ($answerData[$j]['answered'][0] == '') {
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('D' . ($j+2), '');
                    } else {
                        if (is_int($answerData[$j]['answered'][$i])) {
                            $text = $ExhibitionSurvey->find()->select(['text'])->where(['id' => $answerData[$j]['answered'][$i]])->toArray();
                            $text = $text[0]['text'];
                        } else {
                            $text = $answerData[$j]['answered'][$i];
                        }
                        
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('D' . ($j+2), $text);
                    }
                }
            }
            
            $path = 'download' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
        
            if (!file_exists(WWW_ROOT . $path)) {
                $oldMask = umask(0);
                mkdir(WWW_ROOT . $path, 0777, true);
                chmod(WWW_ROOT . $path, 0777);
                umask($oldMask);
            }

            $fileName = $id . "_survey_data." . "xlsx";
            $destination = WWW_ROOT . $path . DS . $fileName;

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
            $writer->save($destination);
            
            //엑셀 파일 다운로드
            $down = $destination;
            
            if(file_exists($down)) {
                header("Content-Type:application/octet-stream");
                header("Content-Disposition:attachment;filename=$fileName");
                header("Content-Transfer-Encoding:binary");
                header("Content-Length:".filesize($down));
                header("Cache-Control:cache,must-revalidate");
                header("Pragma:no-cache");
                header("Expires:0");
                
                if(is_file($down)){
                    $fp = fopen($down,"r");
                    
                    while(!feof($fp)){
                        $buf = fread($fp,8096);
                        $read = strlen($buf);
                        print($buf);
                        flush();
                    }
                fclose($fp);
                }
            } else {
                
            }
        }

        $this->set(compact('beforeParentData', 'beforeChildData', 'normalParentData', 'normalChildData', 'id'));
    }
    // Subqueries
    // Subqueries enable you to compose queries together and build conditions and results based on the results of other queries:

    // $matchingComment = $articles->getAssociation('Comments')->find()
    //     ->select(['article_id'])
    //     ->distinct()
    //     ->where(['comment LIKE' => '%CakePHP%']);

    // $query = $articles->find()
    //     ->where(['id IN' => $matchingComment]);
    // Subqueries are accepted anywhere a query expression can be used. For example, in the select() and join() methods. The above example uses a standard Orm\Query object that will generate aliases, these aliases can make referencing results in the outer query more complex. As of 4.2.0 you can use Table::subquery() to create a specialized query instance that will not generate aliases:

    // $comments = $articles->getAssociation('Comments')->getTarget();

    // $matchingComment = $comments->subquery()
    //     ->select(['article_id'])
    //     ->distinct()
    //     ->where(['comment LIKE' => '%CakePHP%']);

    // $query = $articles->find()
    //     ->where(['id IN' => $matchingComment]);

    public function exhibitionStatisticsApply($id = null)
    {
        //신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->toArray();
    
        //성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status IN' => [1, 2, 4]])->toArray();
        
        //나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status != 8) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        $this->set(compact('id', 'applyRates', 'genderRates', 'ages'));
    }

    public function exhibitionStatisticsParticipant($id = null)
    {
        //현재 신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //참가자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup'));
    }

    public function exhibitionStatisticsParticipantByGroup($id = null, $group = null)
    {
        //현재 그룹 신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //그룹 참가자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //그룹 나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup'));
    }

    public function exhibitionStatisticsStream($id = null) 
    {
        //출결석 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //질문 응답 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionQuestion'])->where(['exhibition_id' => $id])->toArray();
        $total = 0;
        $countI = count($exhibitionUsers);
        for ($i = 0; $i < $countI; $i++) {
            $countJ = count($exhibitionUsers[$i]->exhibition_question);
            for ($j = 0; $j < $countJ; $j++) {
                if ($exhibitionUsers[$i]->exhibition_question[$j]->parent_id == null) {
                    $total++;
                }
            }
        }

        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $answered = $exhibitionUsers->select(['count' =>$exhibitionUsers->func()->count('ExhibitionQuestion.id')])
            ->innerJoinWith('ExhibitionQuestion', function ($q) {
                return $q->where(['ExhibitionQuestion.parent_id IS NOT' => null]);
            })
            ->toArray();

        $answeredData = [
            'total' => $total,
            'answered' => $answered[0]->count
        ];

        //시청자 나이 대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 || $exhibition[0]->users[$i]->_joinData->attend == 4) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        //시청자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates'));
    }

    public function exhibitionStatisticsStreamByGroup($id = null, $group = null)
    {
        //출결석 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //질문 응답 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionQuestion'])->where(['exhibition_id' => $id, 'exhibition_group_id' => $group])->toArray();
        $total = 0;
        $countI = count($exhibitionUsers);
        for ($i = 0; $i < $countI; $i++) {
            $countJ = count($exhibitionUsers[$i]->exhibition_question);
            for ($j = 0; $j < $countJ; $j++) {
                if ($exhibitionUsers[$i]->exhibition_question[$j]->parent_id == null) {
                    $total++;
                }
            }
        }

        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $answered = $exhibitionUsers->select(['count' =>$exhibitionUsers->func()->count('ExhibitionQuestion.id')])
            ->innerJoinWith('ExhibitionQuestion', function ($q) {
                return $q->where(['ExhibitionQuestion.parent_id IS NOT' => null]);
            })
            ->toArray();

        $answeredData = [
            'total' => $total,
            'answered' => $answered[0]->count
        ];
        
        //시청자 나이 대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group || $exhibition[0]->users[$i]->_joinData->attend == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        //시청자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates'));
    }

    public function exhibitionStatisticsExtra($id = null) 
    {
        //설문 별 응답률
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ids[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 2 || $exhibition[0]->users[$i]->_joinData->status == 4) {
                $ids[$i] = $exhibition[0]->users[$i]->id;
            }
        }

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')
            ->where(['exhibition_id' => $id, 'ExhibitionSurveyUsersAnswer.parent_id IS' => null, 'ExhibitionSurveyUsersAnswer.users_id IN' => $ids]);
        $answerRates = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.text', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.id')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer')
            ->group('ExhibitionSurvey.id')
            ->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('status')])->where(['status IN' => [2, 4]])->toArray();

        //첫방문 or 재방문

        //재방문 유저 탐색
        $participatedCount = 0;
        $exhibition = $this->Exhibition->find('all')->where(['id' => $id])->toArray();
        $currentExhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $currentExhibitionParticipant[] = '';
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4){
                $currentExhibitionParticipant[$i] = $currentExhibition[0]->users[$i]->_joinData->users_id;
            }
        }

        $previousExhibition[] = '';
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['users_id' => $exhibition[0]->users_id])->toArray();
        $count = count($exhibition);    
        for ($i = 0; $i < $count; $i++ ) {
            if ((int)$exhibition[$i]->created->i18nFormat('yyyyMMddHHmmss') < (int)$currentExhibition[0]->created->i18nFormat('yyyyMMddHHmmss')) {
                $previousExhibition[$i] = $exhibition[$i];
            }
        }
        
        if ($previousExhibition[0] != '') {
            $previousExhibitionParticipant[] = '';
            $countI = count($previousExhibition);
            $k = 0;
            for ($i = 0; $i < $countI; $i++) {
                $countJ = count($previousExhibition[$i]->users);
                for ($j = 0; $j < $countJ; $j++) {
                    if ($previousExhibition[$i]->users[$j]->_joinData->status == 4) {
                        $previousExhibitionParticipant[$k] = $previousExhibition[$i]->users[$j]->id;
                        $k++;              
                    }  
                }
            }
            $previousExhibitionParticipant = array_unique($previousExhibitionParticipant);
            $previousExhibitionParticipant = array_values($previousExhibitionParticipant);

            $countK = count($currentExhibitionParticipant);
            $countL = count($previousExhibitionParticipant);
            for ($k = 0; $k < $countK; $k++) {
                for ($l = 0; $l < $countL; $l++) {
                    if ($currentExhibitionParticipant[$k] == $previousExhibitionParticipant[$l]) {
                        $participatedCount++;
                    }
                }
            }
        } 
        
        //참가자 수
        $totalParticipant = 0;
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4)  {
                $totalParticipant++;
            }
        }
        
        $participatedData = [
            'total' => $totalParticipant,
            'participated' => $participatedCount,
        ];

        $this->set(compact('id', 'answerRates', 'applyRates', 'participatedData'));
    }

    public function exhibitionSupervise($id = null, $type = null)
    {
        $this->paginate = ['limit' => 10];
        $today = new \DateTime();

        if ($type == null) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id]))->toArray();
        } elseif ($type == 1) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.apply_sdate >' => $today]))->toArray();
        } elseif ($type == 2) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.private' => 1]))->toArray();
        } elseif ($type == 3) {            
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.edate <' => $today]))->toArray();
        }

        $this->set(compact('id', 'exhibitions'));
    }
}
