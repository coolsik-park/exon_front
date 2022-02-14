<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;
use Cake\Event\EventInterface;
use Iamport;

class ExhibitionUsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
    }

    public function isAuthorized() {
        if(!empty($this->Auth->user('id'))) {
            return true;
        }
        // Default deny
        return parent::isAuthorized($user);
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
    public function add($id = null, $group_id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);
        
        $today = strtotime(date('Y-m-d H:i:s', time()+32400));
        $apply_sdate = strtotime($exhibition->apply_sdate->format('Y-m-d H:i:s'));
        $apply_edate = strtotime($exhibition->apply_edate->format('Y-m-d H:i:s'));
        
        $exhibitionUser = $this->ExhibitionUsers->newEmptyEntity();

        if ($this->request->is('post')) {
            $answerData = $this->request->getData();
            
            if ($this->Auth->user() != null) {
                $exhibitionUser->users_id = $this->Auth->user('id');
            }
            $exhibitionUser->exhibition_id = $id;
            if (!empty($answerData['exhibition_group_id'])) :
            $exhibitionUser->exhibition_group_id = $answerData['exhibition_group_id'];
            endif;
            $exhibitionUser->users_email = $answerData['users_email'];
            $exhibitionUser->users_name = $answerData['users_name'];
            if ($answerData['users_hp'] != '010') :
                $exhibitionUser->users_hp = $answerData['users_hp'];
            else : 
                $exhibitionUser->users_hp = null;
            endif;
            if ($answerData['users_sex'] == '') :
                $exhibitionUser->users_sex = null;
            else :
                $exhibitionUser->users_sex = $answerData['users_sex'];
            endif;
            if ($answerData['pay_amount'] != 0) :
            $exhibitionUser->pay_id = $answerData['pay_id'];
            $exhibitionUser->pay_amount = $answerData['pay_amount'];
            endif;
            if ($exhibition->auto_approval == 0 || $exhibition->apply_edate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s', time()+32400)) :
            $exhibitionUser->status = 2;
            else :
            $exhibitionUser->status = 4;
            endif;

            if (!empty($this->ExhibitionUsers->find('all')->where(['users_email' => $answerData['users_email'], 'exhibition_id' => $id, 'status IS NOT' => 8])->toArray())) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                return $response;
            }
            
            if ($exhibition_user = $this->ExhibitionUsers->save($exhibitionUser)) {
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
                
                // if ($this->Auth->user() != null) {
                //     $user_id = $this->Auth->user('id');
                // } else {
                //     $user_id = null;
                // }
                
                foreach ($exhibitionSurveys as $exhibitionSurvey) {
                        
                    if (!$result = $connection->insert('exhibition_survey_users_answer', [
                        'exhibition_survey_id' => $exhibitionSurvey['id'],
                        'users_id' => $exhibition_user->id,
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
                
                $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');
                $exhibitionSurveyUsersAnswers = $ExhibitionSurveyUsersAnswer->find('all', ['contain' => 'ChildExhibitionSurveyUsersAnswer'])->where(['is_multiple' => 'Y', 'text' => 'question'])->toArray();
                
                foreach ($exhibitionSurveyUsersAnswers as $data) :
                    $answered = 0;
                    for ($i = 0; $i < count($data['child_exhibition_survey_users_answer']); $i++) {
                        if ($data['child_exhibition_survey_users_answer'][$i]['text'] == 'Y') {
                            $answered = 1;
                        } 
                    }
                    if ($answered == 0) {
                        $connection->delete('exhibition_survey_users_answer', ['id' => $data['id']]);
                        $connection->delete('exhibition_survey_users_answer', ['parent_id' => $data['id']]);
                    }
                endforeach;

                $exhibitionSurveyUsersAnswers = $ExhibitionSurveyUsersAnswer->find('all')->where(['is_multiple' => 'N', 'text IS' => ''])->toArray();
                foreach ($exhibitionSurveyUsersAnswers as $data) :
                    $connection->delete('exhibition_survey_users_answer', ['id' => $data['id']]);
                endforeach;

                $connection->commit();

                $mailer = new Mailer();
                $mailer->setTransport('mailjet');

                if (!empty($this->request->getData('exhibition_group_id'))) {
                    $to = $this->request->getData('users_email');
                    $Group = $this->getTableLocator()->get('ExhibitionGroup');
                    $group_id = $this->request->getData('exhibition_group_id');
                    $group = $Group->get($group_id);
                    $user_name = $this->request->getData('user_name');
                    
                    if ($exhibition->auto_approval == 0 || $exhibition->apply_edate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s', time()+32400)) :
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
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();

                    else :
                        $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - 참가확정 확인 메일입니다.')
                            ->viewBuilder()
                            ->setTemplate('webinar_apply_confirmed')
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
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();
                    endif;
                
                } else {
                    $to = $this->request->getData('users_email');
                    $user_name = $this->request->getData('user_name');
                    
                    if ($exhibition->auto_approval == 0 || $exhibition->apply_edate->format('Y-m-d H:i:s') < date('Y-m-d H:i:s', time()+32400)) :
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
                        $mailer->setViewVars(['group' => '']);
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();
                    
                    else :
                        $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - 참가확정 확인 메일입니다.')
                            ->viewBuilder()
                            ->setTemplate('webinar_apply_confirmed')
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
                        $mailer->setViewVars(['group' => '']);
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();
                    endif;
                }
                

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;

            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
        if ($group_id != null) :
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('all')->where(['id' => $group_id,'exhibition_id' => $id])->toArray();
        $amount = $exhibitionGroup[0]['amount'];
        else :
        $exhibitionGroup = '';
        $amount = 0;
        endif;
        $pay = $this->ExhibitionUsers->Pay->find('list', ['limit' => 200]);
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'survey_type' => 'B', 'parent_id Is' => null]);
        $user = $this->Auth->user();
        $this->set(compact('exhibitionUser', 'exhibition', 'exhibitionGroup', 'pay', 'exhibitionSurveys', 'id', 'user', 'amount', 'today', 'apply_sdate', 'apply_edate'));
    }

    public function existCheck($exhibition_id = null, $users_email = null) 
    {
        if (!empty($this->ExhibitionUsers->find('all')->where(['users_email' => $users_email, 'exhibition_id' => $exhibition_id, 'status IS NOT' => 8])->toArray())) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
            return $response;
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
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
            $session = $this->request->getSession();
            $email = $session->read('email');
            $hp = $session->read('hp');
            
            if (!empty($email)) {
                $this->paginate = ['limit' => 10];
                $today = date('Y-m-d H:i:s', time()+32400);

                if ($type == 'application') {
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_email' => $email, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate >' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                } elseif ($type == 'close'){
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_email' => $email, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                } elseif ($type == 'cancel') {
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_email' => $email, 'ExhibitionUsers.status' => 8])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                }

            } else if (!empty($hp)) {
                $this->paginate = ['limit' => 10];
                $today = date('Y-m-d H:i:s', time()+32400);

                if ($type == 'application') {
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_hp' => $hp, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate >' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                } elseif ($type == 'close'){
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_hp' => $hp, 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                } elseif ($type == 'cancel') {
                    $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_hp' => $hp, 'ExhibitionUsers.status' => 8])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
                }
                
            } else {
                return $this->redirect(['action' => 'certification']);
            }
        
        } else {
            $this->paginate = ['limit' => 10];
            $today = date('Y-m-d H:i:s', time()+32400);
            
            if ($type == 'application') {
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate >' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
            
            } elseif ($type == 'close'){
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status !=' => 8, 'Exhibition.edate <' => $today])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
            
            } elseif ($type == 'cancel') {
                $exhibition_users = $this->paginate($this->ExhibitionUsers->find('all', ['contain' => ['Exhibition', 'ExhibitionGroup', 'Pay']])->where(['ExhibitionUsers.users_id' => $this->Auth->user('id'), 'ExhibitionUsers.status' => 8])->order(['ExhibitionUsers.id' => 'DESC']))->toArray();
            }
        }
        
        $this->set(compact('exhibition_users'));
    }

    public function exhibitionUsersStatus()
    {
        $id = $this->request->getData('id');
        $exhibition_id = $this->request->getData('exhibition_id');
        $to = $this->request->getData('email');
        $pay_id = $this->request->getData('pay_id');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_user = $this->ExhibitionUsers->get($id);

        if($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {

            if (!$connection->delete('exhibition_survey_users_answer', ['users_id' => $id])) {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }

            if ($pay_id != '') {

                $Pay = $this->getTableLocator()->get('Pay');
                $pay = $Pay->get($pay_id);
                
                require_once(ROOT . "/iamport-rest-client-php/src/iamport.php");
                
                $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));
    
                $result = $iamport->cancel(array(
                    'imp_uid'		=> $pay->imp_uid, 		
                    'merchant_uid'	=> $pay->merchant_uid, 	
                    'amount' 		=> 0,				
                    'reason'		=> '행사 이용자 취소',			
                ));
                if ($result->success) {
                
                    $payment_data = $result->data;
                    $now = date('Y-m-d H:i:s', time()+32400);
                    
                    // $pay->cancel_reason = '행사 이용자 취소';
                    // $pay->cancel_date = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
                    
                    if ($connection->update('pay', ['cancel_reason' => '행사 이용자 취소', 'cancel_date' => $now], ['id' => $pay_id])) {
                        $connection->commit();
    
                        $mailer = new Mailer();
                        $mailer->setTransport('mailjet');

                        $exhibition_table = $this->getTableLocator()->get('Exhibition');
                        $exhibition = $exhibition_table->get($exhibition_id);
                        $user_name = $this->request->getData('users_name');           
                        
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
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    } else {
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    }
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                }
            } else {
                $mailer = new Mailer();
                $mailer->setTransport('mailjet');        

                $exhibition_table = $this->getTableLocator()->get('Exhibition');
                $exhibition = $exhibition_table->get($exhibition_id);
                $user_name = $this->request->getData('users_name');
                
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
                $mailer->setViewVars(['refund' => '0']);
                $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                
                $mailer->deliver();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }
    
    public function downloadPdf($exhibition_id = null, $exhibition_users_id = null)
    {   
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        $exhibitionUsers = $this->ExhibitionUsers->get($exhibition_users_id);

        $img_path = ROOT . '/webroot/images/h1-logo.png';
        $img_data = fopen ( $img_path, 'rb' );
        $img_size = filesize ( $img_path );
        $binary_image = fread ( $img_data, $img_size );
        fclose ( $img_data );
        $img_src = "data:image/png;base64,".str_replace ("\n", "", base64_encode($binary_image));

        $category = $this->getTableLocator()->get('CommonCategory')->get($exhibition->category)->title;
        
        if ($exhibition->cost == 'free') :
            $cost = '무료';
        else :
            $cost = $exhibitionUsers->pay_amount . '원';
        endif;

        $this->viewBuilder()->enableAutoLayout(false); 
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $this->viewBuilder()->setVars([
            'front_url' => FRONT_URL,
            'title' => $exhibition->title,
            'category' => $category,
            'type' => $exhibition->type,
            'cost' => $cost,
            'apply_date' => $exhibitionUsers->created,
            'sdate' => $exhibition->sdate,
            'edate' => $exhibition->edate,
            'users_name' => $exhibitionUsers->users_name,
            'users_email' => $exhibitionUsers->users_email,
            'users_hp' => $exhibitionUsers->users_hp,
            'name' => $exhibition->name,
            'tel' => $exhibition->tel,
            'email' => $exhibition->email,
            'img_src' => $img_src
        ]);

        $Pay = $this->getTableLocator()->get('Pay');
        if ($exhibitionUsers->pay_id != null) {
            $pay = $Pay->get($exhibitionUsers->pay_id);
            $this->viewBuilder()->setVars(['amount' => $pay->amount]);
        } else {
            $this->viewBuilder()->setVars(['amount' => 0]);
        }
        
        $this->viewBuilder()->setOption(
            'pdfConfig',
            [
                'orientation' => 'portrait',
                'defaultFont' => 'NanumGothic',
                'isHtml5ParserEnabled' => true, 
                'isRemoteEnabled' => true,
                'download' => true, // This can be omitted if "filename" is specified.
                'filename' => $exhibition->title . '_Report.pdf', //// This can be omitted if you want file name based on URL.
            ]
        ); 
    }

    public function certification($id = null)
    {
        if (!empty($this->Auth->user())) {
            $this->redirect(['action' => 'sign-up', 'application']);
        }
        $this->set(compact('id'));
    }

    public function sendSmsCertification()
    {        
        if ($this->request->is('post')) {
            
            require_once(ROOT . "/solapi-php/lib/message.php");
            
            $code = $this->generateCode();
            $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $CommonConfirmations->newEmptyEntity();
            $commonConfirmation = $CommonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

            if ($result = $CommonConfirmations->save($commonConfirmation)) {
                $to = $this->request->getData('hp');

                $messages = [
                    [
                        'to' => $to,
                        'from' => getEnv('EXON_PHONE_NUMBER'),
                        'text' => '[EXON] 본인인증 인증번호는 ' . $code . ' 입니다.' 
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
    }

    public function confirmSms($id = null) 
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                    $hp = $this->request->getData('hp');
                    $session = $this->request->getSession();
                    $session->write('hp', $hp);

                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;

                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            } else {
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
    }

    public function confirmEmail($id = null)
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {
                
                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                    $email = $this->request->getData('email');
                    $session = $this->request->getSession();
                    $session->write('email', $email);

                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;

                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function generateCode()
    {
        $characters = '123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)-1), 1);
        }
        return $code;
    }
}
