<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Utility\Text;

/**
 * Coupon Controller
 *
 * @property \App\Model\Table\CouponTable $Coupon
 * @method \App\Model\Entity\Coupon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CouponController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test'])
    }

    public function index()
    {
        $this->paginate = [
            'contain' => ['Users'],
        ];
        $coupon = $this->paginate($this->Coupon);

        $this->set(compact('coupon'));
    }

    /**
     * View method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $coupon = $this->Coupon->get($id, [
            'contain' => ['Users', 'ExhibitionStream'],
        ]);

        $this->set(compact('coupon'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */

    //할인 쿠폰 발급
    public function add()
    {
        $coupon = $this->Coupon->newEmptyEntity();
        if ($this->request->is('post')) {
            $coupon = $this->Coupon->patchEntity($coupon, $this->request->getData());
            $coupon->code = Text::uuid();
            if ($this->Coupon->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
        }
        $users = $this->Coupon->Users->find('list', ['limit' => 200]);
        $this->set(compact('coupon', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $coupon = $this->Coupon->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $coupon = $this->Coupon->patchEntity($coupon, $this->request->getData());
            if ($this->Coupon->save($coupon)) {
                $this->Flash->success(__('The coupon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The coupon could not be saved. Please, try again.'));
        }
        $users = $this->Coupon->Users->find('list', ['limit' => 200]);
        $this->set(compact('coupon', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Coupon id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $coupon = $this->Coupon->get($id);
        if ($this->Coupon->delete($coupon)) {
            $this->Flash->success(__('The coupon has been deleted.'));
        } else {
            $this->Flash->error(__('The coupon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
