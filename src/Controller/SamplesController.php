<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;

/**
 * Samples Controller
 *
 * @property \App\Model\Table\SamplesTable $Samples
 * @method \App\Model\Entity\Sample[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SamplesController extends AppController
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


    /**
     * Chat   method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function chat()
    {

        if(!$this->getRequest()->getData('name')){

            return $this->redirect($this->referer());
        }
        else{

            //세션 생성 (샘플이므로 별도 세션 생성, 원래는 로그인 정보로 이용)
            $this->getRequest()->getSession()->write('Chat.UserName',$this->getRequest()->getData('name'));
            
        }
    }

    /**
     * Chat  out
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function chatOut()
    {

        $this->getRequest()->getSession()->destroy();
        return $this->redirect('Samples/chatDoor');

    }

    /**
     * Chat Log Set
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function chatLog()
    {

        $username = $this->getRequest()->getSession()->read('Chat.UserName');
        $text = $this->getRequest()->getData('text');

        if(isset($username) && isset($text)){         
            
            $ChatLogs = $this->getTableLocator()->get('ExhibitionStreamChatLog');
            $chat = $ChatLogs->newEmptyEntity();
    
            $chat->exhibition_stream_id = 1;
            $chat->users_id = 1;
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

     /**
     * Chat Log Get
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function getChatLog($last_id=1)
    {
        
        $this->loadModel('ExhibitionStreamChatLog');

        $chat = $this->ExhibitionStreamChatLog->find('all')
                        ->select(['id', 'user_name', 'message','created'])
                        ->where(['exhibition_stream_id'=>1, 'id >'=>$last_id])
                        ->enableHydration(false)
                        ;


        $view = new \Cake\View\View($this->request, $this->response);                                
        $view->set('message', $chat->toArray());
        $contents = $view->element('chat'); 

        echo json_encode(array("error"=>false , 'contents' =>$contents, 'last_id'=> ($chat->last()['id'])?$chat->last()['id']:$last_id));
        exit;

    }


}
