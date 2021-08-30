<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;

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

    //아임포트 콜백 처리, 결제 정보 DB 저장
    public function importPay() {
        
        $pay = $this->Pay->newEmptyEntity();
        
        if ($this->request->is('post')) {
            $merchant_uid = $this->request->getData('merchant_uid');
            $imp_uid = $this->request->getData('imp_uid');
            $pay_method = $this->request->getData('pay_method');
            $pay_amount = $this->request->getData('paid_amount');
            $coupon_amount = $this->request->getData('coupon_amount');
            $receipt_url = $this->request->getData('receipt_url');
            $pay_date = $this->request->getData('paid_at');
            $pg_tid = $this->request->getData('pg_tid');
            $data = [
                'product_type' => 'S',
                'users_id' => $this->Auth->user()->id,
                'ip' => $this->Auth->user()->ip,
                'merchant_uid' => $merchant_uid,
                'imp_uid' => $imp_uid,
                'pay_method' => $pay_method,
                'amount' => $pay_amount + $coupon_amount,
                'pay_amount' => $pay_amount,
                'coupon_amount' => $coupon_amount,
                'receipt_url' => $receipt_url,
                'pay_date' => $pay_date,
                'pg_tid' => $pg_tid,
                'status' => 4
            ];
            $pay = $this->Pay->patchEntity($pay, $data);
            
            if ($result = $this->Pay->save($pay)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'pay_id' => $result->id]));
                return $response;
            }
        }
    }
}
