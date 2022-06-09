<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;
use Cake\Event\EventInterface;
use Cake\Mailer\Mailer;
use Cake\ORM\TableRegistry;

class ExhibitionStreamController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        $this->Auth->deny(['setExhibitionStream']);
        $this->Auth->deny(['editExhibitionStream']);
    }

    public function isAuthorized() {
        if(!empty($this->Auth->user('id'))) {
            return true;
        }
        // Default deny
        return parent::isAuthorized($user);
    }
    
    public function index()
    {
        // $this->paginate = [
        //     'contain' => ['Exhibition', 'Pay', 'Coupon'],
        // ];
        $exhibitionStream = $this->paginate($this->ExhibitionStream->find()->where(['exhibition_id' => 275]));
        // debug($this->ExhibitionStream);
        $this->set(compact('exhibitionStream'));
    }
    
    public function view($id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($id, [
            'contain' => ['Exhibition', 'Pay', 'Coupon', 'ExhibitionStreamChatLog'],
        ]);
        // debug($exhibitionStream);

        $this->set(compact('exhibitionStream'));
    }
    
     //웨비나 송출  설정
    public function setExhibitionStream($exhibition_id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]); 
        }
        if ($exhibition->is_event == 1) {
            return $this->redirect([
                'action' => 'setEventStream', $exhibition_id
            ]);
        }

        $users_id = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->users_id;
        $title = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->title;
        if ($this->Auth->user('id') != $users_id) {
            $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        $is_exist = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        if (count($is_exist) == 0) {
            $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
    
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                
                $exhibitionStream->exhibition_id = $exhibition_id;
                if ($data['pay_id'] != 0) {
                    $exhibitionStream->pay_id = $data['pay_id'];
                }
                if ($data['coupon_id'] != "0") :
                $exhibitionStream->coupon_id = $data['coupon_id'];
                endif;
                $exhibitionStream->title = $data['title'];
                $exhibitionStream->description = $data['description'];
                $exhibitionStream->stream_key = $data['stream_key'];
                $exhibitionStream->time = $data['time'];
                $exhibitionStream->people = $data['people'];
                $exhibitionStream->amount = (int)str_replace(",", "", $data['amount']);
                $exhibitionStream->coupon_amount = $data['coupon_amount'];
                $exhibitionStream->url = $data['url'];
                $exhibitionStream->ip = $this->Auth->user('ip');
                $exhibitionStream->tab = $data['tab'];
                if (!empty($data['is_download'])) :
                $exhibitionStream->is_download = $data['is_download'];
                endif;

                if (!$this->ExhibitionStream->save($exhibitionStream)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response; 
                }
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
            
        } else {
            return $this->redirect(['action' => 'editExhibitionStream', $exhibition_id]);
        }
        
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $user = $this->Auth->user();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices', 'title', 'user'));
    }

    public function watchExhibitionStream($id = null, $exhibition_users_id = null, $cert = null) 
    {   
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }

        if ($exhibition->is_event == 1) {
            return $this->redirect([
                'action' => 'watchEventStream', $id, $exhibition_users_id, $cert
            ]);
        }

        if (empty($exhibitionStream) || $exhibitionStream[0]['live_started'] == null) {
            $this->redirect(['action' => 'stream_not_exist']);
        } 
        
        if (strtotime($exhibition->sdate->format('Y-m-d H:i:s')) - 1800 - strtotime(date('Y-m-d H:i:s', time()+32400)) > 0) {
            $this->redirect(['action' => 'stream_not_exist']);
        }

        if (empty($this->Auth->user()) && $exhibition_users_id == null) {
            $this->redirect(['action' => 'certification', $id]);
        }

        // if ($exhibition->require_cert == 1 && $cert != 1) {
        //     $this->redirect(['action' => 'certification', $id]);
        // }

        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $front_url = FRONT_URL;
        $this->set(compact('exhibitionStream', 'tabs', 'exhibition_users_id', 'front_url', 'exhibition'));
    }

    public function watchExhibitionStreamMasterKey($id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();

        if (empty($exhibitionStream) || $exhibitionStream[0]['live_started'] == null) {
            $this->redirect(['action' => 'stream_not_exist']);
        } 
        
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $front_url = FRONT_URL;
        $this->set(compact('exhibitionStream', 'tabs', 'front_url'));
    }

    public function questionMenu ($id = null) 
    {
        $this->set(compact('id'));
    }

    public function setSpeaker ($id = null)
    {
        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
        
        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'image') {
                $img = $this->request->getData()['image'];
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'speaker_temp' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    // $imgName = $this->Auth->user('id') . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);

                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'path' => $path, 'imgName' => $imgName]));
                    return $response;

                }else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => '이미지 확장자명을 확인해주세요.',]));
                    return $response;
                }
            } else {
                $connection = ConnectionManager::get('default');
                $connection->begin();

                $names = $this->request->getData('names');
                $images = $this->request->getData('images');
                $speaker_dels = $this->request->getData("speaker_dels");
            
                if (!empty($names)) {
                    $count = count($names);
                
                    for ($i = 0; $i < $count; $i++) {
                        $exhibitionSpeaker = $ExhibitionSpeaker->newEmptyEntity();
                        $exhibitionSpeaker->name = $names[$i];
                        $exhibitionSpeaker->exhibition_id = $id;
                        
                        if ($result = $ExhibitionSpeaker->save($exhibitionSpeaker)) {
                            $img = $images[$i];
                            
                            if ($img != 'undefined') {
                                $imgName = $img->getClientFilename();
                                $index = strpos(strrev($imgName), strrev('.'));
                                $expen = strtolower(substr($imgName, ($index * -1)));
                                $path = 'upload' . DS . 'speaker' . DS . date("Y") . DS . date("m");
    
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
                                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                    return $response;
                                }
                            }
                            
                        } else {
                            $connection->rollback();
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                            return $response;
                        }
                    }
                }

                if (!empty($speaker_dels)) {
                    $count = count($speaker_dels);

                    for ($i = 0; $i < $count; $i ++) {

                        if ($speaker_dels[$i] != 0) {
                            $exhibitionSpeaker = $ExhibitionSpeaker->get($speaker_dels[$i]);
                            if (!$ExhibitionSpeaker->delete($exhibitionSpeaker)) {
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }
                }
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
        $displays = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id, 'is_vod' => 0]);
        $this->set(compact('id', 'displays'));
    }

    public function setAnswered ($id = null)
    {
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])->select(['ExhibitionQuestion.parent_id'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 0])->toArray();
        
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';
        
        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        if ($answeredQuestionId[0] != '') {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
                ->where(['ExhibitionQuestion.id NOT IN' => $answeredQuestionId, 'ExhibitionQuestion.contents IS NOT' => '답변완료', 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 0])->toArray();
        } else {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.contents IS NOT' => '답변완료', 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 0])->toArray();
        }
        
        
        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'answered') {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $exhibitionQuestion->exhibition_users_id = $this->request->getData('users_id');
                $exhibitionQuestion->parent_id = $this->request->getData('parent_id');
                $exhibitionQuestion->contents = '답변완료';
                $ExhibitionQuestion->save($exhibitionQuestion);
            } else {
                $exhibitionQuestion = $ExhibitionQuestion->get($this->request->getData('id'));
                $ExhibitionQuestion->delete($exhibitionQuestion);
            }
        }

        $this->set(compact('exhibitionQuestions', 'id'));
    }

    public function answered ($id = null)
    {
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])->select(['ExhibitionQuestion.parent_id'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 0])->toArray();
    
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.id IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 0])->toArray();

        $this->set(compact('exhibitionQuestions', 'id'));
    }

    public function vodQuestionMenu ($id = null) 
    {
        $this->set(compact('id'));
    }

    public function vodSetQuestion($id = null, $exhibition_users_id = null) {
        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
        $exhibitionSpeakers = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id, 'is_vod' => 1])->toArray();
        
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find()->select(['id'])->where(['exhibition_id' => $id])->toArray();
        
        if (count($exhibitionUsers) != 0) {
            $i = 0;
            foreach ($exhibitionUsers as $user) {
                $users_id[$i] = $user['id'];
                $i++;
            }
        } else {
            $users_id[] = '';
        }
        
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();
        $exhibitionQuestions = $ExhibitionQuestion->find('all')->where(['parent_id IS' => null, 'exhibition_users_id IN' => $users_id, 'is_vod' => 1])->toArray();

        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'delete') {

                $exhibitionQuestion = $ExhibitionQuestion->get($this->request->getData('id'));
                if ($ExhibitionQuestion->delete($exhibitionQuestion)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            
            } else {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $speaker_id = $this->request->getData('target');
                
                $exhibitionQuestion->exhibition_users_id = $exhibition_users_id;
                
                if ($speaker_id != 'all') {
                    $exhibitionQuestion->target_users_id = $speaker_id;
                    $users_name = $ExhibitionSpeaker->find()->select(['name'])->where(['id' => $speaker_id])->toArray();
                    $exhibitionQuestion->target_users_name = $users_name[0]['name'];
                    $exhibitionQuestion->is_vod = 1;
                }
                
                $exhibitionQuestion->contents = $this->request->getData('question');
                $exhibitionQuestion->is_vod = 1;
               
                if ($ExhibitionQuestion->save($exhibitionQuestion)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }
        $current_user_id = $this->Auth->user('id');
        $this->set(compact('exhibitionSpeakers', 'exhibitionQuestions', 'ExhibitionUsers', 'id', 'current_user_id', 'exhibition_users_id', 'answeredQuestions'));
    }

    public function vodSetSpeaker ($id = null)
    {
        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
        
        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'image') {
                $img = $this->request->getData()['image'];
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'speaker_temp' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    // $imgName = $this->Auth->user('id') . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);

                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'path' => $path, 'imgName' => $imgName]));
                    return $response;

                }else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => '이미지 확장자명을 확인해주세요.',]));
                    return $response;
                }
            } else {
                $connection = ConnectionManager::get('default');
                $connection->begin();

                $names = $this->request->getData('names');
                $images = $this->request->getData('images');
                $speaker_dels = $this->request->getData("speaker_dels");
            
                if (!empty($names)) {
                    $count = count($names);
                
                    for ($i = 0; $i < $count; $i++) {
                        $exhibitionSpeaker = $ExhibitionSpeaker->newEmptyEntity();
                        $exhibitionSpeaker->name = $names[$i];
                        $exhibitionSpeaker->exhibition_id = $id;
                        $exhibitionSpeaker->is_vod = 1;
                        
                        if ($result = $ExhibitionSpeaker->save($exhibitionSpeaker)) {
                            $img = $images[$i];
                            
                            if ($img != 'undefined') {
                                $imgName = $img->getClientFilename();
                                $index = strpos(strrev($imgName), strrev('.'));
                                $expen = strtolower(substr($imgName, ($index * -1)));
                                $path = 'upload' . DS . 'speaker' . DS . date("Y") . DS . date("m");
    
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
                                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                    return $response;
                                }
                            }
                            
                        } else {
                            $connection->rollback();
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                            return $response;
                        }
                    }
                }

                if (!empty($speaker_dels)) {
                    $count = count($speaker_dels);

                    for ($i = 0; $i < $count; $i ++) {

                        if ($speaker_dels[$i] != 0) {
                            $exhibitionSpeaker = $ExhibitionSpeaker->get($speaker_dels[$i]);
                            if (!$ExhibitionSpeaker->delete($exhibitionSpeaker)) {
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }
                }
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
        $displays = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id, 'is_vod' => 1]);
        $this->set(compact('id', 'displays'));
    }

    public function vodSetAnswered ($id = null)
    {
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])->select(['ExhibitionQuestion.parent_id'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();
        
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';
        
        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        if ($answeredQuestionId[0] != '') {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
                ->where(['parent_id IS' => null, 'ExhibitionQuestion.id NOT IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();
        } else {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['parent_id IS' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();
        }
        
        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'answered') {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $exhibitionQuestion->exhibition_users_id = $this->request->getData('users_id');
                $exhibitionQuestion->parent_id = $this->request->getData('parent_id');
                $exhibitionQuestion->contents = $this->request->getData('contents');
                $exhibitionQuestion->is_vod = 1;
                $ExhibitionQuestion->save($exhibitionQuestion);
            } else if ($this->request->getData('action') == 'edit') {
                $child = $ExhibitionQuestion->find('all')->where(['parent_id' => $this->request->getData('parent_id')]) -> toArray();
                $exhibitionQuestion = $ExhibitionQuestion->get($child[0]['id']);
                $exhibitionQuestion->contents = $this->request->getData('contents');
                $ExhibitionQuestion->save($exhibitionQuestion);
            } else {
                $exhibitionQuestion = $ExhibitionQuestion->get($this->request->getData('id'));
                $ExhibitionQuestion->delete($exhibitionQuestion);
            }
        }

        $this->set(compact('exhibitionQuestions', 'id'));
    }

    public function vodAnswered ($id = null)
    {
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();
    
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers', 'ChildExhibitionQuestions'])
            ->where(['ExhibitionQuestion.id IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id, 'is_vod' => 1])->toArray();

        $this->set(compact('exhibitionQuestions', 'answeredQuestions', 'id'));
    }

    public function attendance ($id = null)
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find()->select(['users_name', 'users_email', 'users_hp', 'attend'])->where(['exhibition_id' => $id]);

        $this->set(compact('exhibitionUsers'));
    }

    public function personInCharge ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find()->select(['name', 'tel', 'email'])->where(['id' => $id])->toArray();
        
        $this->set(compact('exhibition'));
    }

    public function founder ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $users_id = $Exhibition->find()->select(['users_id'])->where(['id' => $id])->toArray()[0]['users_id'];
        
        $Users = $this->getTableLocator()->get('Users');
        $user = $Users->get($users_id);

        $this->set(compact('user'));
    }

    public function exhibitionInfo ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find()->select(['detail_html'])->where(['id' => $id])->toArray();

        $this->set(compact('exhibition'));
    }

    public function setExhibitionFiles ($id = null)
    {
        $ExhibitionFile = $this->getTableLocator()->get('ExhibitionFile');
        $exhibitionFiles = $ExhibitionFile->find('all')->where(['exhibition_id' => $id])->toArray();

        if ($this->request->is('post')) {
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $ExhibitionFiles = $this->getTableLocator()->get('ExhibitionFile');
            $data = $this->request->getData();
            $count = count($data['file']);
            for ($i = 0; $i < $count; $i++) {
                
                $exhibitionFiles = $ExhibitionFiles->newEmptyEntity();
                $exhibitionFiles->exhibition_id = $id;
                $exhibitionFiles->status = 0;
                $ExhibitionFiles->save($exhibitionFiles);
                if ($result = $ExhibitionFiles->save($exhibitionFiles)) {
                    $file = $data['file'][$i];
                    $fileName = $file->getClientFilename();
                    $index = strpos(strrev($fileName), strrev('.'));
                    $expen = strtolower(substr($fileName, ($index * -1)));
                    $path = 'upload' . DS . 'exhibition_files' . DS . date("Y") . DS . date("m");

                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }

                    $fileName = $result->id . "_file." . $expen;
                    $destination = WWW_ROOT . $path . DS . $fileName;
                    $name = $file->getClientFilename();
                    
                    if ($connection->update('exhibition_file', ['name' => $name, 'file_path' => $path, 'file_name' => $fileName, 'status' => 1], ['id' => $result->id])) {
                        $file->moveTo($destination);
                        
                    } else {
                        $connection->rollback(); 
                    }
                } else {
                    $connection->rollback(); 
                }
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $this->set(compact('id', 'exhibitionFiles'));
    }

    public function deleteExhibitionFile ($file_id = null)
    {
        if ($this->request->is('delete')) {
            $ExhibitionFile = $this->getTableLocator()->get('ExhibitionFile');
            $exhibitionFile = $ExhibitionFile->get($file_id);

            if ($ExhibitionFile->delete($exhibitionFile)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
    }

    public function setProgram ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);
        $program = $exhibition->program;

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $program = htmlspecialchars_decode($this->request->getData('program'));
            $exhibition->program = $program;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                 return $response;
            }
        }
        $this->set(compact('id', 'program'));
    }

    public function setNotice ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $display = $Exhibition->get($id)->notice;

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $notice = $this->request->getData('notice');
            $exhibition->notice = $notice;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
        $this->set(compact('id', 'display'));
    }

    public function setSurvey ($id = null)
    {
        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
        $exhibitionSurveys = $ExhibitionSurvey->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'survey_type' => 'N', 'parent_id IS' => null])->toArray();
        
        $groupedSurveys[] = '';
        $i = 0;
        
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            $count = count($exhibitionSurvey['child_exhibition_survey']);
            if ($count != 0 || $exhibitionSurvey['is_multiple'] == 'N') {
                $groupedSurveys[$i] = $exhibitionSurvey;
            }
            $i++;
        }

        if ($this->request->is('post')) {

            if (!empty($this->request->getData('checkedLists'))) {
                $count = count($this->request->getData('checkedLists'));
                
                for ($i = 0; $i < $count; $i++) {
                    $survey_id = $this->request->getData('checkedLists')[$i];
                    $parentSurvey = $ExhibitionSurvey->get($survey_id);
                    $parentSurvey->is_display = 'Y';

                    $ExhibitionSurvey->save($parentSurvey);
                    
                    if ($parentSurvey->is_multiple == 'Y') {

                        $childSurveys = $ExhibitionSurvey->find('all')->where(['parent_id' => $survey_id])->toArray();
                        $childCount = count($childSurveys);
                        
                        for ($j = 0; $j < $childCount; $j++) {
                            $child_survey_id = $childSurveys[$j]['id'];
                            $childSurvey = $ExhibitionSurvey->get($child_survey_id);
                            $childSurvey->is_display = 'Y';

                            $ExhibitionSurvey->save($childSurvey);
                        }
                    } 
                }
            }
            
            if (!empty($this->request->getData('uncheckedLists'))) {
                $count = count($this->request->getData('uncheckedLists'));
            
                for ($i = 0; $i < $count; $i++) {
                    $survey_id = $this->request->getData('uncheckedLists')[$i];
                    $parentSurvey = $ExhibitionSurvey->get($survey_id);
                    $parentSurvey->is_display = 'N';

                    $ExhibitionSurvey->save($parentSurvey);
                    
                    if ($parentSurvey->is_multiple == 'Y') {

                        $childSurveys = $ExhibitionSurvey->find('all')->where(['parent_id' => $survey_id])->toArray();
                        $childCount = count($childSurveys);
                        
                        for ($j = 0; $j < $childCount; $j++) {
                            $child_survey_id = $childSurveys[$j]['id'];
                            $childSurvey = $ExhibitionSurvey->get($child_survey_id);
                            $childSurvey->is_display = 'N';

                            $ExhibitionSurvey->save($childSurvey);
                        }
                    } 
                }
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $this->set(compact('groupedSurveys', 'id'));
    }

    public function answerSurvey($id = null, $exhibition_users_id = null)
    {
        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
        $exhibitionSurveys = $ExhibitionSurvey->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'parent_id IS' => null, 'is_display' => 'Y'])->toArray();
        $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');
        $currentSurveys = $ExhibitionSurvey->find('all')->where(['exhibition_id' => $id, 'is_display' => 'Y'])->toArray();

        $c_surveys[] = '';
        for ($i = 0; $i < count($currentSurveys); $i++) {
            $c_surveys[$i] = $currentSurveys[$i]['id'];
        }

        $exhibitionSurveyUsersAnswer = $ExhibitionSurveyUsersAnswer->find('all')->where(['exhibition_survey_id IN' => $c_surveys, 'users_id' => $exhibition_users_id])->toArray();
        $update = 0;
        if ($exhibitionSurveyUsersAnswer == []) {
            $update = 0;
        } else {
            $update = 1;
        }

        if ($this->request->is('post')) {

            if ($exhibitionSurveyUsersAnswer != []) {
                foreach ($exhibitionSurveyUsersAnswer as $answer) {
                    $tempAnswer = $ExhibitionSurveyUsersAnswer->get($answer['id']);
                    $ExhibitionSurveyUsersAnswer->delete($tempAnswer);
                }
            }
            // if ($update == 1) {
            //     $answerData = $this->request->getData();
            //     $i = 0;
            //     foreach ($exhibitionSurveyUsersAnswer as $answer) {
            //         $data = $ExhibitionSurveyUsersAnswer->get($answer['id']);
            //         $data->text = $answerData['exhibition_survey_users_answer_'. $i .'_text'];
            //         $ExhibitionSurveyUsersAnswer->save($data);
            //         $i++;
            //     }
            //     $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            //     return $response;
            // } else {
                $connection = ConnectionManager::get('default');
                $connection->begin();

                $exhibitionSurveys = $ExhibitionSurvey->find('all')->where(['exhibition_id' => $id, 'is_display' => 'Y'])->toArray();
                $answerData = $this->request->getData();
                $i = 0;
                $parentId = 0;
                $whereId = 0;
                // $users_id = null;
                // if (!empty($this->Auth->user())) {
                //     $users_id = $this->Auth->user('id');
                // }

                foreach ($exhibitionSurveys as $exhibitionSurvey) {

                    if (!$result = $connection->insert('exhibition_survey_users_answer', [
                        'exhibition_survey_id' => $exhibitionSurvey['id'],
                        'users_id' => $exhibition_users_id,
                        'text' => $answerData['exhibition_survey_users_answer_'. $i .'_text'],
                        'is_multiple' => $exhibitionSurvey['is_multiple']
                    ])) {
                        $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
                        $connection->rollback();
                    }
                    
                    if ($exhibitionSurvey['parent_id'] == null && $exhibitionSurvey['is_multiple'] == "Y") {
                        $parentId = $result->lastInsertId();
                        
                    } else {
                        
                        if ($exhibitionSurvey['is_multiple'] == "Y") {
                            $whereId = $result->lastInsertId();

                            if ($connection->update('exhibition_survey_users_answer', ['parent_id' => $parentId], ['id' => $whereId])) {
                                
                            } else {
                                $connection->rollback();
                            }
                        } 
                    }
                    $i++;
                }

                $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');
                $exhibitionSurveyUsersAnswers = $ExhibitionSurveyUsersAnswer->find('all', ['contain' => 'ChildExhibitionSurveyUsersAnswer'])->where(['is_multiple' => 'Y', 'text' => 'question'])->toArray();
                
                foreach ($exhibitionSurveyUsersAnswers as $data) :
                    $answered = 0;
                    for ($i = 0; $i < count($data['child_exhibition_survey_users_answer']); $i++) {
                        if ($data['child_exhibition_survey_users_answer'][$i]['text'] == 'Y') {
                            $answered = 1;
                        } 
                    }
                    if ($answered == 0) {
                        $connection->delete('exhibition_survey_users_answer', ['id' => $data['id']]);
                        $connection->delete('exhibition_survey_users_answer', ['parent_id' => $data['id']]);
                    }
                endforeach;

                $exhibitionSurveyUsersAnswers = $ExhibitionSurveyUsersAnswer->find('all')->where(['is_multiple' => 'N', 'text IS' => ''])->toArray();
                foreach ($exhibitionSurveyUsersAnswers as $data) :
                    $connection->delete('exhibition_survey_users_answer', ['id' => $data['id']]);
                endforeach;
                
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            // }
        }

        $this->set(compact('exhibitionSurveys', 'exhibitionSurveyUsersAnswer', 'id', 'update', 'exhibition_users_id'));
    }

    public function notice($id = null) {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find('all')->select(['notice'])->where(['id' => $id])->toArray();
        $notice = $exhibition[0]['notice'];

        $this->set(compact('notice', 'id'));
    }

    public function setQuestion($id = null, $exhibition_users_id = null) {
        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
        $exhibitionSpeakers = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id, 'is_vod' => 0])->toArray();
        
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find()->select(['id'])->where(['exhibition_id' => $id])->toArray();
        
        if (count($exhibitionUsers) != 0) {
            $i = 0;
            foreach ($exhibitionUsers as $user) {
                $users_id[$i] = $user['id'];
                $i++;
            }
        } else {
            $users_id[] = '';
        }
        
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $exhibitionQuestions = $ExhibitionQuestion->find('all')->where(['parent_id IS' => null, 'exhibition_users_id IN' => $users_id, 'is_vod' => 0])->toArray();

        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'delete') {

                $exhibitionQuestion = $ExhibitionQuestion->get($this->request->getData('id'));
                if ($ExhibitionQuestion->delete($exhibitionQuestion)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            
            } else {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $speaker_id = $this->request->getData('target');
                
                $exhibitionQuestion->exhibition_users_id = $exhibition_users_id;
                
                if ($speaker_id != 'all') {
                    $exhibitionQuestion->target_users_id = $speaker_id;
                    $users_name = $ExhibitionSpeaker->find()->select(['name'])->where(['id' => $speaker_id])->toArray();
                    $exhibitionQuestion->target_users_name = $users_name[0]['name'];
                }
                
                $exhibitionQuestion->contents = $this->request->getData('question');
               
                if ($ExhibitionQuestion->save($exhibitionQuestion)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }
        $current_user_id = $this->Auth->user('id');
        $this->set(compact('exhibitionSpeakers', 'exhibitionQuestions', 'ExhibitionUsers', 'id', 'current_user_id', 'exhibition_users_id'));
    }

    //웨비나 종료 시점 이후에 출석 완료 되도록 수정 필요
    public function setAttendance($id = null, $exhibition_users_id = null)
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find('all')->where(['id' => $exhibition_users_id])->toArray();
        $exhibition_users_id = $exhibitionUsers[0]['id'];
        $status = $exhibitionUsers[0]['attend'];
        $num = 0;

        $exhibitionUsers = $ExhibitionUsers->get($exhibition_users_id);

        if ($status == 1) {
            $exhibitionUsers->attend = 2;
            $ExhibitionUsers->save($exhibitionUsers);
            $num = 2;
        // } else if ($status == 2) {
        //     $exhibitionUsers->attend = 4;
        //     $ExhibitionUsers->save($exhibitionUsers);
        //     $num = 4;
        } else {
            $num = 8;
        }
        
        $this->set(compact('num'));
    }

    public function autoAttendance($exhibition_users_id = null)
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUser = $ExhibitionUsers->get($exhibition_users_id);

        if ($exhibitionUser->attend == 1) {
            $exhibitionUser->attend = 2;
            $ExhibitionUsers->save($exhibitionUser);
        }

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        return $response;
    }

    public function program ($id = null) {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find('all')->select(['program'])->where(['id' => $id])->toArray();
        $program = $exhibition[0]['program'];

        $this->set(compact('program', 'id'));
    }
    
    public function exhibitionFiles ($id = null, $file_id = null) 
    {
        $ExhibitionFile = $this->getTableLocator()->get('ExhibitionFile');
        $exhibitionFiles = $ExhibitionFile->find('all')->where(['exhibition_id' => $id])->toArray();

        if ($file_id != null) {
            $exhibitionFile = $ExhibitionFile->get($file_id);
            $down = WWW_ROOT . $exhibitionFile->file_path . DS . $exhibitionFile->file_name;
            
            if(file_exists($down)) {
                header("Content-Type:application/octet-stream");
                header("Content-Disposition:attachment;filename=$exhibitionFile->name");
                header("Content-Transfer-Encoding:binary");
                header("Content-Length:".(int)filesize($down));
                header("Cache-Control:cache,must-revalidate");
                header("Pragma:no-cache");
                header("Expires:0");
                
                if(is_file($down)){
                    $fp = fopen($down,"r");
                    
                    while(!feof($fp)){
                        $buf = fread($fp,8096);
                        $read = strlen($buf);
                        print($buf);
                        flush();
                    }
                fclose($fp);
                }
            }
        }
        $this->set(compact('exhibitionFiles', 'id'));
    }

    public function survey ($id = null)
    {
        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
        $exhibitionSurveys = $ExhibitionSurvey->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'survey_type' => 'N'])->toArray();
        
        $groupedSurveys[] = '';
        $i = 0;
        
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            $count = count($exhibitionSurvey['child_exhibition_survey']);
            if ($count != 0 || $exhibitionSurvey['is_multiple'] == 'N') {
                $groupedSurveys[$i] = $exhibitionSurvey;
            }
            $i++;
        }

        if ($this->request->is('post')) {
            $count = count($this->request->getData('display'));
            
            for ($i = 0; $i < $count; $i++) {
                $survey_id = $this->request->getData('display')[$i];
                $parentSurvey = $ExhibitionSurvey->get($survey_id);
                $parentSurvey->is_display = 'Y';

                $ExhibitionSurvey->save($parentSurvey);
                
                if ($parentSurvey->is_multiple == 'Y') {

                    $childSurveys = $ExhibitionSurvey->find('all')->where(['parent_id' => $survey_id])->toArray();
                    $childCount = count($childSurveys);
                    
                    for ($j = 0; $j < $childCount; $j++) {
                        $child_survey_id = $childSurveys[$j]['id'];
                        $childSurvey = $ExhibitionSurvey->get($child_survey_id);
                        $childSurvey->is_display = 'Y';

                        $ExhibitionSurvey->save($childSurvey);
                    }
                } 
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $this->set(compact('groupedSurveys', 'id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Stream id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function editExhibitionStream($exhibition_id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }
        if ($exhibition->is_event == 1) {
            return $this->redirect([
                'action' => 'editEventStream', $exhibition_id
            ]);
        }
        
        $users_id = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->users_id;
        if ($this->Auth->user('id') != $users_id) {
            $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }
        $edate = $this->getTableLocator()->get('Exhibition')->find('all')->where(['id' => $exhibition_id])->toArray()[0]['edate'];
        if (strtotime($edate->format('Y-m-d H:i:s')) < strtotime(date('Y-m-d H:i:s', time()+32400))) {
            echo "<script>alert('종료된 행사입니다.');history.go(-1);</script>";
        }

        $stream_id = $this->ExhibitionStream->find()->select(['id'])->where(['exhibition_id' => $exhibition_id])->toArray()[0]->id;
        $exhibitionStream = $this->ExhibitionStream->get($stream_id);

        if ($exhibitionStream->coupon_id != null) {
            $coupon = $this->ExhibitionStream->Coupon->findById($exhibitionStream->coupon_id)->toArray();
        } else {
            $coupon = [];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
                
            if ($data['coupon_id'] != "0") :
            $exhibitionStream->coupon_id = $data['coupon_id'];
            endif;
            $exhibitionStream->title = $data['title'];
            $exhibitionStream->description = $data['description'];
            $exhibitionStream->time = $data['time'];
            $exhibitionStream->people = $data['people'];
            $exhibitionStream->amount = $exhibitionStream->amount + (int)str_replace(",", "", $data['amount']);
            if ($data['coupon_amount'] != "0") : 
            $exhibitionStream->coupon_amount = $data['coupon_amount'];
            endif;
            $exhibitionStream->tab = $data['tab'];
            if (!empty($data['is_download'])) :
            $exhibitionStream->is_download = $data['is_download'];
            else :
            $exhibitionStream->is_download = 0;
            endif;

            if (!$this->ExhibitionStream->save($exhibitionStream)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response; 
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray(); 
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $user = $this->Auth->user();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices', 'user'));
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

    public function validateCoupon () 
    {
        if ($this->request->is('post')) {
            $Coupon = $this->getTableLocator()->get('Coupon');
            $coupon = $Coupon->find('all')->where(['product_type' => 'S', 'status' => 1])->toArray();
            $exist = 0;
            $coupon_id = 0;
            $discount_rate = 0;
            $start_date = 0;
            $end_date = 0;
            $date = (int)FrozenTime::now()->format('Ymd');
            $count = Count($coupon);
            $codes = explode('-', $this->request->getData('coupon_code'));
            $code = '';
            for ($i = 0; $i < count($codes); $i++) {
                $code .= $codes[$i];
            }
            
            for ($i = 0; $i < $count; $i++) {
                
                if ($coupon[$i]['code'] == $code) {
                    $coupon_id = $coupon[$i]['id'];
                    $discount_rate = $coupon[$i]['discount_rate']; 
                    $exist = 1;
                    $start_date = (int)$coupon[$i]['sdate'];
                    $end_date = (int)$coupon[$i]['edate'];
                }
            }

            if ($exist == 1 && $start_date <= $date && $date <= $end_date) {
                // $update_coupon = $Coupon->get($coupon_id);
                // $update_coupon->status = 4;
                // $Coupon->save($update_coupon);

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'coupon_id' => $coupon_id, 'discount_rate' => $discount_rate]));
                return $response;
                
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
    }

    public function changeCouponStatus ()
    {
        $coupon = $this->getTableLocator()->get('Coupon')->find('all')->where(['product_type' => 'S', 'status' => 1])->toArray();
        $coupon_id = 0;
        $count = Count($coupon);
        
        if ($count == 0) {
            return $response;
        }

        $codes = explode('-', $this->request->getData('coupon_code'));
        $code = '';
        for ($i = 0; $i < count($codes); $i++) {
            $code .= $codes[$i];
        }

        for ($i = 0; $i < $count; $i++) {
            
            if ($coupon[$i]['code'] == $code) {
                $coupon_id = $coupon[$i]['id'];
            }
        }

        $Coupon = $this->getTableLocator()->get('Coupon');
        $coupon = $Coupon->get($coupon_id);
        
        //이벤트용
        if ($coupon->code != 'onporters') {
            $coupon = $Coupon->patchEntity($coupon, ['status' => 4]);
        }
        
        if (!$Coupon->save($coupon)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            return $response;
        }
        return $response;
    }

    public function issueStreamKey() 
    {
        $stream_key = Text::uuid();
        $stream_url = "rtmp://orcaexon.co.kr:1935/exon/"; 

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'stream_key' => $stream_key, 'stream_url' => $stream_url]));
        return $response;
    }

    public function certification($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);

        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();
        $stream_key = $exhibitionStream[0]['stream_key'];

        if (!empty($this->Auth->user())) {
            $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
            $exhibitionUser = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id, 'users_id' => $this->Auth->user()->id])->toArray();
            $auth_id = $this->Auth->user()->id;

            if (empty($exhibitionUser)) {
                return $this->redirect(['controller' => 'exhibitionUsers', 'action' => 'signUp', 'application']);
            }

            // if ($exhibition->require_cert == 1) {
            //     $auth_id = $this->Auth->user()->id;
            //     $Users = $this->getTableLocator()->get('Users');
            //     $user = $Users->get($auth_id);

            //     if ($user->hp_cert == 1 || $user->email_cert == 1) {
            //         return $this->redirect(['action' => 'watchExhibitionStream', $id, $exhibitionUser[0]['id']]);
            //     }
            
            // } else {
            //     return $this->redirect(['action' => 'watchExhibitionStream', $id, $exhibitionUser[0]['id']]);
            // }
            
        } else {
            $auth_id = 0;
        }
    
        $this->set(compact('auth_id', 'stream_key', 'id'));
    }

    public function sendSmsCertification($user_id = null)
    {        
        if ($this->request->is('post')) {
            require_once(ROOT . "/solapi-php/lib/message.php");

            $code = $this->generateCode();
            $commonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $commonConfirmations->newEmptyEntity();
            $commonConfirmation = $commonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

            if ($result = $commonConfirmations->save($commonConfirmation)) {
                $to[0] = $this->request->getData('hp');

                $messages = [
                    [
                        'to' => $to,
                        'from' => getEnv('EXON_PHONE_NUMBER'),
                        'text' => '[EXON] 본인인증 인증번호는 ' . $code . ' 입니다.' 
                    ]
                ];

                if(send_messages($messages)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                    return $response;
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }

        $this->set(compact('user_id'));
    }

    public function confirmSms($id = null, $exhibition_id = null) 
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {

                    $user_id = $this->request->getData('user_id');
                    if ($user_id == 0) {
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['exhibition_id' => $exhibition_id, 'users_hp' => $this->request->getData('hp')])->toArray();
                        
                        if (empty($exhibitionUser)) {
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'hp_not_exist']));
                            return $response;
                        }
                        $this->getRequest()->getSession()->write('exhibition_users_name', $exhibitionUser[0]['users_name']);
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'exhibition_users_id' => $exhibitionUser[0]['id']]));
                        return $response;
                    
                    } else {
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['exhibition_id' => $exhibition_id, 'users_id' => $user_id])->toArray();
                        
                        if (empty($exhibitionUser)) {
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'id_not_exist']));
                            return $response;
                        }
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'exhibition_users_id' => $exhibitionUser[0]['id']]));
                        return $response;
                    }
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
                
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function sendEmailCertification () 
    {    
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $code = $this->generateCode();
            $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
            $commonConfirmation = $CommonConfirmations->newEmptyEntity();
            $commonConfirmation = $CommonConfirmations->patchEntity($commonConfirmation, ['confirmation_code' => $code, 'types' => 'email']);

            if ($result = $CommonConfirmations->save($commonConfirmation)) {
                $mailer->setEmailFormat('html')
                            ->setTo($this->request->getData('email'))
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - 인증메일입니다.')
                            ->viewBuilder()
                            ->setTemplate('certification')
                        ;
                $mailer->setViewVars(['front_url' => FRONT_URL]);
                $mailer->setViewVars(['code' => $code]);
                $mailer->deliver();

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                return $response;
                
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
        $this->set(compact('user_id'));
    }

    public function confirmEmail($id = null, $exhibition_id = null)
    {
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {

                    $user_id = $this->request->getData('user_id');
                    if ($user_id == 0) {
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['exhibition_id' => $exhibition_id, 'users_email' => $this->request->getData('email')])->toArray();
                        
                        if (empty($exhibitionUser)) {
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'email_not_exist']));
                            return $response;
                        }
                        $this->getRequest()->getSession()->write('exhibition_users_name', $exhibitionUser[0]['users_name']);
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'exhibition_users_id' => $exhibitionUser[0]['id']]));
                        return $response;
                    
                    } else {
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['exhibition_id' => $exhibition_id, 'users_id' => $user_id])->toArray();
                        
                        if (empty($exhibitionUser)) {
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'id_not_exist']));
                            return $response;
                        }
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'exhibition_users_id' => $exhibitionUser[0]['id']]));
                        return $response;
                    }
                
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
                
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function generateCode()
    {
        $characters = '123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)-1), 1);
        }
        return $code;
    }

    public function streamNotExist()
    {

    }

    public function updateLastViewTime($exhibition_users_id = null) 
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUser = $ExhibitionUsers->get($exhibition_users_id);
        
        $now = date("Y-m-d H:i:s");
        $exhibitionUser->last_view_time = $now;

        $ExhibitionUsers->save($exhibitionUser);

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        return $response;
    }
    
    public function countViewer($exhibition_id = null)
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();

        $now = date('Y-m-d H:i:s', time()+32370);
        $count = 0;
        
        foreach($exhibitionUsers as $exhibitionUser) {

            if ($exhibitionUser['last_view_time'] != null) {
                $to_time = $now;
                $from_time = date('Y-m-d H:i:s', strtotime($exhibitionUser['last_view_time']->format('Y-m-d H:i:s'))+32400);

                if ($to_time <= $from_time) {
                    $count = $count + 1;
                }
            }
        }
        
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'count' => $count]));
        return $response;
    }

    public function setStartedTime($exhibition_stream_id = null)
    {
        if ($this->request->is('post')) {
            $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
            $now = strtotime(date("Y-m-d H:i:s"));
            $exhibitionStream->live_started = $now;

            if ($this->ExhibitionStream->save($exhibitionStream)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
    }

    public function getLiveDurationTime($exhibition_stream_id = null) 
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);

        if ($exhibitionStream->live_started != null) {
            $now = strtotime(date("Y-m-d H:i:s"));
            $live_started = strtotime($exhibitionStream->live_started->format('Y-m-d H:i:s'));
            $time = $now - $live_started;
        
        } else {
            $time = 0;
        }
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'time' => $time]));
        return $response;
    }
    
    public function deleteStartedTime($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);

        $exhibitionStream->live_started = "0000-00-00 00:00:00";

        $this->ExhibitionStream->save($exhibitionStream);

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        return $response;
    }

    public function setLiveDuration($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
        
        if ($exhibitionStream->live_started != null) {
            $now = strtotime(date("Y-m-d H:i:s"));
            $live_started = strtotime($exhibitionStream->live_started->format('Y-m-d H:i:s'));
            $duration = abs($now - $live_started);

            if ($exhibitionStream->live_duration < $duration) {
                $exhibitionStream->live_duration = $duration;
            
            } else {
                $exhibitionStream->live_duration = $exhibitionStream->live_duration + 1;
            }
        }
        
        if ($this->ExhibitionStream->save($exhibitionStream)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'duration' => $exhibitionStream->live_duration]));
            return $response;
        }
    }

    public function addLiveDuration($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);

        $time_count = $this->request->getData('time_count');

        $exhibitionStream->live_duration = (int)$exhibitionStream->live_duration + (int)$time_count;

        $this->ExhibitionStream->save($exhibitionStream);
    }

    public function liveTimeCheck($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'time' => (int)$exhibitionStream->time, 'live_duration' => (int)$exhibitionStream->live_duration]));
        return $response;
    }

    public function liveEndCheck($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
        
        if ($exhibitionStream->live_started == null) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'end' => 1]));
            return $response;
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'end' => 0]));
            return $response;
        }
    }

    public function getRemainLiveDuration($exhibition_stream_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);

        $time = $exhibitionStream->time - $exhibitionStream->live_duration;
        if ($time < 0) {
            $time = 0;
        }
        
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'time' => $time]));
        return $response;
    }

    public function watchEventVod($exhibition_id = null)
    {
        $exhibition = $this->getTableLocator()->get('Exhibition')->get($exhibition_id);
        $Users = $this->getTableLocator()->get('Users');
        $user = $Users->get($exhibition->users_id);
        $ExhibitionStream = $this->getTableLocator()->get('ExhibitionStream');
        $exhibitionStream = $ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        
        $exhibition_comment_table = TableRegistry::get('ExhibitionComment');
        $exhibition_comments = $exhibition_comment_table->find()->where(['exhibition_stream_id' => $exhibitionStream[0]->id])->toArray();
        $exhibition_comments_unders = $exhibition_comment_table->find('all')->where(['parent_id != 0'])->toArray();

        if ($this->Auth->user('id') == null) {
            $login_user = 'null';
        } else {
            $login_user = $this->Auth->user('id');
        }

        $ip = $this->request->ClientIp();
        $path = 'liked_ip' . DS . date("Y") . DS . date("m") . DS . date("d") . DS . $exhibitionStream[0]->id . DS . 'data.txt';
        $is_exist = 0;

        if (file_exists(WWW_ROOT . $path)) {
            
            $file_handle = fopen(WWW_ROOT . $path, 'r');
            while (!feof($file_handle)) {
                $ip_data = fgets($file_handle);
                if ((string)$ip_data == (string)$ip . "\n") {
                    $is_exist = 1;
                }
            } 
            fclose($file_handle);
        } 

        $this->set(compact('user', 'exhibitionStream', 'exhibition_id', 'exhibition_comments', 'exhibition_comments_unders', 'login_user', 'exhibition', 'is_exist'));
    }

    public function uploadVod()
    {
    
    }

    public function setEventStream($exhibition_id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }

        $users_id = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->users_id;
        $title = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->title;
        if ($this->Auth->user('id') != $users_id) {
            $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }

        $is_exist = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        if (count($is_exist) == 0) {
            $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
    
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                
                $exhibitionStream->exhibition_id = $exhibition_id;
                if ($data['pay_id'] != 0) {
                    $exhibitionStream->pay_id = $data['pay_id'];
                }
                if ($data['coupon_id'] != "0") :
                $exhibitionStream->coupon_id = $data['coupon_id'];
                endif;
                $exhibitionStream->title = $data['title'];
                $exhibitionStream->description = $data['description'];
                $exhibitionStream->stream_key = $data['stream_key'];
                $exhibitionStream->time = $data['time'];
                $exhibitionStream->people = $data['people'];
                $exhibitionStream->amount = (int)str_replace(",", "", $data['amount']);
                $exhibitionStream->coupon_amount = $data['coupon_amount'];
                $exhibitionStream->url = $data['url'];
                $exhibitionStream->ip = $this->Auth->user('ip');
                $exhibitionStream->tab = $data['tab'];
                $exhibitionStream->is_upload = $data['is_upload'];

                if (!$this->ExhibitionStream->save($exhibitionStream)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response; 
                }
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
            
        } else {
            return $this->redirect(['action' => 'editExhibitionStream', $exhibition_id]);
        }
        
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $user = $this->Auth->user();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices', 'title', 'user'));
    }

    public function editEventStream($exhibition_id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }
        
        $users_id = $this->getTableLocator()->get('Exhibition')->get($exhibition_id)->users_id;
        if ($this->Auth->user('id') != $users_id) {
            $this->redirect(['controller' => 'pages', 'action' => 'home']);
        }
        $edate = $this->getTableLocator()->get('Exhibition')->find('all')->where(['id' => $exhibition_id])->toArray()[0]['edate'];
        if (strtotime($edate->format('Y-m-d H:i:s')) < strtotime(date('Y-m-d H:i:s', time()+32400))) {
            echo "<script>alert('종료된 행사입니다.');history.go(-1);</script>";
        }

        $stream_id = $this->ExhibitionStream->find()->select(['id'])->where(['exhibition_id' => $exhibition_id])->toArray()[0]->id;
        $exhibitionStream = $this->ExhibitionStream->get($stream_id);

        if ($exhibitionStream->coupon_id != null) {
            $coupon = $this->ExhibitionStream->Coupon->findById($exhibitionStream->coupon_id)->toArray();
        } else {
            $coupon = [];
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
                
            if ($data['coupon_id'] != "0") :
            $exhibitionStream->coupon_id = $data['coupon_id'];
            endif;
            $exhibitionStream->title = $data['title'];
            $exhibitionStream->description = $data['description'];
            $exhibitionStream->time = $data['time'];
            $exhibitionStream->people = $data['people'];
            $exhibitionStream->amount = $exhibitionStream->amount + (int)str_replace(",", "", $data['amount']);
            if ($data['coupon_amount'] != "0") : 
            $exhibitionStream->coupon_amount = $data['coupon_amount'];
            endif;
            $exhibitionStream->tab = $data['tab'];
            $exhibitionStream->is_upload = $data['is_upload'];

            if (!$this->ExhibitionStream->save($exhibitionStream)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response; 
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray(); 
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $user = $this->Auth->user();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices', 'user'));
    }

    public function watchEventStream ($id = null, $exhibition_users_id = null, $cert = null)
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);
        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }

        if (empty($exhibitionStream) || $exhibitionStream[0]['live_started'] == null) {
            $this->redirect(['action' => 'stream_not_exist']);
        } 
        
        if (strtotime($exhibition->sdate->format('Y-m-d H:i:s')) - 1800 - strtotime(date('Y-m-d H:i:s', time()+32400)) > 0) {
            $this->redirect(['action' => 'stream_not_exist']);
        }

        if (empty($this->Auth->user()) && $exhibition_users_id == null) {
            $this->redirect(['action' => 'certification', $id]);
        }

        if ($exhibition->require_cert == 1 && $cert != 1) {
            $this->redirect(['action' => 'certification', $id]);
        }

        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $front_url = FRONT_URL;
        $this->set(compact('exhibitionStream', 'tabs', 'exhibition_users_id', 'front_url', 'id', 'exhibition'));
    }

    public function addLike ($exhibition_stream_id = null)
    {
        $ip = $this->request->ClientIp();
        $path = 'liked_ip' . DS . date("Y") . DS . date("m") . DS . date("d") . DS . $exhibition_stream_id;
                
        if (!file_exists(WWW_ROOT . $path)) {
            $oldMask = umask(0);
            mkdir(WWW_ROOT . $path, 0777, true);
            chmod(WWW_ROOT . $path, 0777);
            umask($oldMask);
            
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
            fwrite($file_handle, $ip);
            fwrite($file_handle, "\n");
            fclose($file_handle);
        } else {
            $is_exist = 0;
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'r');
            while (!feof($file_handle)) {
                $ip_data = fgets($file_handle);
                if ((string)$ip_data == (string)$ip . "\n") {
                    $is_exist = 1;
                }
            } 
            fclose($file_handle);

            if ($is_exist == 0) {
                $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
                fwrite($file_handle, $ip);
                fwrite($file_handle, "\n");
                fclose($file_handle);
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                return $response;
            }
        }

        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
        $exhibitionStream->liked = $exhibitionStream->liked + 1;

        if (!$this->ExhibitionStream->save($exhibitionStream)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            return $response; 
        }
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'liked' => $exhibitionStream->liked]));
        return $response;
    }

    public function vodAddViewer ($exhibition_id = null, $exhibition_vod_id = null) {
        $user_id = $this->Auth->user('id');
        $exhibition_vod_viewer_table = $this->getTableLocator()->get('ExhibitionVodViewer');
        $exhibition_vod_viewer = $exhibition_vod_viewer_table->find()->where(['exhibition_vod_id' => $exhibition_vod_id, 'user_id' => $user_id])->toArray();

        if (count($exhibition_vod_viewer) == 0) {
            $connection = ConnectionManager::get('default');
            $connection->begin();

            if ($this->request->is(['post', 'put'])) {
                $exhibition_vod_viewer_data = $exhibition_vod_viewer_table->newEmptyEntity();
                $exhibition_vod_viewer_data->exhibition_id = $exhibition_id;
                $exhibition_vod_viewer_data->exhibition_vod_id = $exhibition_vod_id;
                $exhibition_vod_viewer_data->user_id = $user_id;
                
                if ($result = $exhibition_vod_viewer_table->save($exhibition_vod_viewer_data)) {
                    $connection->commit();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'add_success']));
                    return $response;
                }
            }
        } else {
            $exhibition_vod_viewer_data = $exhibition_vod_viewer_table->get($exhibition_vod_viewer[0]->id);
            $exhibition_vod_viewer_data->watching_duration = $this->request->getData('current_time');

            if ($exhibition_vod_viewer_table->save($exhibition_vod_viewer_data)) {
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'update_success']));
                return $response;
            }
        }
    }

    public function addViewer ($exhibition_stream_id = null)
    {
        $ip = $this->request->ClientIp();
        $path = 'viewer_ip' . DS . date("Y") . DS . date("m") . DS . date("d") . DS . $exhibition_stream_id;
                
        if (!file_exists(WWW_ROOT . $path)) {
            $oldMask = umask(0);
            mkdir(WWW_ROOT . $path, 0777, true);
            chmod(WWW_ROOT . $path, 0777);
            umask($oldMask);
            
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
            fwrite($file_handle, $ip);
            fwrite($file_handle, "\n");
            fclose($file_handle);
        } else {
            $is_exist = 0;
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'r');
            while (!feof($file_handle)) {
                $ip_data = fgets($file_handle);
                if ((string)$ip_data == (string)$ip . "\n") {
                    $is_exist = 1;
                }
            } 
            fclose($file_handle);

            if ($is_exist == 0) {
                $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
                fwrite($file_handle, $ip);
                fwrite($file_handle, "\n");
                fclose($file_handle);
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                return $response;
            }
        }

        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
        $exhibitionStream->viewer = $exhibitionStream->viewer + 1;

        $this->ExhibitionStream->save($exhibitionStream);
        
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'viewer' => $exhibitionStream->viewer]));
        return $response;
    }

    public function addWatched ($exhibition_stream_id = null)
    {
        $ip = $this->request->ClientIp();
        $path = 'watched_ip' . DS . $exhibition_stream_id;
                
        if (!file_exists(WWW_ROOT . $path)) {
            $oldMask = umask(0);
            mkdir(WWW_ROOT . $path, 0777, true);
            chmod(WWW_ROOT . $path, 0777);
            umask($oldMask);
            
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
            fwrite($file_handle, $ip);
            fwrite($file_handle, "\n");
            fclose($file_handle);
        } else {
            $is_exist = 0;
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'r');
            while (!feof($file_handle)) {
                $ip_data = fgets($file_handle);
                if ((string)$ip_data == (string)$ip . "\n") {
                    $is_exist = 1;
                }
            } 
            fclose($file_handle);

            if ($is_exist == 0) {
                $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
                fwrite($file_handle, $ip);
                fwrite($file_handle, "\n");
                fclose($file_handle);
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                return $response;
            }
        }

        $exhibitionStream = $this->ExhibitionStream->get($exhibition_stream_id);
        $exhibitionStream->watched = $exhibitionStream->watched + 1;

        $this->ExhibitionStream->save($exhibitionStream);
        
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        return $response;
    }

    public function comment()
    {
        $id = 59;
        $exhibition_comment_table = TableRegistry::get('ExhibitionComment');
        $exhibition_comments = $exhibition_comment_table->find('all')->toArray();
        // $exhibition_comment = $exhibition_comment->where(['exhibition_stream_id' => $id])->toArray();
        $exhibition_comments_unders = $exhibition_comment_table->find('all')->where(['parent_id != 0', 'exhibition_stream_id' => $id])->toArray();

        if ($this->Auth->user('id') == null) {
            $user = 'null';
        } else {
            $user = $this->Auth->user('id');
        }

        $this->set(compact('exhibition_comments', 'exhibition_comments_unders', 'user'));
    }

    public function commentAdd()
    {
        if ($this->request->getData('users_id') == null) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'not_user']));
            return $response;
        }

        $exhibition_comment_table = TableRegistry::get('ExhibitionComment');
        $comment = $exhibition_comment_table->newEmptyEntity();

        $users_table = TableRegistry::get('Users');
        $user_name = $users_table->find()->where(['id' => $this->Auth->user('id')])->toArray();

        if ($this->request->is('post')) {
            $comment->exhibition_stream_id = $this->request->getData('exhibition_stream_id');
            $comment->users_id = $this->request->getData('users_id');
            if ($this->request->getData('parent_id') != null) {
                $comment->parent_id = $this->request->getData('parent_id');
            }
            $comment->message = $this->request->getData('message');
            $comment->liked = 0;
            $comment->user_name = $user_name[0]->name;
        }

        if ($exhibition_comment_table->save($comment)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'count' => count($exhibition_comment_table->find()->toArray())]));
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }

    public function commentEdit($id = null)
    {
        $exhibition_comment_table = TableRegistry::get('ExhibitionComment');
        $exhibition_comment = $exhibition_comment_table->get($id);

        if ($this->request->is('patch')) {
            $exhibition_comment->message = $this->request->getData('message');

            if ($exhibition_comment_table->save($exhibition_comment)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }

            return $response;
        }
    }

    public function commentDelete($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        
        $exhibition_comment_table = TableRegistry::get('ExhibitionComment');

        if ($connection->delete('exhibition_comment',['id' => $id])) {
            if (count($exhibition_comment_table->find('all')->where(['parent_id' => $id])->toArray()) != 0) {
                if ($connection->delete('exhibition_comment',['parent_id' => $id])) {
                    $connection->commit();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                }
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }

    public function watchExhibitionVod($exhibition_id = null, $exhibition_vod_id = null, $exhibition_users_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVod = $ExhibitionVod->get($exhibition_vod_id);
        
        $this->set(compact('exhibitionStream', 'exhibitionVod', 'exhibition_users_id', 'exhibition'));
    }

    public function vodChapter($exhibition_id = null, $exhibition_users_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);
        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVod = $ExhibitionVod->find('all', ['contain' => 'ChildExhibitionVod'])->where(['ExhibitionVod.exhibition_id' => $exhibition_id, 'ExhibitionVod.parent_id IS' => null])->toArray();
        
        $this->set(compact('exhibitionStream', 'exhibitionVod', 'exhibition_users_id', 'exhibition'));
    }

    public function vodChapterTab($exhibition_id = null, $exhibition_users_id = null)
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVod = $ExhibitionVod->find('all', ['contain' => 'ChildExhibitionVod'])->where(['ExhibitionVod.exhibition_id' => $exhibition_id, 'ExhibitionVod.parent_id IS' => null])->toArray();
        
        $this->set(compact('exhibitionStream', 'exhibitionVod',  'exhibition_users_id'));
    }
    
    public function setExhibitionVod($exhibition_id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);

        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVod = $ExhibitionVod->find('all', ['contain' => 'ChildExhibitionVod'])->where(['exhibition_id' => $exhibition_id, 'parent_id IS' => null])->toArray();

        $file_size = 0;
        $vods = $ExhibitionVod->find('all')->where(['exhibition_id' => $exhibition_id, 'parent_id IS NOT' => null])->toArray();

        foreach ($vods as $data) {
            $file_size += $data['file_size'];
        }

        $user = $this->Auth->user();

        $this->set(compact('exhibition', 'exhibition_id', 'exhibitionVod', 'file_size', 'user'));
    }

    public function exhibitionVodAddViewer ($exhibition_vod_id = null) {
        $ip = $this->request->ClientIp();
        $path = 'exhibition_vod_viewer_ip' . DS . date("Y") . DS . date("m") . DS . date("d") . DS . $exhibition_vod_id;

        if (!file_exists(WWW_ROOT . $path)) {
            $oldMask = umask(0);
            mkdir(WWW_ROOT . $path, 0777, true);
            chmod(WWW_ROOT . $path, 0777);
            umask($oldMask);

            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt'. 'a+');
            fwrite($file_handle, $ip);
            fwrite($file_handle, "\n");
            fclose($file_handle);
        } else {
            $is_exist = 0;
            $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'r');
            while (!feof($file_handle)) {
                $ip_data = fgets($file_handle);
                if ((string)$ip_data == (string)$ip . "\n") {
                    $is_exist = 1;
                }
            } 
            fclose($file_handle);

            if ($is_exist == 0) {
                $file_handle = fopen(WWW_ROOT . $path . DS . 'data.txt', 'a+');
                fwrite($file_handle, $ip);
                fwrite($file_handle, "\n");
                fclose($file_handle);
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                return $response;
            }
        }

        $exhibitionVod_table = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVod = $exhibitionVod_table->find('all')->where(['id'=>$exhibition_vod_id])->toArray();
        $exhibitionVod[0]->viewer = $exhibitionVod[0]->viewer + 1;

        $exhibitionVod_table->save($exhibitionVod[0]);

        $response = $this->response->withType('json')->withStringBody(json_encode(['status'=>'success']));
        return $response;
    }

    public function vods($exhibition_id = null, $exhibition_users_id = null, $chapter_id = null)
    {
        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $chapter = $ExhibitionVod->get($chapter_id)->toArray();
        $vods = $ExhibitionVod->find('all')->where(['parent_id' => $chapter_id])->toArray();

        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($exhibition_id);

        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();

        $this->set(compact('chapter', 'vods', 'exhibition', 'exhibition_users_id', 'exhibitionStream'));
    }
}
