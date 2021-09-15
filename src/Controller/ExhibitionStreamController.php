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
                    $stream_url = '1234'; //stream_url 생성
                    $title = $this->request->getData('title');
                    $description = $this->request->getData('description');
                    $time = $this->request->getData('time');
                    $people = $this->request->getData('people');
                    $amount = $this->request->getData('amount');
                    $paid = $this->request->getData('paid');
                    $pay_id = $this->request->getData('id');
                    $tab = $this->request->getData('tab');
    
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

    public function watchExhibitionStream($id = null) 
    {
        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();

        
        
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $this->set(compact('exhibitionStream', 'tabs'));
    }

    public function questionMenu ($id = null) 
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
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])->select(['ExhibitionQuestion.parent_id'])
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id])->toArray();
    
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.id NOT IN' => $answeredQuestionId, 'ExhibitionQuestion.contents IS NOT' => '답변완료', 'ExhibitionUsers.exhibition_id' => $id])->toArray();
        
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
            ->where(['ExhibitionQuestion.parent_id IS NOT' => null, 'ExhibitionUsers.exhibition_id' => $id])->toArray();
    
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.id IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id])->toArray();

        $this->set(compact('exhibitionQuestions', 'id'));
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
        $this->set(compact('id'));
    }

    public function setProgram ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $program = $this->request->getData('program');
            $exhibition->program = $program;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                 return $response;
            }
        }
        $this->set(compact('id'));
    }

    public function setNotice ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $notice = $this->request->getData('notice');
            $exhibition->notice = $notice;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
        $this->set(compact('id'));
    }

    public function setSurvey ($id = null)
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

    public function answerSurvey($id = null)
    {
        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
        $exhibitionSurveys = $ExhibitionSurvey->find('all')->where(['exhibition_id' => $id, 'is_display' => 'Y'])->toArray();
        $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');

        if ($this->request->is('post')) {
            $connection = ConnectionManager::get('default');
            $connection->begin();

            $answerData = $this->request->getData('exhibition_survey_users_answer');
            $i = 0;
            $parentId = 0;
            $whereId = 0;
            foreach ($exhibitionSurveys as $exhibitionSurvey) {

                if (!$result = $connection->insert('exhibition_survey_users_answer', [
                    'exhibition_survey_id' => $exhibitionSurvey['id'],
                    'users_id' => $this->Auth->user('id'),
                    'text' => $answerData[$i]['text'],
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
                            $connection->commit();
                            
                        } else {
                            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
                            $connection->rollback();
                        }
                    } 
                }
                $i++;
            }
        }

        $this->set(compact('exhibitionSurveys', 'id'));
    }

    public function notice($id = null) {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find('all')->select(['notice'])->where(['id' => $id])->toArray();
        $notice = $exhibition[0]['notice'];

        $this->set(compact('notice', 'id'));
    }

    public function setQuestion($id = null) {
        $ExhibitionSpeaker = $this->getTableLocator()->get('ExhibitionSpeaker');
        $exhibitionSpeakers = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id])->toArray();
        
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
        $exhibitionQuestions = $ExhibitionQuestion->find('all')->where(['parent_id IS' => null, 'exhibition_users_id IN' => $users_id])->toArray();

        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'delete') {

                $exhibitionQuestion = $ExhibitionQuestion->get($this->request->getData('id'));
                if ($ExhibitionQuestion->delete($exhibitionQuestion)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    $this->Flash->error(__('The Exhibition Question could not be deleted'));
                }
            
            } else {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $speaker_id = $this->request->getData('target');
                
                $users_id = $ExhibitionUsers->find()->select(['id'])->where(['exhibition_id' => $id, 'users_id' => $this->Auth->user('id')])->toArray();
                $exhibitionQuestion->exhibition_users_id = $users_id[0]['id'];
                
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
                    $this->Flash->error(__('The Exhibition Question could not be saved.'));
                }
            }
        }
        $current_user_id = $this->Auth->user('id');
        $this->set(compact('exhibitionSpeakers', 'exhibitionQuestions', 'ExhibitionUsers', 'id', 'current_user_id'));
    }

    //웨비나 종료 시점 이후에 출석 완료 되도록 수정 필요
    public function setAttendance($id = null)
    {
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id, 'users_id' => $this->Auth->user('id')])->toArray();
        $exhibition_users_id = $exhibitionUsers[0]['id'];
        $status = $exhibitionUsers[0]['attend'];
        $num = 0;

        $exhibitionUsers = $ExhibitionUsers->get($exhibition_users_id);

        if ($status == 1) {
            $exhibitionUsers->attend = 2;
            $ExhibitionUsers->save($exhibitionUsers);
            $num = 2;
        } else if ($status == 2) {
            $exhibitionUsers->attend = 4;
            $ExhibitionUsers->save($exhibitionUsers);
            $num = 4;
        } else {
            $num = 8;
        }
        
        $this->set(compact('num'));
    }

    public function program ($id = null) {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->find('all')->select(['program'])->where(['id' => $id])->toArray();
        $program = $exhibition[0]['program'];

        $this->set(compact('program', 'id'));
    }
    
    //새창을 생성하지 않고 다운로드 하도록 수정
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
                header("Content-Length:".filesize($down));
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

    public function questionMenu ($id = null) 
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
        $ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion');
        $answeredQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])->select(['ExhibitionQuestion.parent_id'])
            ->where(['ExhibitionQuestion.target_users_id IS' => null, 'ExhibitionUsers.exhibition_id' => $id])->toArray();
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['target_users_id IS NOT' => null, 'ExhibitionQuestion.id NOT IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id])->toArray();
        
        if ($this->request->is('post')) {

            if ($this->request->getData('action') == 'answered') {
                $exhibitionQuestion = $ExhibitionQuestion->newEmptyEntity();
                $exhibitionQuestion->exhibition_users_id = $this->request->getData('user');
                $exhibitionQuestion->parent_id = $this->request->getData('id');
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
            ->where(['ExhibitionQuestion.target_users_id IS' => null, 'ExhibitionUsers.exhibition_id' => $id])->toArray();
        $count = count($answeredQuestions);
        $answeredQuestionId[] = '';

        for ($i = 0; $i < $count; $i++) {
            $answeredQuestionId[$i] = $answeredQuestions[$i]['parent_id'];
        }
        
        $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.id IN' => $answeredQuestionId, 'ExhibitionUsers.exhibition_id' => $id])->toArray();

        $this->set(compact('exhibitionQuestions', 'id'));
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

    public function exhibitionFiles ($id = null)
    {
        if ($this->request->is('post')) {
            $connection = ConnectionManager::get('default');
            $connection->begin();
            $ExhibitionFiles = $this->getTableLocator()->get('ExhibitionFile');
            $data = $this->request->getData();
            $count = count($data['file']);
            for ($i = 0; $i < $count; $i++) {
                
                $exhibitionFiles = $ExhibitionFiles->newEmptyEntity();
                $exhibitionFiles->exhibition_id = $id;

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
                        $this->Flash->error(__('The exhibition files could not be saved.'));
                    }
                } else {
                    $connection->rollback(); 
                    $this->Flash->error(__('The exhibition files could not be saved.'));
                }
            }
            $connection->commit();
            $this->Flash->success(__('The exhibition speaker has been saved.'));
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $this->set(compact('id'));
    }

    public function program ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $program = $this->request->getData('program');
            $exhibition->program = $program;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                 return $response;
            }
        }
        $this->set(compact('id'));
    }

    public function notice ($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $notice = $this->request->getData('notice');
            $exhibition->notice = $notice;

            if ($Exhibition->save($exhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                 return $response;
            }
        }
        $this->set(compact('id'));
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
