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
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user->email = $this->request->getData('email');
            $user->password = password_hash($this->request->getData('password'), PASSWORD_DEFAULT);
            $user->name = $this->request->getData('name');
            $user->hp = $this->request->getData('hp');
            $user->ip = $this->request->ClientIp();    
            if ($result = $this->Users->save($user)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                return $response;
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            return $response;
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id);

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

        $this->set(compact('user'));
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

    public function successJoin()
    {
        
    }

    public function naverJoin()
    {
        $client_id = getEnv('NAVER_CLIENT_ID');
        $client_secret = getEnv('NAVER_CLIENT_SECRET');
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode("http://121.126.223.225:8765/users/naverJoin");
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
                $query = $this->Users->findByName($responseArr['response']['id'])->toArray();

                if(count($query)) {
                    echo('로그인 진행');exit;
                } else {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->newEmptyEntity(); 
                    $user->email = $responseArr['response']['email'];
                    $user->name = $responseArr['response']['id'];
                    $user->hp = substr($responseArr['response']['mobile'], 0, 3).
                        substr($responseArr['response']['mobile'], 4, 4).
                        substr($responseArr['response']['mobile'], 9, 4);
                    $user->ip = $this->request->ClientIp();
                    $user->refer = 'naver';       
                    
                    if(!$Users->save($user)) {
                        echo("wrong!!");exit;
                    } else {
                        echo("success");exit;
                    }
                }
            } else {
                echo "Error 내용:".$response;
            }
        } else {
            echo "Error 내용:".$response;
        }
    }

    public function kakaoJoin()
    {
        $client_id = getEnv('KAKAO_CLIENT_ID');
        $redirect_uri = urlencode("http://121.126.223.225:8765/users/kakaoJoin");
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
                $query = $this->Users->findByName($responseArr['id'])->toArray();

                if(count($query)) {
                    echo('로그인 진행');exit;
                } else {
                    $Users = $this->getTableLocator()->get('Users');
                    $user = $Users->newEmptyEntity(); 
                    $user->email = $responseArr['kakao_account']['email'];
                    $user->name = $responseArr['id'];
                    $user->hp = '01011112222'; //카카오 사업자 계정 인증 후 수정
                    $user->ip = $this->request->ClientIp();
                    $user->refer = 'kakao';       
                    
                    if(!$Users->save($user)) {
                        echo("wrong!!");exit;
                    } else {
                        echo("success");exit;
                    }
                }
            } else {
                echo "Error 내용:".$response;
            }
        } else {
            echo "Error 내용:".$response;
        }
    }

    public function login(){

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

    }

    public function logout(){

        return $this->redirect($this->Auth->logout());
    }

    public function naverLogin()
    {
        $client_id = getEnv('NAVER_CLIENT_ID');
        $client_secret = getEnv('NAVER_CLIENT_SECRET');
        $code = $_GET["code"];
        $state = $_GET["state"];
        $redirectURI = urlencode("http://121.126.223.225:8765/users/naverLogin");
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
                $query = $this->Users->findByName($responseArr['response']['id'])->toArray();

                if(count($query)) {
                    $this->loadComponent('Auth');
                    $this->conn = ConnectionManager::get('default');

                    $user = $this->Users->find('all')                            
                    ->where(['email'=>$responseArr['response']['email'], 'status'=>1])
                    ->first();

                    $this->Auth->setUser($user);
                    $target = $this->Auth->redirectUrl() ?? '/home';
                    return $this->redirect($target);
                } else {
                    $this->Flash->error(__('회원 정보가 없습니다.'));
                    return $this->redirect("http://121.126.223.225:8765/users/add");
                }
            } else {
                echo "Error 내용:".$response;
            }
        } else {
            echo "Error 내용:".$response;
        }
    }

    public function kakaoLogin()
    {
        $client_id = getEnv('KAKAO_CLIENT_ID');
        $redirect_uri = urlencode("http://121.126.223.225:8765/users/kakaoLogin");
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
                $query = $this->Users->findByName($responseArr['id'])->toArray();

                if(count($query)) {
                    $this->loadComponent('Auth');
                    $this->conn = ConnectionManager::get('default');

                    $user = $this->Users->find('all')                            
                    ->where(['email'=>$responseArr['kakao_account']['email'], 'status'=>1])
                    ->first();

                    $this->Auth->setUser($user);
                    $target = $this->Auth->redirectUrl() ?? '/home';
                    return $this->redirect($target);
                } else {
                    $this->Flash->error(__('회원 정보가 없습니다.'));
                    return $this->redirect("http://121.126.223.225:8765/users/add");
                }
            } else {
                echo "Error 내용:".$response;
            }
        } else {
            echo "Error 내용:".$response;
        }
    }

    public function certification($id = null)
    {
        $this->set(compact('id'));
    }

    public function sendSmsCertification($user_id = null)
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
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $commonConfirmation_table = TableRegistry::get('CommonConfirmation');
        $commonConfirmation = $commonConfirmation_table->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {

                    if($connection->update('users', ['hp_cert' => '1'], ['id' => $this->request->getData('user_id')])) {
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
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function sendEmailCertification ($user_id = null) {
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
                        ->setTo($this->request->getData('email'))
                        ->setSubject('Exon Test Email')
                        ->deliver('Confirmation Code : ' . $code)) 
                        {
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                        return $response;
                    
                    } else {
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                        return $response;
                    }
    
                } catch (Exception $e) {
                    // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                    echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
                }
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
