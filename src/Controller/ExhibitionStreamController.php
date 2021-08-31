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
    
     //웨비나 송출  설정
    public function setExhibitionStream($exhibition_id = null)
    {
        $is_exist = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        if (count($is_exist) == 0) {
            $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
            $exhibitionStream->exhibition_id = $exhibition_id;
    
            //쿠폰 검증 후
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
                $exhibitionStream->tab = $data['tab'];
            }
    
            //스트림 키 발급 후
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
                $exhibitionStream->tab = $data['tab'];
            }
            
        
            if ($this->request->is(['patch', 'post', 'put'])) {
                $exhibitionStream = $this->ExhibitionStream->patchEntity($exhibitionStream, $this->request->getData());
                
                //쿠폰 확인
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
                        $tab = $this->request->getData('tab');
    
                        $coupon_data = [
                            'title' => $title,
                            'description' => $description,
                            'coupon_code' => $coupon_code,
                            'time' => $time,
                            'people' => $people,
                            'amount' => $amount,
                            'coupon_id' => $coupon_id,
                            'coupon_amount' => $coupon_amount,
                            'tab' => $tab
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
                
                //스트림 키 생성
                } else if ($this->request->getData('paid') == 1 && $this->request->getData('stream_key') == 0) {
                    $stream_key = Text::uuid(); //stream_key 생성 -> 스트리밍 api에 따라 변경
                    $stream_url = 'rtmp://x.rtmp.exon.com/live1'; //stream_url 생성
                    $title = $this->request->getData('title');
                    $description = $this->request->getData('description');
                    $time = $this->request->getData('time');
                    $people = $this->request->getData('people');
                    $amount = $this->request->getData('amount');
                    $paid = $this->request->getData('paid');
                    $pay_id = $this->request->getData('id');
                    $tab = $this->reqeust->getData('tab');
    
                    $stream_data = [
                        'title' => $title,
                        'description' => $description,
                        'time' => $time,
                        'people' => $people,
                        'amount' => $amount,
                        'stream_key' => $stream_key,
                        'stream_url' => $stream_url,
                        'paid' => $paid,
                        'pay_id' => $pay_id,
                        'tab' => $tab
                    ];
                    $this->request->getSession()->write('stream_data', $stream_data);
    
                    $this->Flash->success(__('The stream_key has been created.'));
                    return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id]);
                
                //저장
                } else {
                    $exhibitionStream->ip = $this->Auth->user()->ip;
                    if ($result = $this->ExhibitionStream->save($exhibitionStream)) {
    
                        $this->Flash->success(__('The exhibition stream has been saved.'));
        
                        return $this->redirect(['action' => 'setExhibitionStream', $exhibition_id]);
                    }
                    $this->Flash->error(__('The exhibition stream could not be saved. Please, try again.'));
                }
            }
        } else {
            return $this->redirect(['action' => 'editExhibitionStream', $exhibition_id]);
        }
        
       
        $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs'));
    }
    public function speakerMenu ($id = null) 
    {
        $this->set(compact('id'));
    }

    public function setSpeaker ($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
    
        $displayes = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id])->toArray();
        
        if ($this->request->is('post')) {
            
            $entities = $ExhibitionSpeaker->newEntities($this->request->getData());
            $i = 0;
            foreach ($entities as $entity) {
                if ($result = $ExhibitionSpeaker->save($entity)) {
                    
                    $img = $this->request->getData('image' . $i);
                    $i++;
                    $imgName = $img->getClientFilename();

                    if ($imgName != '') {
                        $index = strpos(strrev($imgName), strrev('.'));
                        $expen = strtolower(substr($imgName, ($index * -1)));
                        $path = 'upload' . DS . 'speaker' . DS . date("Y") . DS . date("m");

                        if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                                
                            if (!file_exists(WWW_ROOT . $path)) {
                                $oldMask = umask(0);
                                mkdir(WWW_ROOT . $path, 0777, true);
                                chmod(WWW_ROOT . $path, 0777);
                                umask($oldMask);
                            }

                            $imgName = $result->id . "_speaker." . $expen;
                            $destination = WWW_ROOT . $path . DS . $imgName;
                            
                            if ($connection->update('exhibition_speaker', ['image_path' => $path, 'image_name' => $imgName], ['id' => $result->id])) {
                                $img->moveTo($destination);
                            } else {
                                $connection->rollback(); 
                                $this->Flash->error(__('The exhibition speaker could not be saved.'));
                            }
                        } else {
                            $connection->rollback(); 
                            $this->Flash->error(__('The exhibition speaker could not be saved.'));
                        }
                    }
                }
            }
            $connection->commit();
            $this->Flash->success(__('The exhibition speaker has been saved.'));
            return $this->redirect(['action' => 'setExhibitionStream', $id]); 
        }
        $this->set(compact('displayes', 'id'));
    }

    public function setAnswered ($id = null)
    {

    }

    public function answered ($id = null)
    {

    }

    // public function setTab()
    // {
    //     if ($this->request->is('post')) {
    //         $tab_title = $this->request->getData('tab_title');
    //         $is_on = $this->request->getData('is_on');
    //         $value = $this->request->getData('value');
    //         $stream_id = $this->request->getData('stream_id');

    //         $exhibitionStream = $this->ExhibitionStream->get($stream_id);
    //         if ($is_on == 0) {
    //             $exhibitionStream->tab = $exhibitionStream->tab - $value;
    //         } else {
    //             $exhibitionStream->tab = $exhibitionStream->tab + $value;
    //         }

    //         if ($this->ExhibitionStream->save($exhibitionStream)) {
    //             $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
    //             return $response;
    //         }        
    //     }
    // }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Stream id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editExhibitionStream($exhibition_id = null)
    {
        $stream_id = $this->ExhibitionStream->find()->select(['id'])->where(['exhibition_id' => $exhibition_id])->toArray()[0]->id;
        $exhibitionStream = $this->ExhibitionStream->get($stream_id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionStream = $this->ExhibitionStream->patchEntity($exhibitionStream, $this->request->getData());
            if ($this->ExhibitionStream->save($exhibitionStream)) {
                $this->Flash->success(__('The exhibition stream has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition stream could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray(); 
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition Stream id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionStream = $this->ExhibitionStream->get(['exhibition_id' => $id]);
        if ($this->ExhibitionStream->delete($exhibitionStream)) {
            $this->Flash->success(__('The exhibition stream has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition stream could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

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
