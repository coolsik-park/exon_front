<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
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
        $client_id = "nruyRASkeHLeFK0ECeMz";
        $client_secret = "6ulHDFpc3y";
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
        $client_id = "9d9c1b3134751cfe60d042ba0bc24c19";
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
                    $user->hp = '01012341234';
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
}
