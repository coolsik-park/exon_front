<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;
use Cake\Event\EventInterface;
use Cake\Mailer\Mailer;

class ExhibitionStreamController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['index']);
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
        debug($exhibitionStream);

        $this->set(compact('exhibitionStream'));
    }
    
     //웨비나 송출  설정
    public function setExhibitionStream($exhibition_id = null)
    {
        $is_exist = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $exhibition_id])->toArray();
        if (count($is_exist) == 0) {
            $exhibitionStream = $this->ExhibitionStream->newEmptyEntity();
    
            if ($this->request->is(['patch', 'post', 'put'])) {
                $data = $this->request->getData();
                
                $exhibitionStream->exhibition_id = $exhibition_id;
                $exhibitionStream->pay_id = $data['pay_id'];
                if ($data['coupon_id'] != "0") :
                $exhibitionStream->coupon_id = $data['coupon_id'];
                endif;
                $exhibitionStream->title = $data['title'];
                $exhibitionStream->description = $data['description'];
                $exhibitionStream->stream_key = $data['stream_key'];
                $exhibitionStream->time = $data['time'];
                $exhibitionStream->people = $data['people'];
                $exhibitionStream->amount = $data['amount'];
                $exhibitionStream->coupon_amount = $data['coupon_amount'];
                $exhibitionStream->url = $data['url'];
                $exhibitionStream->ip = $this->Auth->user('ip');
                $exhibitionStream->tab = $data['tab'];

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
        
        $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $coupon = $this->ExhibitionStream->Coupon->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray();
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices'));
    }

    public function watchExhibitionStream($id = null) 
    {
        $exhibition = $this->getTableLocator()->get('Exhibition')->find()->select(['require_cert'])->where(['id' => $id])->toArray();

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
        $displays = $ExhibitionSpeaker->find('all')->where(['exhibition_id' => $id]);
        $this->set(compact('id', 'displays'));
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
        if ($answeredQuestionId[0] != '') {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
                ->where(['ExhibitionQuestion.id NOT IN' => $answeredQuestionId, 'ExhibitionQuestion.contents IS NOT' => '답변완료', 'ExhibitionUsers.exhibition_id' => $id])->toArray();
        } else {
            $exhibitionQuestions = $ExhibitionQuestion->find('all', ['contain' => 'ExhibitionUsers'])
            ->where(['ExhibitionQuestion.contents IS NOT' => '답변완료', 'ExhibitionUsers.exhibition_id' => $id])->toArray();
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
        $exhibition = $Exhibition->get($id);
        $program = $exhibition->program;

        if ($this->request->is('post')) {
            $exhibition = $Exhibition->get($id);
            $program = $this->request->getData('program');
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
        $exhibitionSurveys = $ExhibitionSurvey->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'parent_id IS' => null, 'is_display' => 'Y'])->toArray();
        $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');

        if ($this->request->is('post')) {
            $connection = ConnectionManager::get('default');
            $connection->begin();

            $exhibitionSurveys = $ExhibitionSurvey->find('all')->where(['exhibition_id' => $id, 'is_display' => 'Y'])->toArray();
            $answerData = $this->request->getData();
            $i = 0;
            $parentId = 0;
            $whereId = 0;
            foreach ($exhibitionSurveys as $exhibitionSurvey) {

                if (!$result = $connection->insert('exhibition_survey_users_answer', [
                    'exhibition_survey_id' => $exhibitionSurvey['id'],
                    'users_id' => $this->Auth->user('id'),
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
                            $this->Flash->error(__('The survey answer could not be saved. Please, try again.'));
                            $connection->rollback();
                        }
                    } 
                }
                $i++;
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
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
            $exhibitionStream->amount = ($exhibitionStream->amount + $data['amount']);
            if ($data['coupon_amount'] != "0") : 
            $exhibitionStream->coupon_amount = $data['coupon_amount'];
            endif;
            $exhibitionStream->tab = $data['tab'];

            if (!$this->ExhibitionStream->save($exhibitionStream)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response; 
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $exhibition = $this->ExhibitionStream->Exhibition->find('list', ['limit' => 200]);
        $pay = $this->ExhibitionStream->Pay->find('list', ['limit' => 200]);
        $tabs = $this->getTableLocator()->get('CommonCategory')->findByTypes('tab')->toArray(); 
        $prices = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice')->find('all')->toArray();
        $this->set(compact('exhibitionStream', 'exhibition', 'pay', 'coupon', 'tabs', 'exhibition_id', 'prices'));
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

    public function validateCoupon () 
    {
        if ($this->request->is('post')) {
            $coupon = $this->getTableLocator()->get('Coupon')->find('all')->where(['users_id' => $this->Auth->user()->id, 'product_type' => 'S', 'status' => 2])->toArray();
            $exist = 0;
            $coupon_id = 0;
            $discount_rate = 0;
            $start_date = 0;
            $end_date = 0;
            $date = (int)FrozenTime::now()->format('Ymd');
            $count = Count($coupon);
            
            for ($i = 0; $i < $count; $i++) {
                
                if ($coupon[$i]['code'] == $this->request->getData('coupon_code')) {
                    $coupon_id = $coupon[$i]['id'];
                    $discount_rate = $coupon[$i]['discount_rate']; 
                    $exist = 1;
                    $start_date = (int)$coupon[$i]['sdate'];
                    $end_date = (int)$coupon[$i]['edate'];
                }
            }

            if ($exist == 1 && $start_date <= $date && $date <= $end_date) {
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
        $coupon = $this->getTableLocator()->get('Coupon')->find('all')->where(['users_id' => $this->Auth->user()->id, 'product_type' => 'S', 'status' => 2])->toArray();
        $coupon_id = 0;
        $count = Count($coupon);
        
        if ($count == 0) {
            return $response;
        }

        for ($i = 0; $i < $count; $i++) {
            
            if ($coupon[$i]['code'] == $this->request->getData('coupon_code')) {
                $coupon_id = $coupon[$i]['id'];
            }
        }

        $Coupon = $this->getTableLocator()->get('Coupon');
        $coupon = $Coupon->get($coupon_id);
        $coupon = $Coupon->patchEntity($coupon, ['status' => 4]);
        
        if (!$Coupon->save($coupon)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            return $response;
        }
        return $response;
    }

    public function issueStreamKey() 
    {
        $stream_key = Text::uuid();
        $stream_url = "rtmp://121.126.223.225:1935/exon/" . $stream_key; 

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'stream_key' => $stream_key, 'stream_url' => $stream_url]));
        return $response;
    }

    public function certification($id = null)
    {
        $Exhibition = $this->getTableLocator()->get('Exhibition');
        $exhibition = $Exhibition->get($id);

        $exhibitionStream = $this->ExhibitionStream->find('all')->where(['exhibition_id' => $id])->toArray();
        $stream_key = $exhibitionStream[0]['stream_key'];

        if ($this->Auth->user('id') != null) {
            $auth_id = $this->Auth->user()->id;
            $Users = $this->getTableLocator()->get('Users');
            $user = $Users->get($auth_id);

            if ($user->hp_cert == 1 || $user->email_cert == 1) {
                return $this->redirect(['action' => 'watchExhibitionStream', $id]);
            }
        
        } else {
            $auth_id = 0;
        }
    
        $this->set(compact('auth_id', 'stream_key', 'id'));
    }

    public function sendSmsCertification($user_id = null)
    {        
        if ($this->request->is('post')) {
            require_once("solapi-php/lib/message.php");

            $code = $this->generateCode();
            $commonConfirmation_table = TableRegistry::get('CommonConfirmation');
            $commonConfirmation = $commonConfirmation_table->newEmptyEntity();
            $commonConfirmation = $commonConfirmation_table->patchEntity($commonConfirmation, ['confirmation_code' =>$code, 'types' => 'SMS']);

            if ($result = $commonConfirmation_table->save($commonConfirmation)) {
                $to[0] = $this->request->getData('hp');

                $messages = [
                    [
                        'to' => $to,
                        'from' => getEnv('EXON_PHONE_NUMBER'),
                        'text' => 'Confirmation Code : ' . $code
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

    public function confirmSms($id = null) 
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $commonConfirmation_table = TableRegistry::get('CommonConfirmation');
        $commonConfirmation = $commonConfirmation_table->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {

            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                if ($this->request->getData('code') == $commonConfirmation[0]->confirmation_code) {
                    
                    $user_id = $this->request->getData('user_id');
                    if ($user_id == 0) {
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                        return $response;
                    
                    } else {
                        
                        if($connection->update('users', ['hp_cert' => '1'], ['id' => $this->request->getData('user_id')])) {
                            $connection->commit();
                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                            return $response;
                        
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
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function sendEmailCertification ($user_id = null) 
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

    public function confirmEmail($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $CommonConfirmations = $this->getTableLocator()->get('CommonConfirmation');
        $commonConfirmation = $CommonConfirmations->find('all')->where(['id' => $id])->toArray();

        if ($this->request->is('post')) {
            
            if (FrozenTime::now() < $commonConfirmation[0]->expired) {

                $user_id = $this->request->getData('user_id');
                if ($user_id == 0) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                
                } else {
                    
                    if($connection->update('users', ['email_cert' => '1'], ['id' => $this->request->getData('user_id')])) {
                        $connection->commit();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                        return $response;
                    
                    } else {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                        return $response;
                    }
                }
                
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'timeover']));
                return $response;
            }
        }
    }

    public function generateCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= substr($characters, rand(0, strlen($characters)), 1);
        }
        return $code;
    }

    public function streamNotExist()
    {

    }
}
