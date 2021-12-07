<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\Event\EventInterface;

class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test'])
    }
    
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }
    
    public function view($id = null)
    {
        echo($id);exit;
    }
    
    public function add()
    {
        $session = $this->request->getSession();
        $msg = $session->consume('msg');

        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user->email = $this->request->getData('email');
            $user->password = password_hash($this->request->getData('password'), PASSWORD_DEFAULT);
            $user->name = $this->request->getData('name');
            if ($this->request->getData('hp') != '010') :
            $user->hp = $this->request->getData('hp');
            else : 
                $user->hp = null;
            endif;
            $user->ip = $this->request->ClientIp();    
            if ($result = $this->Users->save($user)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                return $response;
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            return $response;
        }
        $this->set(compact('user', 'msg'));
    }

    public function edit()
    {
        $user = $this->Users->get($this->Auth->user('id'));
        $session = $this->request->getSession();
        $msg = $session->consume('connect_msg');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user->password = password_hash($this->request->getData('password'), PASSWORD_DEFAULT);
            $user->name = $this->request->getData('name');
            $user->birthday = date('Y-m-d', strtotime($this->request->getData('birthday')));
            $user->sex = $this->request->getData('sex');
            $user->company = $this->request->getData('company');
            $user->title = $this->request->getData('title');
            $user->ip = $this->request->ClientIp();

            if ($this->Users->save($user)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }
            return $response;
        }        

        $this->set(compact('user', 'msg'));
    }

    public function hpUpdate($id = null)
    {
        $user = $this->Users->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user->hp = $this->request->getData('hp');
            $user->hp_cert = '0';

            if ($this->Users->save($user)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }
            return $response;
        }

        $this->set(compact('user'));
    }

    public function imgUpdate($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        if ($this->request->is('post')) {
            $image = $this->request->getData('imgSaveButton');
            $imageName = $image->getClientFilename();
            $index = strpos(strrev($imageName), strrev('.'));
            $expen = strtolower(substr($imageName, ($index * -1)));
            $path = 'upload' . DS . 'users' . DS . date("Y") . DS . date("m");

            if (!file_exists(WWW_ROOT . $path)) {
                $oldMask = umask(0);
                mkdir(WWW_ROOT . $path, 0777, true);
                chmod(WWW_ROOT . $path, 0777);
                umask($oldMask);
            }

            $imageName = $id . "_users." . $expen;
            $destination = WWW_ROOT . $path . DS . $imageName;
            $image->moveTo($destination);

            if ($connection->update('users', ['image_path' => $path, 'image_name' => $imageName], ['id' => $id])) {
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }  
            return $response;
        }
    }

    public function imgDelete($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $user = $this->Users->get($id);

        if ($connection->update('users', ['image_path' => null, 'image_name' => null], ['id' => $id])) {
            $connection->commit();
            $path = WWW_ROOT . $user->image_path;
            unlink($path . DS . $user->image_name);
            if (file_exists($path)) {
                rmdir($path);
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        } else {
            $connection->rollback();
        }
        return $response;
    }
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function naverJoin()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('NAVER_CLIENT_ID');
        $client_secret = getEnv('NAVER_CLIENT_SECRET');
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode(NAVER_JOIN_URL);
        $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id.
            "&client_secret=".$client_secret.
            "&redirect_uri=".$redirectURI.
            "&code=".$code.
            "&state=".$state;
        $is_post = false;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $token = $responseArr['access_token'];
            $header = "Bearer ".$token;
            $url = "https://openapi.naver.com/v1/nid/me";
            $is_post = false;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');
                $query = $this->Users->findBySocialId($responseArr['response']['id'])->toArray();

                if(count($query)) {
                    $naver_redirectURI = urlencode(NAVER_LOGIN_URL);
                    $naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $naver_redirectURI . "&state=" . $state;
                    return $this->redirect($naver_apiURL);
                } else {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->newEmptyEntity(); 
                    $user->email = $responseArr['response']['email'];
                    $user->name = $responseArr['response']['name'];
                    $user->password = null;
                    $user->social_id = $responseArr['response']['id'];
                    $user->ip = $this->request->ClientIp();
                    $user->refer = 'naver';       
                    
                    if(!$result = $Users->save($user)) {
                        $session->write('msg', 'EXON 계정이 존재합니다. 로그인 후 마이페이지에서 연동을 진행해 주세요.');
                        return $this->redirect(['action' => 'login']);
                    } else {
                        return $this->redirect(['action' => 'certification', $result->id]);
                    }
                }
            } else {
                $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'join']);
            }
        } else {
            $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'join']);
        }
    }

    public function kakaoJoin()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('KAKAO_CLIENT_ID');
        $redirect_uri = urlencode(KAKAO_JOIN_URL);
        $grant_type="authorization_code";
        $code = $_GET["code"];
        $url = "https://kauth.kakao.com/oauth/token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $post_param = "grant_type=".$grant_type."&client_id=".$client_id."&redirect_uri=".$redirect_uri."&code=".$code;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $access_token = $responseArr['access_token'];
            $header = "Bearer ".$access_token;
            $headers = array();
            $headers[] = "Authorization: ".$header;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v2/user/me");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');
                $query = $this->Users->findBySocialId($responseArr['id'])->toArray();

                if(count($query)) {
                    $kakao_redirectURI = urlencode(KAKAO_LOGIN_URL);
                    $kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=" . $client_id . "&redirect_uri=" . $kakao_redirectURI;
                    return $this->redirect($kakao_apiURL);
                } else {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->newEmptyEntity(); 
                    $user->email = $responseArr['kakao_account']['email'];
                    $user->name = $responseArr['kakao_account']['profile']['nickname'];
                    $user->password = null;
                    $user->social_id = $responseArr['id'];
                    $user->ip = $this->request->ClientIp();
                    $user->refer = 'kakao';       
                    
                    if(!$result = $Users->save($user)) {
                        $session->write('msg', 'EXON 계정이 존재합니다. 로그인 후 마이페이지에서 연동을 진행해 주세요.');
                        return $this->redirect(['action' => 'login']);
                    } else {
                        return $this->redirect(['action' => 'certification', $result->id]);
                    }
                }
            } else {
                $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'join']);
            }
        } else {
            $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'join']);
        }
    }

    public function login(){
        $session = $this->request->getSession();
        $msg = $session->consume('msg');

        if ($this->request->is('post')) {
            $this->loadComponent('Auth');
            $this->conn = ConnectionManager::get('default'); 

            $hashPswdObj = new DefaultPasswordHasher; //비밀번호 암호화        
            $password = $hashPswdObj->hash($this->request->getData('password')); 
            
    
            $user = $this->Users->find('all')                            
                            ->where(['email'=>$this->request->getData('email'), 'status'=>1])
                            ->first();
       
            
            if($user && $hashPswdObj->check($this->request->getData('password'),$user->password)){
                $this->Auth->setUser($user);
                
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
        $this->set(compact('msg'));
    }

    public function logout(){

        return $this->redirect($this->Auth->logout());
    }

    public function naverLogin()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('NAVER_CLIENT_ID');
        $client_secret = getEnv('NAVER_CLIENT_SECRET');
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode(NAVER_LOGIN_URL);
        $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id.
            "&client_secret=".$client_secret.
            "&redirect_uri=".$redirectURI.
            "&code=".$code.
            "&state=".$state;
        $is_post = false;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $token = $responseArr['access_token'];
            $header = "Bearer ".$token;
            $url = "https://openapi.naver.com/v1/nid/me";
            $is_post = false;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');
                $query = $this->Users->findBySocialId($responseArr['response']['id'])->toArray();

                if(count($query)) {
                    $this->loadComponent('Auth');
                    $this->conn = ConnectionManager::get('default');

                    $user = $this->Users->find('all')                            
                    ->where(['social_id'=>$responseArr['response']['id'], 'status'=>1])
                    ->first();

                    $this->Auth->setUser($user);
                    $target = $this->Auth->redirectUrl() ?? '/home';
                    return $this->redirect($target);
                } else {
                    $session->write('msg', '네이버 연동이 필요합니다. 회원가입 또는 EXON 계정이 존재하는 경우 로그인 후 마이페이지에서 연동을 진행해 주세요.');
                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'login']);
            }
        } else {
            $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'login']);
        }
    }

    public function kakaoLogin()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('KAKAO_CLIENT_ID');
        $redirect_uri = urlencode(KAKAO_LOGIN_URL);
        $grant_type="authorization_code";
        $code = $_GET["code"];
        $url = "https://kauth.kakao.com/oauth/token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $post_param = "grant_type=".$grant_type."&client_id=".$client_id."&redirect_uri=".$redirect_uri."&code=".$code;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $access_token = $responseArr['access_token'];
            $header = "Bearer ".$access_token;
            $headers = array();
            $headers[] = "Authorization: ".$header;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v2/user/me");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');
                $query = $this->Users->findBySocialId($responseArr['id'])->toArray();

                if(count($query)) {
                    $this->loadComponent('Auth');
                    $this->conn = ConnectionManager::get('default');

                    $user = $this->Users->find('all')                            
                    ->where(['social_id'=>$responseArr['id'], 'status'=>1])
                    ->first();

                    $this->Auth->setUser($user);
                    $target = $this->Auth->redirectUrl() ?? '/home';
                    return $this->redirect($target);
                } else {
                    $session->write('msg', '카카오 연동이 필요합니다. 회원가입 또는 EXON 계정이 존재하는 경우 로그인 후 마이페이지에서 연동을 진행해 주세요.');
                    return $this->redirect(['action' => 'login']);
                }
            } else {
                $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'login']);
            }
        } else {
            $session->write('msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'login']);
        }
    }

    public function certification($users_id)
    {
        $id = $users_id;

        $this->set(compact('id'));
    }

    public function sendSmsCertification()
    {        
        if ($this->request->is('post')) {
            require_once(ROOT . "/solapi-php/lib/message.php");

            $code = $this->generateCode();
            $commonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $commonConfirmations->newEmptyEntity();
            $commonConfirmation = $commonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

            if ($result = $commonConfirmations->save($commonConfirmation)) {
                $to[0] = $this->request->getData('hp');

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

        $this->set(compact('user_id'));
    }

    public function confirmSms($id = null) 
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $commonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $commonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {

                    if($connection->update('users', ['hp_cert' => '1', 'hp' => $this->request->getData('hp')], ['id' => $this->request->getData('user_id')])) {
                        $connection->commit();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    
                    } else {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    }

                } else {
                    $connection->rollback();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                }
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
            }
        }
        return $response;
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
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                
                    if($connection->update('users', ['email_cert' => '1'], ['id' => $this->request->getData('user_id')])) {
                        $connection->commit();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                        return $response;
                    
                    } else {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                        return $response;
                    }

                } else {
                    $connection->rollback();
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
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)-1), 1);
        }
        return $code;
    }

    public function naverConnect()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('NAVER_CLIENT_ID');
        $client_secret = getEnv('NAVER_CLIENT_SECRET');
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode(NAVER_CONNECT_URL);
        $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id.
            "&client_secret=".$client_secret.
            "&redirect_uri=".$redirectURI.
            "&code=".$code.
            "&state=".$state;
        $is_post = false;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $headers = array();
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $token = $responseArr['access_token'];
            $header = "Bearer ".$token;
            $url = "https://openapi.naver.com/v1/nid/me";
            $is_post = false;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $headers[] = "Authorization: ".$header;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close ($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');

                $is_connected = $this->Users->findBySocialId($responseArr['response']['id'])->toArray();

                if (count($is_connected)) {
                    $session->write('connect_msg', '해당 네이버 계정은 이미 다른 EXON 계정과 연동되어있는 계정입니다.');
                    return $this->redirect(['action' => 'edit']);
                }
                $query = $this->Users->findById($session->consume('user_id'))->toArray();

                if(count($query)) {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->get($query[0]->id);
                    $user->social_id = $responseArr['response']['id'];
                    $user->hp = substr($responseArr['response']['mobile'], 0, 3).
                        substr($responseArr['response']['mobile'], 4, 4).
                        substr($responseArr['response']['mobile'], 9, 4);
                    $user->refer = 'naver';

                    if(!$Users->save($user)) {
                        $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                        return $this->redirect(['action' => 'edit']);
                    } else {
                        $session->write('connect_msg', '네이버 아이디와 연동되었습니다.');
                        return $this->redirect(['action' => 'edit']);
                    }
                } else {
                    $session->write('connect_msg', '가입정보 오류입니다. 관리자에게 문의해주세요.');
                    return $this->redirect(['action' => 'edit']);
                }
            } else {
                $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'edit']);
            }
        } else {
            $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'edit']);
        }
    }

    public function kakaoConnect()
    {
        $session = $this->request->getSession();

        $client_id = getEnv('KAKAO_CLIENT_ID');
        $redirect_uri = urlencode(KAKAO_CONNECT_URL);
        $grant_type="authorization_code";
        $code = $_GET["code"];
        $url = "https://kauth.kakao.com/oauth/token";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        $post_param = "grant_type=".$grant_type."&client_id=".$client_id."&redirect_uri=".$redirect_uri."&code=".$code;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_param);
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($status_code == 200) {
            $responseArr = json_decode($response, true);
            $access_token = $responseArr['access_token'];
            $header = "Bearer ".$access_token;
            $headers = array();
            $headers[] = "Authorization: ".$header;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://kapi.kakao.com/v2/user/me");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if($status_code == 200) {
                $responseArr = json_decode($response, true);
                $this->loadModel('Users');
                
                $is_connected = $this->Users->findBySocialId($responseArr['id'])->toArray();

                if (count($is_connected)) {
                    $session->write('connect_msg', '해당 카카오 계정은 이미 다른 EXON 계정과 연동되어있는 계정입니다.');
                    return $this->redirect(['action' => 'edit']);
                }
                $query = $this->Users->findById($session->consume('user_id'))->toArray();

                if(count($query)) {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->get($query[0]->id);
                    $user->social_id = $responseArr['id'];
                    $user->refer = 'kakao';

                    if(!$Users->save($user)) {
                        $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                        return $this->redirect(['action' => 'edit']);
                    } else {
                        $session->write('connect_msg', '카카오 아이디와 연동되었습니다.');
                        return $this->redirect(['action' => 'edit']);
                    }
                } else {
                    $session->write('connect_msg', '가입정보 오류입니다. 관리자에게 문의해주세요.');
                    return $this->redirect(['action' => 'edit']);
                }
            } else {
                $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
                return $this->redirect(['action' => 'edit']);
            }
        } else {
            $session->write('connect_msg', '오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.');
            return $this->redirect(['action' => 'edit']);
        }
    }

    public function findPassword ()
    {

    }

    public function findUser ($users_id = null)
    {
        $email = $this->request->getData('email');
        $users = $this->Users->find('all')->toArray();
        foreach($users as $user) :
            if ($user['email'] == $email) :
                $users_id = $user['id'];
            endif;
        endforeach;

        if ($users_id != null) :
            $data = $this->Users->get($users_id);
            if ($data->email_cert == 0 && $data->hp_cert == 0) {
                $cert = 0;
            } else if ($data->email_cert == 1 && $data->hp_cert == 0) {
                $cert = 1;
            } else if ($data->email_cert == 0 && $data->hp_cert == 1) {
                $cert = 2;
            } else if ($data->email_cert == 1 && $data->hp_cert == 1) {
                $cert = 4;
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist', 'users_id' => $users_id, 'cert' => $cert]));
            return $response;
        else :
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'not_exist']));
            return $response;
        endif;
    }

    public function pwdCert ($users_id = null, $cert = null)
    {
        if ($cert == 0) :
            $this->redirect(['action' => 'notCertified']);
        endif; 
        $this->set(compact('users_id', 'cert'));
    }

    public function notCertified ()
    {

    }

    public function pwdEmailCertification ($users_id = null)
    {
        $user = $this->Users->get($users_id);
        $to = $user->email;

        $mailer = new Mailer();
        $mailer->setTransport('mailjet');

        $code = $this->generateCode();
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->newEmptyEntity();
        $commonConfirmation = $CommonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' => $code, 'types' => 'email']);

        if ($result = $CommonConfirmations->save($commonConfirmation)) {
            $mailer->setEmailFormat('html')
                        ->setTo($to)
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

    public function pwdSmsCertification ($users_id = null)
    {
        require_once(ROOT . "/solapi-php/lib/message.php");

        $user = $this->Users->get($users_id);
        $to = $user->hp;

        $code = $this->generateCode();
        $commonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $commonConfirmations->newEmptyEntity();
        $commonConfirmation = $commonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

        if ($result = $commonConfirmations->save($commonConfirmation)) {

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

    public function pwdConfirm ($id = null)
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
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

    public function resetPassword ($users_id = null)
    {
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->get($users_id);
            $user->password = password_hash($this->request->getData('pwd'), PASSWORD_DEFAULT);

            if ($this->Users->save($user)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        } 
        $this->set(compact('users_id'));
    }
}
