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

        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);

        $exhibitionUser = $this->ExhibitionUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $answerData = $this->request->getData();
            
            if ($this->Auth->user() != null) {
                $exhibitionUser->users_id = $this->Auth->user('id');
            }
            $exhibitionUser->exhibition_id = $id;
            $exhibitionUser->exhibition_group_id = $answerData['exhibition_group_id'];
            $exhibitionUser->users_email = $answerData['users_email'];
            $exhibitionUser->users_name = $answerData['users_name'];
            $exhibitionUser->users_hp = $answerData['users_hp'];
            $exhibitionUser->users_sex = $answerData['users_sex'];
            if ($exhibition->cost == 'charged') :
            $exhibitionUser->pay_id = $answerData['pay_id'];
            $exhibitionUser->pay_amount = $answerData['pay_amount'];
            endif;
            $exhibitionUser->status = 2;
            
            if ($this->ExhibitionUsers->save($exhibitionUser)) {
                //회사 직함 저장
                if ($this->Auth->user() != null) {
                    
                    if (!$connection->update('users', ['company' => $answerData['company'], 'title' => $answerData['title']], ['id' => $this->Auth->user('id')])) {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                        return $response;
                    }
                }
                
                //설문 응답 저장
                $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')->where(['exhibition_id' => $id, 'survey_type' => 'B'])->toArray();
                
                $i = 0;
                $parentId = 0;
                $whereId = 0;
                
                if ($this->Auth->user() != null) {
                    $user_id = $this->Auth->user('id');
                } else {
                    $user_id = null;
                }
                
                foreach ($exhibitionSurveys as $exhibitionSurvey) {
                        
                    if (!$result = $connection->insert('exhibition_survey_users_answer', [
                        'exhibition_survey_id' => $exhibitionSurvey['id'],
                        'users_id' => $user_id,
                        'text' => $answerData['exhibition_survey_users_answer_'. $i .'_text'],
                        'is_multiple' => $exhibitionSurvey['is_multiple']
                    ])) {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                        return $response;
                    }
                    
                    if ($exhibitionSurvey['parent_id'] == null && $exhibitionSurvey['is_multiple'] == "Y") {
                        $parentId = $result->lastInsertId();
                        
                    } else {
                        
                        if ($exhibitionSurvey['is_multiple'] == "Y") {
                            $whereId = $result->lastInsertId();

                            if ($connection->update('exhibition_survey_users_answer', ['parent_id' => $parentId], ['id' => $whereId])) {
                                
                            } else {
                                $connection->rollback();
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        } 
                    }
                    $i++;
                }
                $connection->commit();

                $mailer = new Mailer();
                $mailer->setTransport('mailjet');

                $to = $this->request->getData('users_email');
                $Group = $this->getTableLocator()->get('ExhibitionGroup');
                $group_id = $this->request->getData('exhibition_group_id');
                $group = $Group->get($group_id);
                $user_name = $this->request->getData('user_name');            
                $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - 신청완료 확인 메일입니다.')
                            ->viewBuilder()
                            ->setTemplate('webinar_apply')
                        ;
                $mailer->setViewVars(['front_url' => FRONT_URL]);
                $mailer->setViewVars(['user_name' => $user_name]);
                $mailer->setViewVars(['title' => $exhibition->title]);
                $mailer->setViewVars(['apply_sdate' => $exhibition->apply_sdate]);
                $mailer->setViewVars(['apply_edate' => $exhibition->apply_edate]);
                $mailer->setViewVars(['sdate' => $exhibition->sdate]);
                $mailer->setViewVars(['edate' => $exhibition->edate]);
                $mailer->setViewVars(['name' => $exhibition->name]);
                $mailer->setViewVars(['tel' => $exhibition->tel]);
                $mailer->setViewVars(['email' => $exhibition->email]);
                $mailer->setViewVars(['group' => $group->name]);
                $mailer->setViewVars(['now' => FrozenTime::now()]);
                
                $mailer->deliver();

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;

            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
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

    public function signUp($type = null)
    {
        if (empty($this->Auth->user())) {
            return $this->redirect(['action' => 'certification']);
        }

        $this->paginate = ['limit' => 10];
        $today = FrozenTime::now();

        if (!empty($this->Auth->user())) {
            if ($type == 'application') {
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status !=' => 8])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
            } elseif ($type == 'close'){
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
            } elseif ($type == 'cancel') {
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status' => 8])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
            }
        } else {
            $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id IS' => null, 'ExhibitionUsers.status !=' => 8])->order(['ExhibitionUsers.id' => 'ASC']))->toArray();
        }
        
        $this->set(compact('exhibition_users'));
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

                    $exhibition = $this->Exhibition->get($id);
                    $user_name = $this->request->getData('user_name');           
                    
                    $mailer->setEmailFormat('html')
                                ->setTo($to)
                                ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                ->setSubject('Exon - 참가취소 확인 메일입니다.')
                                ->viewBuilder()
                                ->setTemplate('self_canceled')
                            ;
                    $mailer->setViewVars(['front_url' => FRONT_URL]);
                    $mailer->setViewVars(['user_name' => $user_name]);
                    $mailer->setViewVars(['title' => $exhibition->title]);
                    $mailer->setViewVars(['apply_sdate' => $exhibition->apply_sdate]);
                    $mailer->setViewVars(['apply_edate' => $exhibition->apply_edate]);
                    $mailer->setViewVars(['sdate' => $exhibition->sdate]);
                    $mailer->setViewVars(['edate' => $exhibition->edate]);
                    $mailer->setViewVars(['name' => $exhibition->name]);
                    $mailer->setViewVars(['tel' => $exhibition->tel]);
                    $mailer->setViewVars(['email' => $exhibition->email]);
                    $mailer->setViewVars(['refund' => $payment_data->cancel_amount]);
                    $mailer->setViewVars(['now' => FrozenTime::now()]);
                    
                    $mailer->deliver();
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
    
    public function downloadPdf($id = null)
    {
        $this->viewBuilder()->enableAutoLayout(false); 
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => $id . '_Report.pdf' //// This can be omitted if you want file name based on URL.
            ]
        );   
    }

    public function certification($id = null)
    {
        $this->set(compact('id'));
    }

    public function sendSmsCertification()
    {        
        if ($this->request->is('post')) {
            require_once("solapi-php/lib/message.php");

            $code = $this->generateCode();
            $commonConfirmation_table = TableRegistry::get('CommonConfirmation');
            $commonConfirmation = $commonConfirmation_table->newEmptyEntity();
            $commonConfirmation = $commonConfirmation_table->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

            if ($result = $commonConfirmation_table->save($commonConfirmation)) {
                $to[0] = $this->request->getData('hp');

                $messages = [
                    [
                        'to' => $to,
                        'from' => getEnv('EXON_PHONE_NUMBER'),
                        'text' => 'Confirmation Code : ' . $code
                    ]
                ];

                if(send_messages($messages)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                    return $response;
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }

        $this->set(compact('user_id'));
    }

    public function confirmSms($id = null) 
    {
        $commonConfirmation_table = TableRegistry::get('CommonConfirmation');
        $commonConfirmation = $commonConfirmation_table->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;

                } else {
                    $connection->rollback();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function sendEmailCertification () {
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $code = $this->generateCode();
            $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $CommonConfirmations->newEmptyEntity();
            $commonConfirmation = $CommonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' => $code, 'types' => 'email']);

            if ($result = $CommonConfirmations->save($commonConfirmation)) {
                
                $mailer->setEmailFormat('html')
                            ->setTo($this->request->getData('email'))
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - 인증메일입니다.')
                            ->viewBuilder()
                            ->setTemplate('certification')
                        ;
                $mailer->setViewVars(['front_url' => FRONT_URL]);
                $mailer->setViewVars(['code' => $code]);
                $mailer->deliver();

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                return $response;

            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
        $this->set(compact('user_id'));
    }

    public function confirmEmail($id = null)
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function generateCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)), 1);
        }
        return $code;
    }
}


