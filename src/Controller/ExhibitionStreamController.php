<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * ExhibitionStream Controller
 *
 * @property \App\Model\Table\ExhibitionStreamTable $ExhibitionStream
 * @method \App\Model\Entity\ExhibitionStream[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionStreamController extends AppController
{
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
        // $this->paginate = [
        //     'contain' => ['Exhibition', 'Pay', 'Coupon'],
        // ];
        $exhibitionStream = $this->paginate($this->ExhibitionStream->find()->where(['exhibition_id' => 275]));
        // debug($this->ExhibitionStream);
        $this->set(compact('exhibitionStream'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition Stream id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($id, [
            'contain' => ['Exhibition', 'Pay', 'Coupon', 'ExhibitionStreamChatLog'],
        ]);

        $this->set(compact('exhibitionStream'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function setExhibitionStream($exhibition_id = null, $stream_id = null)
    {
        if ($stream_id == null) {
            $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
            $exhibitionStream->exhibition_id = $exhibition_id;
        } else {
            $exhibitionStream = $this->ExhibitionStream->get($stream_id);
            $exhibitionStream->id = $stream_id;
        }   
    
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionStream = $this->ExhibitionStream->patchEntity($exhibitionStream, $this->request->getData());
            
            if ($this->request->getData('coupon_code') != null && $this->request->getData('stream_key') == 0) {
                $coupon = $this->getTableLocator()->get('Coupon')->find()->where(['users_id' => $this->Auth->user()->id, 'product_type' => 'S'])->toArray();
                $exist = 0;
                $discount = 0;
                $count = Count($coupon);

                for ($i = 0; $i < $count; $i++) {
                    if ($coupon[$i]['code'] == $this->request->getData('coupon_code')) {
                        $exist = 1;
                        $discount = $coupon[$i]['amount'];
                    }
                }

                if ($exist == 1) {
                    $exhibitionStream->amount = (int)$this->request->getData('amount')-$discount;

                    if (!$this->ExhibitionStream->save($exhibitionStream)) {
                        $this->Flash->error(__('The Coupon code could not be confirmed.'));
                    }

                } else {
                    $this->Flash->error(__('Invalid coupon code.'));
                }
                return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id, $stream_id]);
            }
            
            if ($this->ExhibitionStream->save($exhibitionStream)) {
                $this->Flash->success(__('The exhibition stream has been saved.'));

                return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id, $stream_id]);
            }
            $this->Flash->error(__('The exhibition stream could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Stream id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function edit($id = null)
    // {
    //     $exhibitionStream = $this->ExhibitionStream->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $exhibitionStream = $this->ExhibitionStream->patchEntity($exhibitionStream, $this->request->getData());
    //         if ($this->ExhibitionStream->save($exhibitionStream)) {
    //             $this->Flash->success(__('The exhibition stream has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The exhibition stream could not be saved. Please, try again.'));
    //     }
    //     $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
    //     $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
    //     $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
    //     $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon'));
    // }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Exhibition Stream id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $exhibitionStream = $this->ExhibitionStream->get(['exhibition_id' => $id]);
    //     if ($this->ExhibitionStream->delete($exhibitionStream)) {
    //         $this->Flash->success(__('The exhibition stream has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The exhibition stream could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }

    public function setTitleDescription($exhibition_id = null)
    {   
        $connection = ConnectionManager::get('default');
        $connection->begin();

        if ($this->request->is('post')) {
            $title = $this->request->getData('title');
            $description = $this->request->getData('description');
            
            if ($result = $connection->insert('exhibition_stream', [
                'exhibition_id' => $exhibition_id,
                'title' => $title, 
                'description' => $description,
                'ip' => $this->Auth->user()->ip
            ])) {
                $this->Flash->success(__('The stream title&description has been saved.'));
                $stream_id = $result->lastInsertId();
                $connection -> commit();
                return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id, $stream_id]);
            }
            $this->Flash->error(__('The title&description could not be saved. Please, try again.'));
            $connection -> rollback();
            return $this->redirect(['action' => 'add', $id]);
        }
    }
}
