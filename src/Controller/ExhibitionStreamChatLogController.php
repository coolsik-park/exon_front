<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;

/**
 * ExhibitionStreamChatLog Controller
 *
 * @property \App\Model\Table\ExhibitionStreamChatLogTable $ExhibitionStreamChatLog
 * @method \App\Model\Entity\ExhibitionStreamChatLog[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionStreamChatLogController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);

        $this->Auth->allow();

    }

    /**
     * Chat Door method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function chatDoor()
    {

        // echo("<pre>");print_r($_SERVER);
        
    }

    public function chat($exhibition_id = null, $now = null, $exhibition_users_id = null)
    {

        // if(!$this->getRequest()->getData('name')){

        //     return $this->redirect($this->referer());
        // }
        // else{

        //세션 생성 (샘플이므로 별도 세션 생성, 원래는 로그인 정보로 이용)
        $user_name = '';
        if ($this->Auth->user('name') == null) {
            $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
            $users_name = $ExhibitionUsers->get($exhibition_users_id)->users_name;
        
        } else {
            $users_name = $this->Auth->user('name');
        }   
        
        $this->getRequest()->getSession()->write('Chat.UserName', $users_name);

        // $ExhibitionStream = $this->getTableLocator()->get('ExhibitionStream');
        // $exhibitionStream = $ExhibitionStream->find()->select(['id'])->where(['exhibition_id' => $exhibition_id])->toArray();
        // if (count($exhibitionStream) != 0) {
        //     $exhibition_stream_id = $exhibitionStream[0]['id'];
        //     $this->getRequest()->getSession()->write('Chat.StreamId', $exhibition_stream_id);
        // } else {
        //     echo "스트리밍 개설 전입니다.";
        // }
        
            
        // }
        $ExhibitionStream = $this->getTableLocator()->get('ExhibitionStream');
        $exhibitionStream = $ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        if (count($exhibitionStream) != 0) {
            $stream_id = $exhibitionStream[0]['id'];
            $this->set(compact('stream_id', 'now', 'exhibition'));
        }
    }

    public function chatOut()
    {

        $this->getRequest()->getSession()->destroy('Chat.UserName');
        $this->getRequest()->getSession()->destroy('Chat.StreamId');
        // return $this->redirect('ExhibitionStreamChatLog/chatDoor');

    }

    public function chatLog($stream_id = null)
    {

        $username = $this->getRequest()->getSession()->read('Chat.UserName');
        $text = $this->getRequest()->getData('text');

        if(isset($username) && isset($text) && $text != ''){         
            
            $ChatLogs = $this->getTableLocator()->get('ExhibitionStreamChatLog');
            $chat = $ChatLogs->newEmptyEntity();
    
            // $chat->exhibition_stream_id = $this->getRequest()->getSession()->read('Chat.StreamId');
            $chat->exhibition_stream_id = $stream_id;

            if (!empty($this->Auth->user())) {
                $chat->users_id = $this->Auth->user('id');   
            }
            $chat->user_name = $username;
            $chat->message = $text;
    
            if(!$ChatLogs->save($chat))
            {
                echo("wrong!!");exit;
            }
             
            // $text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$username."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
             
            // file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/upload/chat/log.html", $text_message, FILE_APPEND | LOCK_EX);

        }
        exit;
    }

    public function getChatLog($last_id = null, $stream_id = null, $now = null)
    {
        $this->loadModel('ExhibitionStreamChatLog');

        $chat = $this->ExhibitionStreamChatLog->find('all')
                        ->select(['id', 'user_name', 'message','created'])
                        ->where(['exhibition_stream_id'=>$stream_id, 'id >'=>$last_id])
                        ->enableHydration(false)
                        ;



        //'created >' => strtotime($now)
        $view = new \Cake\View\View($this->request, $this->response);                                
        $view->set('message', $chat->toArray());
        $contents = $view->element('chat'); 

        echo json_encode(array("error"=>false , 'contents' =>$contents, 'last_id'=> ($chat->last()['id'])?$chat->last()['id']:$last_id));
        exit;
    }

    public function chatNotExist()
    {
        
    }
}
