<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;

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

        $uri = substr($_SERVER['REQUEST_URI'], 0, 40);
        if ($uri != '/exhibition-stream/set-exhibition-stream') {
            $this->request->getSession()->delete('coupon_data');
            $this->request->getSession()->delete('stream_data');
        }
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
    public function setExhibitionStream($exhibition_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
        $exhibitionStream->exhibition_id = $exhibition_id;

        if ($this->request->getSession()->read('coupon_data')) {
            $data = $this->request->getSession()->read('coupon_data');
            $exhibitionStream->title = $data['title'];
            $exhibitionStream->description = $data['description'];
            $exhibitionStream->coupon_code = $data['coupon_code'];
            $exhibitionStream->time = $data['time'];
            $exhibitionStream->people = $data['people'];
            $exhibitionStream->amount = $data['amount'];
            $exhibitionStream->coupon_id = $data['coupon_id'];
            $exhibitionStream->coupon_amount = $data['coupon_amount'];
        }

        if ($this->request->getSession()->read('stream_data')) {
            $data = $this->request->getSession()->read('stream_data');
            $exhibitionStream->title = $data['title'];
            $exhibitionStream->description = $data['description'];
            $exhibitionStream->time = $data['time'];
            $exhibitionStream->people = $data['people'];
            $exhibitionStream->amount = $data['amount'];
            $exhibitionStream->stream_key = $data['stream_key'];
            $exhibitionStream->url = $data['stream_url'];
            $exhibitionStream->pay_id = $data['pay_id'];
        }
        
    
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionStream = $this->ExhibitionStream->patchEntity($exhibitionStream, $this->request->getData());
            
            if ($this->request->getData('coupon_code') != null && $this->request->getData('stream_key') == 0 && $this->request->getData('paid') == 0) {
                $coupon = $this->getTableLocator()->get('Coupon')->find()->where(['users_id' => $this->Auth->user()->id, 'product_type' => 'S', 'status' => 1])->toArray();
                $exist = 0;
                $coupon_id = 0;
                $coupon_amount = 0;
                $count = Count($coupon);
                $date = (int)FrozenTime::now()->format('Ymd');
                $start_date = 0;
                $end_date = 0;

                for ($i = 0; $i < $count; $i++) {
                    if ($coupon[$i]['code'] == $this->request->getData('coupon_code')) {
                        $coupon_id = $coupon[$i]['id'];
                        $coupon_amount = $coupon[$i]['amount']; 
                        $exist = 1;
                        $start_date = (int)$coupon[$i]['sdate'];
                        $end_date = (int)$coupon[$i]['edate'];
                    }
                }

                if ($exist == 1 && $start_date <= $date && $date <= $end_date) {
                    $title = $this->request->getData('title');
                    $description = $this->request->getData('description');
                    $coupon_code = $this->request->getData('coupon_code');
                    $time = $this->request->getData('time');
                    $people = $this->request->getData('people');
                    $amount = (int)$this->request->getData('amount')-$coupon_amount;

                    $coupon_data = [
                        'title' => $title,
                        'description' => $description,
                        'coupon_code' => $coupon_code,
                        'time' => $time,
                        'people' => $people,
                        'amount' => $amount,
                        'coupon_id' => $coupon_id,
                        'coupon_amount' => $coupon_amount
                    ];

                    $this->request->getSession()->write('coupon_data', $coupon_data);

                    $Coupon = $this->getTableLocator()->get('Coupon');
                    $coupon = $Coupon->get($coupon_id);
                    $coupon = $Coupon->patchEntity($coupon, ['status' => 4]);
                    if (!$Coupon->save($coupon)) {
                        $this->Flash->error(__('Could not change coupon status.'));
                    }

                    $this->Flash->success(__('The Coupon code has been confirmed.'));
                    return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id]);
                    
                } else {
                    $this->Flash->error(__('Invalid coupon code.'));
                }
            
            } else if ($this->request->getData('paid') == 1 && $this->request->getData('stream_key') == 0) {
                $stream_key = Text::uuid();
                $stream_url = 'rtmp://x.rtmp.exon.com/live1';
                $title = $this->request->getData('title');
                $description = $this->request->getData('description');
                $time = $this->request->getData('time');
                $people = $this->request->getData('people');
                $amount = $this->request->getData('amount');
                $paid = $this->request->getData('paid');
                $pay_id = $this->request->getData('id');

                $stream_data = [
                    'title' => $title,
                    'description' => $description,
                    'time' => $time,
                    'people' => $people,
                    'amount' => $amount,
                    'stream_key' => $stream_key,
                    'stream_url' => $stream_url,
                    'paid' => $paid,
                    'pay_id' => $pay_id
                ];
                $this->request->getSession()->write('stream_data', $stream_data);

                $this->Flash->success(__('The stream_key has been created.'));
                return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id]);
            
            } else {
                $exhibitionStream->ip = $this->Auth->user()->ip;
                if ($this->ExhibitionStream->save($exhibitionStream)) {
                    $this->Flash->success(__('The exhibition stream has been saved.'));
    
                    return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id]);
                }
                $this->Flash->error(__('The exhibition stream could not be saved. Please, try again.'));
            }
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

    // public function setTitleDescription($exhibition_id = null)
    // {   
    //     $connection = ConnectionManager::get('default');
    //     $connection->begin();

    //     if ($this->request->is('post')) {
    //         $title = $this->request->getData('title');
    //         $description = $this->request->getData('description');
            
    //         if ($result = $connection->insert('exhibition_stream', [
    //             'exhibition_id' => $exhibition_id,
    //             'title' => $title, 
    //             'description' => $description,
    //             'ip' => $this->Auth->user()->ip
    //         ])) {
    //             $this->Flash->success(__('The stream title&description has been saved.'));
    //             $stream_id = $result->lastInsertId();
    //             $connection -> commit();
    //             return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id, $stream_id]);
    //         }
    //         $this->Flash->error(__('The title&description could not be saved. Please, try again.'));
    //         $connection -> rollback();
    //         return $this->redirect(['action' => 'add', $id]);
    //     }
    // }
}
