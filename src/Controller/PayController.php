<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pay Controller
 *
 * @property \App\Model\Table\PayTable $Pay
 * @method \App\Model\Entity\Pay[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayController extends AppController
{
    // public function initialize(): void
    // {
    //     parent::initialize();
    //     $this->loadComponent('RequestHandler');
    // }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Managers'],
        ];
        $pay = $this->paginate($this->Pay);

        $this->set(compact('pay'));
    }

    /**
     * View method
     *
     * @param string|null $id Pay id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pay = $this->Pay->get($id, [
            'contain' => ['Users', 'Managers', 'ExhibitionStream', 'ExhibitionUsers'],
        ]);

        $this->set(compact('pay'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    // public function add()
    // {
    //     $pay = $this->Pay->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $pay = $this->Pay->patchEntity($pay, $this->request->getData());
    //         if ($this->Pay->save($pay)) {
    //             $this->Flash->success(__('The pay has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The pay could not be saved. Please, try again.'));
    //     }
    //     $users = $this->Pay->Users->find('list', ['limit' => 200]);
    //     $managers = $this->Pay->Managers->find('list', ['limit' => 200]);
    //     $this->set(compact('pay', 'users', 'managers'));
    // }

    // /**
    //  * Edit method
    //  *
    //  * @param string|null $id Pay id.
    //  * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function edit($id = null)
    // {
    //     $pay = $this->Pay->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $pay = $this->Pay->patchEntity($pay, $this->request->getData());
    //         if ($this->Pay->save($pay)) {
    //             $this->Flash->success(__('The pay has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The pay could not be saved. Please, try again.'));
    //     }
    //     $users = $this->Pay->Users->find('list', ['limit' => 200]);
    //     $managers = $this->Pay->Managers->find('list', ['limit' => 200]);
    //     $this->set(compact('pay', 'users', 'managers'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Pay id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $pay = $this->Pay->get($id);
    //     if ($this->Pay->delete($pay)) {
    //         $this->Flash->success(__('The pay has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The pay could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function importPay() {
        $pay = $this->Pay->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $merchant_uid = $this->request->getData('merchant_uid');
            $data = [
                'product_type' => 'S',
                'users_id' => $this->Auth->user()->id,
                'merchant_uid' => $merchant_uid
            ];
            $pay = $this->Pay->patchEntity($pay, $data);
            
            if ($this->Pay->save($pay)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response; 
            } 
        }
    }
}
