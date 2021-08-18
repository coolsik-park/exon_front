<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test'])
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        echo($id);exit;
    }
    
    
    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            $user->ip = $this->request->ClientIp();    
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'successJoin']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
                $target = $this->Auth->redirectUrl() ?? '/home';
                return $this->redirect($target);
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
}
