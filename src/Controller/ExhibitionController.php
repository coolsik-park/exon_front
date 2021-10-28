<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;
use Cake\ORM\TableRegistry;
use Cake\Event\EventInterface;
use Cake\I18n\FrozenTime;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Cake\Routing\Router;
use Iamport;

class ExhibitionController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        $this->Auth->deny(['add']);
    }   

    public function isAuthorized() {
        if(!empty($this->Auth->user('id'))) {
            return true;
        }
        // Default deny
        return parent::isAuthorized($user);
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Search.Search', ['actions' => ['search']]);
    }
    
    public function index($type = null)
    {
        if (empty($this->Auth->user())) {
            return $this->redirect(['controller' => 'users', 'action' => 'login']);
        }

        $this->paginate = ['limit' => 10];
        $today = FrozenTime::now();

        $front_url = FRONT_URL;

        if ($type == 'all') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id')]))->toArray();
        } elseif ($type == 'ongoing') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.status !=' => 4, 'Exhibition.sdate <=' => $today, 'Exhibition.edate >=' => $today]))->toArray();
        } elseif ($type == 'temp') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.status' => 4]))->toArray();
        } elseif ($type == 'ended') {            
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.edate <' => $today]))->toArray();
        }
        $this->set(compact('exhibitions', 'today', 'front_url'));
    }
    
    public function view($id = null)
    {
        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['Banner', 'ExhibitionFile', 'ExhibitionGroup', 'ExhibitionStream', 'ExhibitionSurvey', 'Users'],
        ]);
        
        if ($this->Auth->user('id') != null) {
            $exhibitionUsers_table = TableRegistry::get('ExhibitionUsers');
            $exhibitionUsers = $exhibitionUsers_table->find('all')->where(['users_id' => $this->Auth->user('id')])->toArray();
        } else {
            $exhibitionUsers = null;
        }
        
        $exhibitiongroups = $this->getTableLocator()->get('ExhibitionGroup');
        $groups = $exhibitiongroups->find('list', ['keyField' => ['id', 'amount'], 'valueField' => 'name'])->where(['exhibition_id' => $id]);
        $users = $this->getTableLocator()->get('Users');
        $user = $users->find()->where(['id' => $exhibition->users_id])->toList();
        
        $this->set(compact('exhibition', 'exhibitionUsers', 'groups', 'user'));
    }
    
    public function add()
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $exhibition = $this->Exhibition->newEmptyEntity();

        if ($this->request->is('post')) {
            
            if ($this->request->getData()['action'] == 'image') {
                
                //메인 사진 업로드
                $img = $this->request->getData()['image'];
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition_temp' . DS . date("Y") . DS . date("m");
                
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
                $data = $this->request->getData();

                $exhibition->users_id = $this->Auth->user('id');
                $exhibition->title = $data['title'];
                $exhibition->description = $data['description'];
                $exhibition->category = $data['category'];
                $exhibition->type = $data['type'];
                if (!empty($data['apply_sdate'])) : 
                $exhibition->apply_sdate = substr($data['apply_sdate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['apply_edate'])) :
                $exhibition->apply_edate = substr($data['apply_edate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['sdate'])) :
                $exhibition->sdate = substr($data['sdate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['edate'])) :
                $exhibition->edate = substr($data['edate'], 0, 10) .' '. substr($data['edate'], 11, 8);
                endif;
                if (!empty($data['cost'])) :
                $exhibition->cost = $data['cost'];
                endif;
                if (!empty($data['private'])) :
                $exhibition->private = $data['private'];
                endif;
                if (!empty($data['auto_approval'])) :
                $exhibition->auto_approval = $data['auto_approval'];
                endif;
                if (!empty($data['name'])) :
                $exhibition->name = $data['name'];
                endif;
                if (!empty($data['tel'])) :
                $exhibition->tel = $data['tel'];
                endif;
                if (!empty($data['email'])) :
                $exhibition->email = $data['email'];
                endif;
                if (!empty($data['require_name'])) :
                    $exhibition->require_name = $data['require_name'];
                endif;
                if (!empty($data['require_email'])) :
                    $exhibition->require_email = $data['require_email'];
                endif;
                if (!empty($data['require_tel'])) :
                    $exhibition->require_tel = $data['require_tel'];
                endif;
                if (!empty($data['require_age'])) :
                    $exhibition->require_age = $data['require_age'];
                endif;
                if (!empty($data['require_group'])) :
                    $exhibition->require_group = $data['require_group'];
                endif;
                if (!empty($data['require_sex'])) :
                    $exhibition->require_sex = $data['require_sex'];
                endif;
                if (!empty($data['require_cert'])) :
                $exhibition->require_cert = $data['require_cert'];
                endif;
                if (!empty($data['detail'])) :
                $exhibition->detail_html = $data['detail'];
                endif;
                if (!empty($data['email_notice'])) :
                $exhibition->email_notice = $data['email_notice'];
                endif;
                if (!empty($data['additional'])) :
                $exhibition->additional = $data['additional'];
                endif;
                if (!empty($data['status'])) :
                $exhibition->status = $data['status'];
                endif;

                if ($result = $this->Exhibition->save($exhibition)) {
                    
                    if (!empty($data['group_name'])) {
                        $ExhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup');
                        $count = count($data['group_name']);

                        for ($i = 0; $i < $count; $i++) {
                            $exhibitionGroup = $ExhibitionGroup->newEmptyEntity();
                            $exhibitionGroup->exhibition_id = $result->id;
                            $exhibitionGroup->name = $data['group_name'][$i];
                            $exhibitionGroup->people = $data['group_people'][$i];
                            $exhibitionGroup->amount = $data['group_amount'][$i];
                            
                            if (!$ExhibitionGroup->save($exhibitionGroup)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }

                    //설문 생성
                    if (!empty($data['text'])) {
                        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
                        $count = count($data['text']);

                        for ($i = 0; $i < $count; $i++) {
                            $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                            $exhibitionSurvey->exhibition_id = $result->id;
                            $exhibitionSurvey->text = $data['text'][$i];
                            $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                            $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                            $exhibitionSurvey->is_multiple = $data['is_multiple'][$i];

                            if (!$surveyResult = $ExhibitionSurvey->save($exhibitionSurvey)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }

                            if ($surveyResult->is_multiple != 'N') {

                                if (!empty($data['child_text_' . $i])) {
                                    $childCount = count($data['child_text_' . $i]);
                                
                                    for ($j = 0; $j < $childCount; $j++) {
                                        $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                        $exhibitionSurvey->exhibition_id = $surveyResult->exhibition_id;
                                        $exhibitionSurvey->text = $data['child_text_' . $i][$j];
                                        $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                        $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                        $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                        $exhibitionSurvey->parent_id = $surveyResult->id;

                                        if (!$ExhibitionSurvey->save($exhibitionSurvey)) {
                                            $connection->rollback(); 
                                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                            return $response;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $connection->commit();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $result->id]));
                    return $response;
                    
                } else {
                    $connection->rollback();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }
        $commonCategory = $this->getTableLocator()->get('CommonCategory');
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $categories = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'category']);
        $types = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'type']);
        $this->set(compact('exhibition', 'users', 'categories', 'types'));
    }

    public function saveImg($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if ($data['image'] != 'undefined') {
                $img = $data['image'];
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if (!file_exists(WWW_ROOT . $path)) {
                    $oldMask = umask(0);
                    mkdir(WWW_ROOT . $path, 0777, true);
                    chmod(WWW_ROOT . $path, 0777);
                    umask($oldMask);
                }
        
                $imgName = $id . "_main." . $expen;
                $destination = WWW_ROOT . $path . DS . $imgName;
                $img->moveTo($destination);

                $exhibition = $this->Exhibition->get($id);
                $exhibition->image_path = $path;
                $exhibition->image_name = $imgName;
        
                if ($this->Exhibition->save($exhibition)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                } else {
                    $connection->rollback(); 
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }       

            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            }
        }
    }
    
    public function edit($id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $exhibition = $this->Exhibition->get($id);

        if ($this->request->is(['post', 'put'])) {
            
            if ($this->request->getData()['action'] == 'image') {
                
                //메인 사진 업로드
                $img = $this->request->getData()['image'];
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition_temp' . DS . date("Y") . DS . date("m");
                
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
                
                $data = $this->request->getData();
                
                $exhibition->title = $data['title'];
                $exhibition->description = $data['description'];
                $exhibition->category = $data['category'];
                $exhibition->type = $data['type'];
                if (!empty($data['apply_sdate'])) : 
                $exhibition->apply_sdate = substr($data['apply_sdate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['apply_edate'])) :
                $exhibition->apply_edate = substr($data['apply_edate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['sdate'])) :
                $exhibition->sdate = substr($data['sdate'], 0, 10) .' '. substr($data['sdate'], 11, 8);
                endif;
                if (!empty($data['edate'])) :
                $exhibition->edate = substr($data['edate'], 0, 10) .' '. substr($data['edate'], 11, 8);
                endif;
                if (!empty($data['cost'])) :
                $exhibition->cost = $data['cost'];
                endif;
                if (!empty($data['private'])) :
                $exhibition->private = $data['private'];
                endif;
                if (!empty($data['auto_approval'])) :
                $exhibition->auto_approval = $data['auto_approval'];
                endif;
                if (!empty($data['name'])) :
                $exhibition->name = $data['name'];
                endif;
                if (!empty($data['tel'])) :
                $exhibition->tel = $data['tel'];
                endif;
                if (!empty($data['email'])) :
                $exhibition->email = $data['email'];
                endif;
                if (!empty($data['require_name'])) :
                    $exhibition->require_name = $data['require_name'];
                endif;
                if (!empty($data['require_email'])) :
                    $exhibition->require_email = $data['require_email'];
                endif;
                if (!empty($data['require_tel'])) :
                    $exhibition->require_tel = $data['require_tel'];
                endif;
                if (!empty($data['require_age'])) :
                    $exhibition->require_age = $data['require_age'];
                endif;
                if (!empty($data['require_group'])) :
                    $exhibition->require_group = $data['require_group'];
                endif;
                if (!empty($data['require_sex'])) :
                    $exhibition->require_sex = $data['require_sex'];
                endif;
                if (!empty($data['require_cert'])) :
                $exhibition->require_cert = $data['require_cert'];
                endif;
                if (!empty($data['detail'])) :
                $exhibition->detail_html = $data['detail'];
                endif;
                if (!empty($data['email_notice'])) :
                $exhibition->email_notice = $data['email_notice'];
                endif;
                if (!empty($data['additional'])) :
                $exhibition->additional = $data['additional'];
                endif;
                if (!empty($data['status'])) :
                $exhibition->status = $data['status'];
                endif;

                if ($this->Exhibition->save($exhibition)) {
                    $ExhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup');
                    
                    if (!empty($data['group_name'])) {    
                        $count = count($data['group_id']);

                        for ($i = 0; $i < $count; $i ++) {
                            
                            if ($data['group_id'][$i] != 0) {
                                $exhibitionGroup = $ExhibitionGroup->get($data['group_id'][$i]);
                                $exhibitionGroup->name = $data['group_name'][$i];
                                $exhibitionGroup->people = $data['group_people'][$i];
                                $exhibitionGroup->amount = $data['group_amount'][$i];
                            
                            } else {
                                $exhibitionGroup = $ExhibitionGroup->newEmptyEntity();
                                $exhibitionGroup->exhibition_id = $id;
                                $exhibitionGroup->name = $data['group_name'][$i];
                                $exhibitionGroup->people = $data['group_people'][$i];
                                $exhibitionGroup->amount = $data['group_amount'][$i];
                            }
                            
                            
                            if (!$ExhibitionGroup->save($exhibitionGroup)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }
                    
                    if (!empty($data['group_del'])) {
                        $count = count($data['group_del']);

                        for ($i = 0; $i < $count; $i ++) {

                            if ($data['group_del'][$i] != 0) {
                                $exhibitionGroup = $ExhibitionGroup->get($data['group_del'][$i]);
                                if (!$ExhibitionGroup->delete($exhibitionGroup)) {
                                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                    return $response;
                                }
                            }
                        }
                    }
                    
                    $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
                    
                    if (!empty($data['text'])) {
                        
                        $count = count($data['text']);

                        for ($i = 0; $i < $count; $i++) {
                            
                            if ($data['survey_id'][$i] != 0) {
                                $exhibitionSurvey = $ExhibitionSurvey->get($data['survey_id'][$i]);
                                $exhibitionSurvey->text = $data['text'][$i];
                                $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                                $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                                $exhibitionSurvey->is_multiple = $data['is_multiple'][$i];
                            
                            } else {
                                $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                $exhibitionSurvey->exhibition_id = $id;
                                $exhibitionSurvey->text = $data['text'][$i];
                                $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                                $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                                $exhibitionSurvey->is_multiple = $data['is_multiple'][$i];
                            }
                            
                            if (!$surveyResult = $ExhibitionSurvey->save($exhibitionSurvey)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                            
                            if ($surveyResult->is_multiple != 'N') {

                                if (!empty($data['child_text_' . $i])) {

                                    $childCount = count($data['child_text_' . $i]);
                                
                                    for ($j = 0; $j < $childCount; $j++) {
                                        
                                        if ($data['child_survey_id_' . $i][$j] != 0) {
                                            $exhibitionSurvey = $ExhibitionSurvey->get($data['child_survey_id_' . $i][$j]);
                                            $exhibitionSurvey->text = $data['child_text_' . $i][$j];
                                            $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                            $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                            $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                        
                                        } else {
                                            $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                            $exhibitionSurvey->exhibition_id = $surveyResult->exhibition_id;
                                            $exhibitionSurvey->text = $data['child_text_' . $i][$j];
                                            $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                            $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                            $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                            $exhibitionSurvey->parent_id = $surveyResult->id;
                                        }

                                        if (!$ExhibitionSurvey->save($exhibitionSurvey)) {
                                            $connection->rollback(); 
                                            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                            return $response;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if (!empty($data['survey_del'])) {
                        $count = count($data['survey_del']);

                        for ($i = 0; $i < $count; $i ++) {

                            if ($data['survey_del'][$i] != 0) {
                                $exhibitionSurvey = $ExhibitionSurvey->get($data['survey_del'][$i]);
                                if (!$ExhibitionSurvey->delete($exhibitionSurvey)) {
                                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                    return $response;
                                }
                            }
                        }
                    }

                    if (!empty($data['child_survey_del'])) {
                        $count = count($data['child_survey_del']);

                        for ($i = 0; $i < $count; $i ++) {

                            if ($data['child_survey_del'][$i] != 0) {
                                $exhibitionSurvey = $ExhibitionSurvey->get($data['child_survey_del'][$i]);

                                if (!$ExhibitionSurvey->delete($exhibitionSurvey)) {
                                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                    return $response;
                                }
                            }
                        }
                    }
                    $connection->commit();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $id]));
                    return $response;
                    
                } else {
                    $connection->rollback(); 
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }
            }
        }
        $commonCategory = $this->getTableLocator()->get('CommonCategory');
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $categories = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'category']);
        $types = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'type']);
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => 'ChildExhibitionSurvey'])->where(['exhibition_id' => $id, 'parent_id IS' => null])->toArray();
        $this->set(compact('id', 'exhibition', 'users', 'categories', 'types', 'exhibitionGroups', 'exhibitionSurveys'));
    }

    public function copy($id = null) {
        
        if ($this->request->is('post')) {
            $copiedExhibition = $this->Exhibition->get($id);
            $copiedExhibition->id = null;
            $newExhibition = $this->Exhibition->newEmptyEntity();
            
            $newExhibition->users_id = $copiedExhibition->users_id;
            $newExhibition->title = $copiedExhibition->title;
            $newExhibition->description = $copiedExhibition->description;
            $newExhibition->category = $copiedExhibition->category;
            $newExhibition->type = $copiedExhibition->type;
            $newExhibition->detail_html = $copiedExhibition->detail_html;
            $newExhibition->apply_sdate = $copiedExhibition->apply_sdate;
            $newExhibition->apply_edate = $copiedExhibition->apply_edate;
            $newExhibition->sdate = $copiedExhibition->sdate;
            $newExhibition->edate = $copiedExhibition->edate;
            $newExhibition->image_path = $copiedExhibition->image_path;
            $newExhibition->image_name = $copiedExhibition->image_name;
            $newExhibition->private = $copiedExhibition->private;
            $newExhibition->auto_approval = $copiedExhibition->auto_approval;
            $newExhibition->name = $copiedExhibition->name;
            $newExhibition->tel = $copiedExhibition->tel;
            $newExhibition->email = $copiedExhibition->email;
            $newExhibition->require_name = $copiedExhibition->require_name;
            $newExhibition->require_email = $copiedExhibition->require_email;
            $newExhibition->require_tel = $copiedExhibition->require_tel;
            $newExhibition->require_age = $copiedExhibition->require_age;
            $newExhibition->require_group = $copiedExhibition->require_group;
            $newExhibition->require_sex = $copiedExhibition->require_sex;
            $newExhibition->require_cert = $copiedExhibition->require_cert;
            $newExhibition->email_notice = $copiedExhibition->email_notice;
            $newExhibition->additional = $copiedExhibition->additional;
            $newExhibition->status = 4;
            $newExhibition->notice = $copiedExhibition->notice;
            $newExhibition->program = $copiedExhibition->program;
            $newExhibition->cost = $copiedExhibition->cost;

            if ($this->Exhibition->save($newExhibition)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            } else {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
        }
    }

    public function getUserInfo()
    {
        $User = $this->getTableLocator()->get('Users');
        $user = $User->get($this->Auth->user('id'));

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'name' => $user->name, 'tel' => $user->hp, 'email' => $user->email]));
        return $response;
    }
    
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        
        $exhibition = $this->Exhibition->get($id);
        
        if ($this->Exhibition->delete($exhibition)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));        
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));        
        }

        return $response;    
    }

    public function managerPerson($id = null, $word = null)
    {
        $this->paginate = ['limit' => 10];

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status !=' => 8]))->toArray();

        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $user[] = [];
        for ($i=0; $i<$count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData) {
                $user[$i]['age'] = date('Y') - (int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                $user[$i]['company'] = $exhibition[0]->users[$i]->company;
            }
        }

        $exhibitionSurvey_table = TableRegistry::get('ExhibitionSurvey');
        $exhibitionSurvey = $exhibitionSurvey_table->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);
        $exhibitionSurveys = $exhibitionSurvey->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'B'])
            ->toArray();
        $parent_id = 0;
        $i = 0;
        $j = 0;
        $beforeParentData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $beforeParentData[$i] = $exhibitionSurvey;
                $i++;
            }
        }
        
        $this->set(compact('id', 'exhibition_users', 'user', 'beforeParentData'));
    }

    public function exhibitionUsersStatus($id = null)
    {
        $email = $this->request->getData('email');
        $pay_id = $this->request->getData('pay_id');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => '0'], ['id' => $id])) {

            $Pay = $this->getTableLocator()->get('Pay');
            $pay = $Pay->get($pay_id);
            
            // require_once("iamport-rest-client-php/src/iamport.php");
            
            // $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));

            // $result = $iamport->cancel(array(
            //     'imp_uid'		=> $pay->imp_uid, 		
            //     'merchant_uid'	=> $pay->merchant_uid, 	
            //     'amount' 		=> 0,				
            //     'reason'		=> '행사 관리자 취소',			
            // ));

            // if ($result->success) {
            
                // $payment_data = $result->data;
                $now = FrozenTime::now();
                

                $pay->cancel_reason = '행사 관리자 취소';
                $pay->cancel_date = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
                
                if ($Pay->save($pay)) {
                    $connection->commit();

                    $mailer = new Mailer();
                    $mailer->setTransport('mailjet');

                    $exhibition = $this->Exhibition->get($id);
                    $user_name = $this->request->getData('user_name');   
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;    
                    
                    $mailer->setEmailFormat('html')
                                ->setTo($to)
                                ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                ->setSubject('Exon - 참가취소 확인 메일입니다.')
                                ->viewBuilder()
                                ->setTemplate('canceled')
                            ;
                    $mailer->setViewVars(['front_url' => FRONT_URL]);
                    $mailer->setViewVars(['user_name' => $user_name]);
                    $mailer->setViewVars(['title' => $exhibition->title]);
                    $mailer->setViewVars(['apply_sdate' => $exhibition->apply_sdate]);
                    $mailer->setViewVars(['apply_edate' => $exhibition->apply_edate]);
                    $mailer->setViewVars(['sdate' => $exhibition->sdate]);
                    $mailer->setViewVars(['edate' => $exhibition->edate]);
                    $mailer->setViewVars(['name' => $exhibition->name]);
                    $mailer->setViewVars(['tel' => $exhibition->tel]);
                    $mailer->setViewVars(['email' => $exhibition->email]);
                    $mailer->setViewVars(['refund' => $payment_data->cancel_amount]);
                    $mailer->setViewVars(['now' => FrozenTime::now()]);
                    
                    $mailer->deliver();
                
                } else {
                    $this->Flash->error(__('Pay could not be saved'));
                }
                
            // } else {
            //     $this->Flash->error(__('The payment could not be canceled.'));
            // }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        
        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }

    public function exhibitionUsersApproval($id = null)
    {
        $status = $this->request->getData('status');
        $to = $this->request->getData('email');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);
        
        if($connection->update('exhibition_users', ['status' => $status], ['id' => $id])) {
            $connection->commit();

            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $Exhibition = $this->getTableLocator()->get('Exhibition');
            $exhibition = $Exhibition->get($id); 
            $Group = $this->getTableLocator()->get('ExhibitionGroup');
            $group = $Group->get($answerData['exhibition_group_id']);            
            
            $mailer->setEmailFormat('html')
                        ->setTo($to)
                        ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                        ->setSubject('Exon - 참가확정 확인 메일입니다.')
                        ->viewBuilder()
                        ->setTemplate('webinar_apply_confirmed')
                    ;
            $mailer->setViewVars(['front_url' => FRONT_URL]);
            $mailer->setViewVars(['user_name' => $answerData['users_name']]);
            $mailer->setViewVars(['title' => $exhibition->title]);
            $mailer->setViewVars(['apply_sdate' => $exhibition->apply_sdate]);
            $mailer->setViewVars(['apply_edate' => $exhibition->apply_edate]);
            $mailer->setViewVars(['sdate' => $exhibition->sdate]);
            $mailer->setViewVars(['edate' => $exhibition->edate]);
            $mailer->setViewVars(['name' => $exhibition->name]);
            $mailer->setViewVars(['tel' => $exhibition->tel]);
            $mailer->setViewVars(['email' => $exhibition->email]);
            $mailer->setViewVars(['group' => $group->name]);
            $mailer->setViewVars(['now' => FrozenTime::now()]);
            
            $mailer->deliver();

            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;

        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['test' => 'fail']));
        }
    }

    public function userSurveyView($id = null)
    {
        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        // return $this->redirect(['controller' => 'exhibitionSurvey', 'action' => 'surveyUserAnswer', $exhibition_user->exhibition_id]);
    }

    public function exhibitionCancle()
    {
        
    }

    // public function search()
    // {
    //     $this->paginate['maxLimit'] = 999;
    //     $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
    //     $exhibition_users = $this->paginate($exhibition_users_table->find('search', ['search' => $this->request->getQuery()]))->toArray();

    //     $this->set(compact('exhibition_users'));
    //     $this->set('_serialize', ['exhibition_users']);

    //     return $this->redirect(['action' => 'managerPerson', $exhibition_user->exhibition_id]);
    // }

    public function sendEmailToParticipant($id = null, $exhibition_users_id = null)
    {
        if ($exhibition_users_id != null) {
            $lists = explode(",", $exhibition_users_id);
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();

        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        $session = $this->request->getSession();
        $text = $session->consume('text');
        
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $users_email = $this->request->getData('users_email');
            $to = explode(",", $users_email);
            $contents = $this->request->getData('email_content');

            $mailer->setEmailFormat('html')
                        ->setTo($to)
                        ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => $this->request->getData('name')])
                        ->setSubject('Exon - 행사 메일입니다.')
                        ->viewBuilder()
                        ->setTemplate('exhibition')
                    ;

            $mailer->setViewVars(['front_url' => FRONT_URL]);
            $mailer->setViewVars(['contents' => $contents]);
            
            $mailer->deliver();

            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
        $listExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'exhibitionUsers', 'exhibition_users_id', 'listExhibitionUsers', 'exhibitionGroups', 'text'));
    }

    public function sendSmsToParticipant($id = null, $exhibition_users_id = null)
    {
        require_once(ROOT . "/solapi-php/lib/message.php");
        
        if ($exhibition_users_id != null) {
            $lists = explode(",", $exhibition_users_id);
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();
        
        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        $session = $this->request->getSession();
        $text = $session->consume('text');
        
        if ($this->request->is('post')) {
            
            $users_hp = $this->request->getData('users_hp');
            $to = explode(",", $users_hp);

            $messages = [
                [
                'to' => $to,
                'from' => getEnv('EXON_PHONE_NUMBER'), //현재 대표님 번호로 설정되어 있음.
                'text' => $this->request->getData('sms_content')
                ]
            ];

            if (send_messages($messages)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                return $response;
            
            } else {
                $this->Flash->error(__('The SMS could not be delivered.'));
            }
        }
        $listExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
            ->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'exhibitionUsers', 'exhibition_users_id', 'listExhibitionUsers', 'exhibitionGroups', 'text'));
    }

    public function participantList($id = null)
    {
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
            ->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();

        if ($this->request->is('post')) {
            $data = $this->request->getData('data');
            $text = $this->request->getData('text');
            $session = $this->request->getSession();
            $session->write('text', $text);
            
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'type' => 'email', 'data' => $data]));
            return $response;
        }
        $this->set(compact('exhibitionUsers', 'exhibitionGroups', 'id', 'type'));
    }

    public function sortByStatus($id = null, $status = null) 
    {
        if ($status == 0) {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
                ->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
                ->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status' => $status])->toArray();
        }

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $exhibitionUsers]));
        return $response;
    }

    public function sortByGroup($id = null, $group = null) 
    {
        if ($group == 0) {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
                ->where(['ExhibitionUsers.exhibition_id' => $id])->toArray();
        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
                ->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.exhibition_group_id' => $group])->toArray();
        }

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $exhibitionUsers]));
        return $response;
    }

    public function searchParticipant($id = null, $key = null)
    {
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionGroup'])
            ->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.users_name LIKE' => '%'.$key.'%'])->toArray();

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $exhibitionUsers]));
        return $response;
    }

    public function surveyData($id = null)
    {
        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);

        //사전설문 데이터

        $exhibitionSurveys = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 
                'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'B'])
            ->toArray();
        
        $parent_id = 0;
        $i = 0;
        $j = 0;
        $beforeParentData[] = null;
        $beforeChildData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $beforeParentData[$i] = $exhibitionSurvey;
                $i++;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $beforeChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }
        
        //일반설문 데이터

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);

        $exhibitionSurveys = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 
                'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id, 'survey_type' => 'N'])
            ->toArray();
        
        
        $parent_id = 0;
        $i = 0;
        $j = 0;
        $normalParentData[] = null;
        $normalChildData[] = null;
        foreach ($exhibitionSurveys as $exhibitionSurvey) {
            if ($exhibitionSurvey['parent_id'] == null) {
                $parent_id = $exhibitionSurvey['id'];
                $normalParentData[$i] = $exhibitionSurvey;
                $i++;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $normalChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }

        if ($this->request->is('post')) {
            
            $data = $this->request->getData('checked');
            $count = count($data);

            //엑셀 파일 저장
            $spreadsheet = new Spreadsheet();

            //Specify the properties for this document
            $spreadsheet->getProperties()
                ->setTitle('설문 데이터')
                ->setCreator('EXON.com')
                ->setLastModifiedBy('EXON.com');

            for ($i = 0; $i < ($count-1); $i++) {
                $spreadsheet->createSheet();
            }

            for ($i = 0; $i < $count; $i++) {
                $spreadsheet->setActiveSheetIndex($i)
                ->setTitle('질문' . ($i+1))
                ->setCellValue('A1', '');

                $spreadsheet->getActiveSheet($i)
                ->setCellValue('B1', '이름')
                ->setCellValue('C1', '이메일')
                ->setCellValue('D1', '질문' . ($i+1));
            }

            $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
            $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id, 'users_id IS NOT' => null])->toArray();
            $rowCount = count($exhibitionUsers);

            $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
            $ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer');

            $exhibitionSurvey = $ExhibitionSurvey->find('all', [
                'conditions' => [
                    'or' => [
                        'id IN' => $data,
                        'parent_id IN' => $data
                    ]
                ]
            ])->select(['id'])->toArray();

            $checkedCount = count($exhibitionSurvey);
            for ($i = 0; $i < $checkedCount; $i++) {
                $checked[$i] = $exhibitionSurvey[$i]['id'];
            }

            $answered[] = '';
            $answeredCount = 0;
            for ($i = 0; $i < $rowCount; $i++) {
                $exhibitionSurveyUsersAnswer = $ExhibitionSurveyUsersAnswer->find('all', [
                    'conditions' => [
                        'text IS NOT' => 'question',
                        'exhibition_survey_id IN' => $checked,
                        'or' => [
                            'text' => 'Y',
                            'text IS NOT' => ''
                        ]
                    ]
                ])->where(['users_id' => $exhibitionUsers[$i]['users_id']])->toArray();
                
                $answerCount = count($exhibitionSurveyUsersAnswer);
                
                if ($answerCount != 0) {

                    $k = 0;
                    for ($j = 0; $j < $answerCount; $j++) {
                        
                        if ($exhibitionSurveyUsersAnswer[$j]['text'] == 'Y') {
                            
                            $nextCount = 0;
                            $survey_text = '';
                            foreach ($exhibitionSurveyUsersAnswer as $answer) {
                                if ($exhibitionSurveyUsersAnswer[$j]['parent_id'] == $answer['parent_id']) {
                                    $nextCount ++;
                                    $text = $ExhibitionSurvey->find('all')->where(['id' => $answer['exhibition_survey_id']])->toArray()[0]['text']; 
                                    $survey_text .= $text . ' ';
                                }
                            }
                            if ($nextCount == 0) {
                                $text = $ExhibitionSurvey->find('all')->where(['id' => $exhibitionSurveyUsersAnswer[$j]['exhibition_survey_id']])->toArray()[0]['text'];
                                $answered[$k] = $exhibitionSurveyUsersAnswer[$j]['exhibition_survey_id'];
                            
                            } else {
                                $answered[$k] = $survey_text;
                            }
                            $j = $j + $nextCount -1;
                            
                        } else {
                            $answered[$k] = $exhibitionSurveyUsersAnswer[$j]['text'];
                        }
                        $k++;
                    }
                    $answeredCount = count($answered); 

                } else {
                    for ($x = 0; $x < $answeredCount; $x ++) {
                        $answered[$x] = '';    
                    }
                }
                
                $answerData[$i] = [ 
                    'users_id' => $exhibitionUsers[$i]['users_id'],
                    'answered' => $answered 
                ];
            }
            
            for ($i = 0; $i < $count; $i++) {
                $exhibitionSurvey = $ExhibitionSurvey->find('all')->where(['id' => $data[$i]])->toArray();
                $question = $exhibitionSurvey[0]['text'];

                $spreadsheet->setActiveSheetIndex($i)
                ->setTitle($question)
                ->setCellValue('A1', '');

                $spreadsheet->setActiveSheetIndex($i)
                ->getColumnDimension('C')->setWidth(30);	

                $spreadsheet->setActiveSheetIndex($i)
                ->getColumnDimension('D')->setWidth(30);

                $spreadsheet->getActiveSheet($i)
                ->setCellValue('B1', '이름')
                ->setCellValue('C1', '이메일')
                ->setCellValue('D1', $question);

                for ($j = 0; $j < $rowCount; $j++) {
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('A' . ($j+2), ($j+1))
                        ->setCellValue('B' . ($j+2), $exhibitionUsers[$j]['users_name'])
                        ->setCellValue('C' . ($j+2), $exhibitionUsers[$j]['users_email']);           
                }
                for ($j = 0; $j < $rowCount; $j++) {
                    
                    if ($answerData[$j]['answered'][0] == '') {
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('D' . ($j+2), '');
                    
                    } else {  
                        $text =  $answerData[$j]['answered'][$i];
                        $lists = explode(" ", $text);
                        
                        $spreadsheet->getActiveSheet($i)
                        ->setCellValue('D' . ($j+2), $text);
                    }
                }
            }
            
            $path = 'download' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
        
            if (!file_exists(WWW_ROOT . $path)) {
                $oldMask = umask(0);
                mkdir(WWW_ROOT . $path, 0777, true);
                chmod(WWW_ROOT . $path, 0777);
                umask($oldMask);
            }

            $fileName = $id . "_survey_data." . "xlsx";
            $destination = WWW_ROOT . $path . DS . $fileName;

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
            $writer->save($destination);
            
            //엑셀 파일 다운로드
            $down = $destination;
            
            if(file_exists($down)) {
                header("Content-Type:application/octet-stream");
                header("Content-Disposition:attachment;filename=$fileName");
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
            } else {
                
            }
        }
        
        $this->set(compact('beforeParentData', 'beforeChildData', 'normalParentData', 'normalChildData', 'id'));
    }

    public function exhibitionStatisticsApply($id = null)
    {
        //신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->toArray();
    
        //성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status IN' => [1, 2, 4]])->toArray();
        
        //나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status != 8) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        $this->set(compact('id', 'applyRates', 'genderRates', 'ages'));
    }

    public function exhibitionStatisticsParticipant($id = null)
    {
        //현재 신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //참가자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup'));
    }

    public function exhibitionStatisticsParticipantByGroup($id = null, $group = null)
    {
        //현재 그룹 신청자 수
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //그룹 참가자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //그룹 나이대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'group', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup'));
    }

    public function exhibitionStatisticsStream($id = null) 
    {
        //출결석 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //질문 응답 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionQuestion'])->where(['exhibition_id' => $id])->toArray();
        $total = 0;
        $countI = count($exhibitionUsers);
        for ($i = 0; $i < $countI; $i++) {
            $countJ = count($exhibitionUsers[$i]->exhibition_question);
            for ($j = 0; $j < $countJ; $j++) {
                if ($exhibitionUsers[$i]->exhibition_question[$j]->parent_id == null) {
                    $total++;
                }
            }
        }

        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $answered = $exhibitionUsers->select(['count' =>$exhibitionUsers->func()->count('ExhibitionQuestion.id')])
            ->innerJoinWith('ExhibitionQuestion', function ($q) {
                return $q->where(['ExhibitionQuestion.parent_id IS NOT' => null]);
            })
            ->toArray();

        $answeredData = [
            'total' => $total,
            'answered' => $answered[0]->count
        ];

        //시청자 나이 대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 || $exhibition[0]->users[$i]->_joinData->attend == 4) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        //시청자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates'));
    }

    public function exhibitionStatisticsStreamByGroup($id = null, $group = null)
    {
        //출결석 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //질문 응답 비율
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all', ['contain' => 'ExhibitionQuestion'])->where(['exhibition_id' => $id, 'exhibition_group_id' => $group])->toArray();
        $total = 0;
        $countI = count($exhibitionUsers);
        for ($i = 0; $i < $countI; $i++) {
            $countJ = count($exhibitionUsers[$i]->exhibition_question);
            for ($j = 0; $j < $countJ; $j++) {
                if ($exhibitionUsers[$i]->exhibition_question[$j]->parent_id == null) {
                    $total++;
                }
            }
        }

        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $answered = $exhibitionUsers->select(['count' =>$exhibitionUsers->func()->count('ExhibitionQuestion.id')])
            ->innerJoinWith('ExhibitionQuestion', function ($q) {
                return $q->where(['ExhibitionQuestion.parent_id IS NOT' => null]);
            })
            ->toArray();

        $answeredData = [
            'total' => $total,
            'answered' => $answered[0]->count
        ];
        
        //시청자 나이 대
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group || $exhibition[0]->users[$i]->_joinData->attend == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
            }
        }

        //시청자 성비
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'group', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates'));
    }

    public function exhibitionStatisticsExtra($id = null) 
    {
        //설문 별 응답률
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ids[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 2 || $exhibition[0]->users[$i]->_joinData->status == 4) {
                $ids[$i] = $exhibition[0]->users[$i]->id;
            }
        }

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')
            ->where(['exhibition_id' => $id, 'ExhibitionSurveyUsersAnswer.parent_id IS' => null, 'ExhibitionSurveyUsersAnswer.users_id IN' => $ids]);
        $answerRates = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.text', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.id')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer')
            ->group('ExhibitionSurvey.id')
            ->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('status')])->where(['status IN' => [2, 4]])->toArray();

        //첫방문 or 재방문

        //재방문 유저 탐색
        $participatedCount = 0;
        $exhibition = $this->Exhibition->find('all')->where(['id' => $id])->toArray();
        $currentExhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $currentExhibitionParticipant[] = '';
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4){
                $currentExhibitionParticipant[$i] = $currentExhibition[0]->users[$i]->_joinData->users_id;
            }
        }

        $previousExhibition[] = '';
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['users_id' => $exhibition[0]->users_id])->toArray();
        $count = count($exhibition);    
        for ($i = 0; $i < $count; $i++ ) {
            if ((int)$exhibition[$i]->created->i18nFormat('yyyyMMddHHmmss') < (int)$currentExhibition[0]->created->i18nFormat('yyyyMMddHHmmss')) {
                $previousExhibition[$i] = $exhibition[$i];
            }
        }
        
        if ($previousExhibition[0] != '') {
            $previousExhibitionParticipant[] = '';
            $countI = count($previousExhibition);
            $k = 0;
            for ($i = 0; $i < $countI; $i++) {
                $countJ = count($previousExhibition[$i]->users);
                for ($j = 0; $j < $countJ; $j++) {
                    if ($previousExhibition[$i]->users[$j]->_joinData->status == 4) {
                        $previousExhibitionParticipant[$k] = $previousExhibition[$i]->users[$j]->id;
                        $k++;              
                    }  
                }
            }
            $previousExhibitionParticipant = array_unique($previousExhibitionParticipant);
            $previousExhibitionParticipant = array_values($previousExhibitionParticipant);

            $countK = count($currentExhibitionParticipant);
            $countL = count($previousExhibitionParticipant);
            for ($k = 0; $k < $countK; $k++) {
                for ($l = 0; $l < $countL; $l++) {
                    if ($currentExhibitionParticipant[$k] == $previousExhibitionParticipant[$l]) {
                        $participatedCount++;
                    }
                }
            }
        } 
        
        //참가자 수
        $totalParticipant = 0;
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4)  {
                $totalParticipant++;
            }
        }
        
        $participatedData = [
            'total' => $totalParticipant,
            'participated' => $participatedCount,
        ];

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'answerRates', 'applyRates', 'participatedData', 'exhibitionGroup'));
    }

    public function exhibitionStatisticsExtraByGroup ($id = null, $group = null) {
        //설문 별 응답률
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['Exhibition.id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ids[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 2 || $exhibition[0]->users[$i]->_joinData->status == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                $ids[$i] = $exhibition[0]->users[$i]->id;
            }
        }

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')
            ->where(['exhibition_id' => $id, 'ExhibitionSurveyUsersAnswer.parent_id IS' => null, 'ExhibitionSurveyUsersAnswer.users_id IN' => $ids]);
        $answerRates = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.text', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.id')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer')
            ->group('ExhibitionSurvey.id')
            ->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'users_id IN' => $ids]);
        $applyRates = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('status')])->where(['status IN' => [2, 4]])->toArray();

        //첫방문 or 재방문

        //재방문 유저 탐색
        $participatedCount = 0;
        $exhibition = $this->Exhibition->find('all')->where(['id' => $id])->toArray();
        $currentExhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $currentExhibitionParticipant[] = '';
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4 && $currentExhibition[0]->users[$i]->_joinData->exhibition_group_id == $group){
                $currentExhibitionParticipant[$i] = $currentExhibition[0]->users[$i]->_joinData->users_id;
            }
        }

        $previousExhibition[] = '';
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['users_id' => $exhibition[0]->users_id])->toArray();
        $count = count($exhibition);    
        for ($i = 0; $i < $count; $i++ ) {
            if ((int)$exhibition[$i]->created->i18nFormat('yyyyMMddHHmmss') < (int)$currentExhibition[0]->created->i18nFormat('yyyyMMddHHmmss')) {
                $previousExhibition[$i] = $exhibition[$i];
            }
        }
        
        if ($previousExhibition[0] != '') {
            $previousExhibitionParticipant[] = '';
            $countI = count($previousExhibition);
            $k = 0;
            for ($i = 0; $i < $countI; $i++) {
                $countJ = count($previousExhibition[$i]->users);
                for ($j = 0; $j < $countJ; $j++) {
                    if ($previousExhibition[$i]->users[$j]->_joinData->status == 4) {
                        $previousExhibitionParticipant[$k] = $previousExhibition[$i]->users[$j]->id;
                        $k++;              
                    }  
                }
            }
            $previousExhibitionParticipant = array_unique($previousExhibitionParticipant);
            $previousExhibitionParticipant = array_values($previousExhibitionParticipant);

            $countK = count($currentExhibitionParticipant);
            $countL = count($previousExhibitionParticipant);
            for ($k = 0; $k < $countK; $k++) {
                for ($l = 0; $l < $countL; $l++) {
                    if ($currentExhibitionParticipant[$k] == $previousExhibitionParticipant[$l]) {
                        $participatedCount++;
                    }
                }
            }
        } 
        
        //참가자 수
        $totalParticipant = 0;
        $count = count($currentExhibition[0]->users);
        for ($i = 0; $i < $count; $i++) {
            if ($currentExhibition[0]->users[$i]->_joinData->status == 4 && $currentExhibition[0]->users[$i]->_joinData->exhibition_group_id == $group)  {
                $totalParticipant++;
            }
        }
        
        $participatedData = [
            'total' => $totalParticipant,
            'participated' => $participatedCount,
        ];

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $this->set(compact('id', 'group', 'answerRates', 'applyRates', 'participatedData', 'exhibitionGroup'));
    }

    public function exhibitionSupervise($id = null, $type = null)
    {
        $this->paginate = ['limit' => 10];
        $today = new \DateTime();

        if ($type == null) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id]))->toArray();
        } elseif ($type == 1) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.status !=' => 4, 'Exhibition.sdate >' => $today]))->toArray();
        } elseif ($type == 2) {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.status' => 4]))->toArray();
        } elseif ($type == 3) {            
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $id, 'Exhibition.edate <' => $today]))->toArray();
        }

        $this->set(compact('id', 'exhibitions'));
    }
}
