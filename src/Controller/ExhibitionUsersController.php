<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;

/**
 * ExhibitionUsers Controller
 *
 * @property \App\Model\Table\ExhibitionUsersTable $ExhibitionUsers
 * @method \App\Model\Entity\ExhibitionUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionUsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Exhibition', 'ExhibitionGroup', 'Pay'],
        ];
        $exhibitionUsers = $this->paginate($this->ExhibitionUsers);

        $this->set(compact('exhibitionUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionUser = $this->ExhibitionUsers->get($id, [
            'contain' => ['Exhibition', 'ExhibitionGroup', 'Pay'],
        ]);

        $this->set(compact('exhibitionUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    //웨비나 신청
    public function add($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibitionUser = $this->ExhibitionUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionUser->exhibition_id = $id;
            $exhibitionUser->status = 2;
            $exhibitionUser = $this->ExhibitionUsers->patchEntity($exhibitionUser, $this->request->getData());
            
            if ($this->ExhibitionUsers->save($exhibitionUser)) {
                
                //설문 응답 저장
                $survey = $this->getTableLocator()->get('ExhibitionSurvey')->find()->select(['id', 'parent_id', 'is_multiple'])->where(['exhibition_id' => $id])->toArray();
                $UserAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');
                $userAnswer = $this->request->getData('exhibition_survey_users_answer');
    
                $userId = 1;
                $parentId = 0;
                $whereId = 0;
                
                if ($userAnswer != null) {
                    
                    $count = count($userAnswer);

                    for ($i = 0; $i < $count; $i++) {  
                        
                        if (!$result = $connection->insert('exhibition_survey_users_answer', [
                                'exhibition_survey_id' => $survey[$i]->id,
                                'users_id' => $userId,
                                'text' => $userAnswer[$i]['text'],
                                'is_multiple' => $survey[$i]->is_multiple
                        ])) {
                            $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
                            $connection->rollback();
                        }
                        
                        if ($survey[$i]->parent_id == null && $survey[$i]->is_multiple == "Y") {
                            $parentId = $result->lastInsertId();
                            
                        } else {
                            
                            if ($survey[$i]->is_multiple == "Y") {
                                $whereId = $result->lastInsertId();

                                if (!$connection->update('exhibition_survey_users_answer', ['parent_id' => $parentId], ['id' => $whereId])) {
                                    $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
                                    $connection->rollback();
                                }
                            } 
                        }
                    }
                }
                $this->Flash->success(__('The exhibition user has been saved.'));
                $connection->commit();
                return $this->redirect(['action' => 'index']);

            } else {
                $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
                $connection->rollback();
            }
        }
        $exhibition = $this->ExhibitionUsers->Exhibition->find('list', ['limit' => 200]);
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('list', ['keyField' => 'id', 'valueField' => 'name'])->where(['exhibition_id' => $id]);
        $pay = $this->ExhibitionUsers->Pay->find('list', ['limit' => 200]);
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')->where(['exhibition_id' => $id]);
        $this->set(compact('exhibitionUser', 'exhibition', 'exhibitionGroup', 'pay', 'exhibitionSurveys'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibitionUser = $this->ExhibitionUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionUser = $this->ExhibitionUsers->patchEntity($exhibitionUser, $this->request->getData());
            if ($this->ExhibitionUsers->save($exhibitionUser)) {
                $this->Flash->success(__('The exhibition user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionUsers->Exhibition->find('list', ['limit' => 200]);
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $pay = $this->ExhibitionUsers->Pay->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionUser', 'exhibition', 'exhibitionGroup', 'pay'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionUser = $this->ExhibitionUsers->get($id);
        if ($this->ExhibitionUsers->delete($exhibitionUser)) {
            $this->Flash->success(__('The exhibition user has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    //본인인증 이메일 발송
    public function sendEmail()
    {
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $code = $this->generateCode();
            $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $CommonConfirmations->newEmptyEntity();
            $commonConfirmation = $CommonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' => $code, 'types' => 'email']);

            if ($result = $CommonConfirmations->save($commonConfirmation)) {
                try {
                    // $host = HOST;
                    // $sender = SEND_EMAIL;
                    // $view = new \Cake\View\View($this->request, $this->response);
                    // $view->set(compact('sender')); //이메일 템플릿에 파라미터 전달
                    // $content = $view->element('email/findPw'); //이메일 템블릿 불러오기
                    if ($res = $mailer->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'Email Confirmation'])
                        ->setEmailFormat('html')
                        ->setTo($this->request->getData('email_address'))
                        ->setSubject('Exon Test Email')
                        ->deliver('Confirmation Code : ' . $code)) 
                        {
                            $this->Flash->success(__('The Email has been delivered.'));
                        
                        } else {
                            $this->Flash->error(__('The Email could not be delivered.'));
                        }
    
                        return $this->redirect(['action' => 'confirmEmail', $result->id]);
    
                } catch (Exception $e) {
                    // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                    echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
                }
            } else {
                $this->Flash->error(__('The Confirmation Code could not be saved.'));
            }
        }
    }

    //본인인증 이메일 코드 검증
    public function confirmEmail($id = null)
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {
                
                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                    $this->Flash->success(__('The Email has been confirmed.'));
                    return $this->redirect(['action' => 'index']);
                
                } else {
                    $this->Flash->error(__('The wrong code.'));
                }

            } else {
                $this->Flash->error(__('Overtime'));
            }
        }
    }

    //본인인증 이메일 코드 발행
    function generateCode()
    {
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)), 1);
        }
        return $code;
    }

    public function signUp($id = null, $signUpId = null)
    {
        $this->paginate = ['limit' => 10];
        $today = new \DateTime();

        if ($signUpId == null) {
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status !=' => 8]))->toArray();
        } elseif ($signUpId == 1){
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today]))->toArray();
        } elseif ($signUpId == 2) {
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status' => 8]))->toArray();
        }
        
        $this->set(compact('exhibition_users'));
    }

    public function exhibitionUsersStatus($id = null, $email = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_user = $this->ExhibitionUsers->get($id);

        if ($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {
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
                    ->deliver('행사 신청 취소')) 
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

        return $this->redirect(['action' => 'signUp', $exhibition_user->users_id]);
    }
}
