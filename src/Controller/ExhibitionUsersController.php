<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;

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
    public function add($id = null)
    {
        $exhibitionUser = $this->ExhibitionUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionUser->exhibition_id = $id;
            $exhibitionUser = $this->ExhibitionUsers->patchEntity($exhibitionUser, $this->request->getData());
            if ($this->ExhibitionUsers->save($exhibitionUser)) {
                $this->Flash->success(__('The exhibition user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition user could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionUsers->Exhibition->find('list', ['limit' => 200]);
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('list', ['limit' => 200])->where(['exhibition_id' => $id]);
        $pay = $this->ExhibitionUsers->Pay->find('list', ['limit' => 200]);
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find()->select('text')->where(['exhibition_id' => $id]);
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
        $exhibitionGroup = $this->ExhibitionUsers->ExhibitionGroup->find('list', ['limit' => 200]);
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

    public function sendEmail()
    {
        $code = \Cake\Utility\Security::hash('user_name');
        $code = substr($code, 0, 6);

        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            try {
                // $host = HOST;
                // $sender = SEND_EMAIL;
                // $view = new \Cake\View\View($this->request, $this->response);
                // $view->set(compact('sender')); //이메일 템플릿에 파라미터 전달
                // $content = $view->element('email/findPw'); //이메일 템블릿 불러오기
                if ($res = $mailer->setFrom(['heh1009@livemolo.me' => 'Email Confirmation'])
                        ->setEmailFormat('html')
                    ->setTo($this->request->getData('email_address'))
                    ->setSubject('Exon Test Email')
                    ->deliver('Confirmation Code : ' . $code)) 
                    {
                        $this->Flash->success(__('The Email has been delivered.'));
                    
                    } else {
                        $this->Flash->error(__('The Email could not be delivered.'));
                    }

                    return $this->redirect(['action' => 'confirmEmail']);

            } catch (Exception $e) {
                // echo ‘Exception : ’,  $e->getMessage(), “\n”;
                echo json_encode(array("error"=>true, "msg"=>$e->getMessage()));exit;
            }
        }
    }

    public function confirmEmail()
    {
        $code = \Cake\Utility\Security::hash('user_name');
        $code = substr($code, 0, 6);

        if ($this->request->is('post')) {

            if ((string)$this->request->getData('code') == $code) {
                $this->Flash->success(__('The Email has been confirmed.'));
                return $this->redirect(['action' => 'index']);
            
            } else {
                $this->Flash->error(__('The wrong code.'));
            }
        }
   }  
}
