<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;
use Iamport;

class ExhibitionUsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test']);
    }
    
    public function index()
    {
        $this->paginate = [
            'contain' => ['Exhibition', 'ExhibitionGroup', 'Pay'],
        ];
        $exhibitionUsers = $this->paginate($this->ExhibitionUsers);

        $this->set(compact('exhibitionUsers'));
    }
    
    public function view($id = null)
    {
        $exhibitionUser = $this->ExhibitionUsers->get($id, [
            'contain' => ['Exhibition', 'ExhibitionGroup', 'Pay'],
        ]);

        $this->set(compact('exhibitionUser'));
    }

    //웨비나 신청
    public function add($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibitionUser = $this->ExhibitionUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $answerData = $this->request->getData();

            $exhibitionUser->users_id = $this->Auth->user('id');
            $exhibitionUser->exhibition_id = $id;
            $exhibitionUser->exhibition_group_id = $answerData['exhibition_group_id'];
            $exhibitionUser->users_email = $answerData['users_email'];
            $exhibitionUser->users_name = $answerData['users_name'];
            $exhibitionUser->users_hp = $answerData['users_hp'];
            $exhibitionUser->users_sex = $answerData['users_sex'];
            $exhibitionUser->pay_id = $answerData['pay_id'];
            $exhibitionUser->pay_amount = $answerData['pay_amount'];
            $exhibitionUser->status = 2;
            
            if ($this->ExhibitionUsers->save($exhibitionUser)) {
                //회사 직함 저장
                if (!$connection->update('users', ['company' => $answerData['company'], 'title' => $answerData['title']], ['id' => $this->Auth->user('id')])) {
                    $this->Flash->error(__('The company&title could not be saved. Please, try again.'));
                    $connection->rollback();
                }
                
                //설문 응답 저장
                $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')->where(['exhibition_id' => $id, 'survey_type' => 'B'])->toArray();
    
                $i = 0;
                $parentId = 0;
                $whereId = 0;
                foreach ($exhibitionSurveys as $exhibitionSurvey) {

                    if (!$result = $connection->insert('exhibition_survey_users_answer', [
                        'exhibition_survey_id' => $exhibitionSurvey['id'],
                        'users_id' => $this->Auth->user('id'),
                        'text' => $answerData['exhibition_survey_users_answer_'. $i .'_text'],
                        'is_multiple' => $exhibitionSurvey['is_multiple']
                    ])) {
                        $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
                        $connection->rollback();
                    }
                    
                    if ($exhibitionSurvey['parent_id'] == null && $exhibitionSurvey['is_multiple'] == "Y") {
                        $parentId = $result->lastInsertId();
                        
                    } else {
                        
                        if ($exhibitionSurvey['is_multiple'] == "Y") {
                            $whereId = $result->lastInsertId();

                            if ($connection->update('exhibition_survey_users_answer', ['parent_id' => $parentId], ['id' => $whereId])) {
                                
                            } else {
                                $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
                                $connection->rollback();
                            }
                        } 
                    }
                    $i++;
                }
                $connection->commit();

                $mailer = new Mailer();
                $mailer->setTransport('mailjet');

                $to = $this->request->getData('users_email');

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
                        ->deliver('신청 완료 - 참가 대기중')) 
                        {

                        } else {
                            $this->Flash->error(__('The Email could not be delivered.'));
                        }
        
                } catch (Exception $e) {
                    // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                    echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
                }

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;

            } else {
                $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
                $connection->rollback();
            }
        }
        $exhibition = $this->ExhibitionUsers->Exhibition->find('list', ['limit' => 200]);
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('all')->where(['exhibition_id' => $id]);
        $pay = $this->ExhibitionUsers->Pay->find('list', ['limit' => 200]);
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'survey_type' => 'B', 'parent_id Is' => null]);
        $user = $this->Auth->user();
        $this->set(compact('exhibitionUser', 'exhibition', 'exhibitionGroup', 'pay', 'exhibitionSurveys', 'id', 'user'));
    }

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
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status !=' => 8])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
        } elseif ($signUpId == 1){
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
        } elseif ($signUpId == 2) {
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $id, 'ExhibitionUsers.status' => 8])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
        }
        
        $this->set(compact('id', 'exhibition_users'));
    }

    public function exhibitionUsersStatus($id = null, $email = null, $pay_id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_user = $this->ExhibitionUsers->get($id);

        if($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {

            $Pay = $this->getTableLocator()->get('Pay');
            $pay = $Pay->get($pay_id);
            
            require_once("iamport-rest-client-php/src/iamport.php");
            
            $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));

            $result = $iamport->cancel(array(
                'imp_uid'		=> $pay->imp_uid, 		
                'merchant_uid'	=> $pay->merchant_uid, 	
                'amount' 		=> 0,				
                'reason'		=> '행사 이용자 취소',			
            ));
            if ( $result->success ) {
            
                $payment_data = $result->data;
                $now = FrozenTime::now();
                
                $pay->cancel_reason = '행사 이용자 취소';
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

        return $this->redirect(['action' => 'signUp', $exhibition_user->users_id]);
    }
}
