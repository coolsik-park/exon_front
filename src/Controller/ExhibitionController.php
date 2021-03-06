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
        $this->Auth->deny(['index']);
        $this->Auth->deny(['add']);
        $this->Auth->deny(['edit']);
        $this->Auth->deny(['managerPerson']);
        $this->Auth->deny(['surveyData']);
        $this->Auth->deny(['sendSmsToParticipant']);
        $this->Auth->deny(['sendEmailToParticipant']);
        $this->Auth->deny(['exhibitionStatisticsApply']);
        $this->Auth->deny(['exhibitionStatisticsParticipant']);
        $this->Auth->deny(['exhibitionStatisticsParticipantByGroup']);
        $this->Auth->deny(['exhibitionStatisticsStream']);
        $this->Auth->deny(['exhibitionStatisticsStreamByGroup']);
        $this->Auth->deny(['exhibitionStatisticsExtra']);
        $this->Auth->deny(['exhibitionStatisticsExtraByGroup']);
        $this->Auth->deny(['vodDownload']);
        $this->Auth->deny(['exhibitionStatisticsVod']);
        $this->Auth->deny(['vodWatching']);
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
        date_default_timezone_set('Asia/Seoul');
        $today = date('Y-m-d H:i:s', time());

        $this->paginate = ['limit' => 10];

        if ($type == 'all') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.edate >=' => $today, 'Exhibition.status !=' => 8])->order(['Exhibition.created' => 'DESC']))->toArray();
        } elseif ($type == 'ongoing') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.status !=' => 4, 'Exhibition.status !=' => 8, 'Exhibition.sdate <=' => $today, 'Exhibition.edate >=' => $today])->order(['Exhibition.created' => 'DESC']))->toArray();
        } elseif ($type == 'temp') {
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.status' => 4, 'Exhibition.status !=' => 8])->order(['Exhibition.created' => 'DESC']))->toArray();
        } elseif ($type == 'ended') {            
            $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.edate <=' => $today, 'Exhibition.status !=' => 8])->order(['Exhibition.created' => 'DESC']))->toArray();
        }

        $front_url = FRONT_URL;

        if ($exhibitions == null) {
            $exhibition_user = [];
        } else {
            $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
            foreach($exhibitions as $key => $exhibition) {
                $exhibition_users = $exhibition_users_table->find()->select(['count' => 'count(ExhibitionUsers.id)'])->where(['ExhibitionUsers.exhibition_id' => $exhibition->id, 'ExhibitionUsers.status' => '4'])->toArray();
                
                if ($exhibition_users == null) {
                    $exhibition_user[$key] = null;
                } else {
                    $exhibition_user[$key] = $exhibition_users[0]->count;
                }
            }
        }
        $this->set(compact('exhibitions', 'front_url', 'exhibition_user'));
    }

    public function vodDownload()
    {
        $exhibitions = $this->paginate($this->Exhibition->find('all', ['contain' => ['Users', 'ExhibitionStream']])->where(['Exhibition.users_id' => $this->Auth->user('id'), 'Exhibition.status !=' => 8])->order(['Exhibition.created' => 'DESC']))->toArray();
        $front_url = FRONT_URL;

        $this->set(compact('exhibitions', 'front_url'));
    }
    
    public function view($id = null)
    {
        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['Banner', 'ExhibitionFile', 'ExhibitionGroup', 'ExhibitionStream', 'ExhibitionSurvey', 'Users'],
        ]);

        if ($exhibition->status == 8) {
            return $this->redirect([
                'controller' => 'pages',
                'action' => 'home'
            ]);
        }
        
        if ($this->Auth->user('id') != null) {
            $exhibitionUsers_table = TableRegistry::get('ExhibitionUsers');
            $exhibitionUsers = $exhibitionUsers_table->find('all')->where(['exhibition_id' => $id, 'status IS NOT' => 8, 'users_id' => $this->Auth->user('id')])->toArray();
        } else {
            $exhibitionUsers = null;
        }
        
        $exhibitiongroups = $this->getTableLocator()->get('ExhibitionGroup');
        $groups = $exhibitiongroups->find('list', ['keyField' => ['id', 'amount', 'people'], 'valueField' => 'name'])->where(['exhibition_id' => $id]);
        $users = $this->getTableLocator()->get('Users');
        $user = $users->find()->where(['id' => $exhibition->users_id])->toList();
        
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        if (!empty($this->Auth->user())) :
            $exhibitionUser = $ExhibitionUsers->find('all')->where(['users_id' => $this->Auth->user('id'), 'exhibition_id' => $id])->toArray();
            if (!empty($exhibitionUser)) :
                $users_id = $exhibitionUser[0]['id'];
            else :
                $users_id = null;
            endif;
        else :
            $users_id = null;
        endif;
        
        $this->set(compact('exhibition', 'exhibitionUsers', 'groups', 'user', 'users_id'));
    }

    public function groupPeopleCount()
    {
        $group_id = $this->request->getData('group_id');
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $people_count = $exhibitionUsers->find()->where(['exhibition_group_id' => $group_id]);

        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'test' => $people_count]));
        return $response;
    }
    
    public function add()
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();
        $exhibition = $this->Exhibition->newEmptyEntity();

        if ($this->request->is('post')) {
            
            if ($this->request->getData()['action'] == 'image') {
                
                //?????? ?????? ?????????
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
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => '????????? ??????????????? ??????????????????.',]));
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
                $exhibition->apply_sdate = substr($data['apply_sdate'], 0, 10) .' '. substr($data['apply_sdate'], 11, 8);
                endif;
                if (!empty($data['apply_edate'])) :
                $exhibition->apply_edate = substr($data['apply_edate'], 0, 10) .' '. substr($data['apply_edate'], 11, 8);
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
                $exhibition->tel = str_replace("-", "", $data['tel']);
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
                if (!empty($data['detail_html'])) :
                $exhibition->detail_html = $data['detail_html'];
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
                $exhibition->is_event = $data['is_event'];
                if (!empty($data['event_member'])) {
                    $exhibition->event_member = $data['event_member'];
                } 
                $exhibition->is_vod = $data['is_vod'];
                $exhibition->live_tab = $data['live_tab'];
                $exhibition->vod_tab = $data['vod_tab'];

                if ($result = $this->Exhibition->save($exhibition)) {
                    
                    if (!empty($data['group_name'])) {
                        $ExhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup');
                        $count = count($data['group_name']);

                        for ($i = 0; $i < $count; $i++) {
                            $exhibitionGroup = $ExhibitionGroup->newEmptyEntity();
                            $exhibitionGroup->exhibition_id = $result->id;
                            $exhibitionGroup->name = $data['group_name'][$i];
                            $exhibitionGroup->people = $data['group_people'][$i];
                            $string_amount = explode(',', $data['group_amount'][$i]);
                            $int_amount = '';
                            foreach ($string_amount as $amount) :
                                $int_amount .= $amount;
                            endforeach;
                            $exhibitionGroup->amount = (int)$int_amount;
        
                            
                            if (!$ExhibitionGroup->save($exhibitionGroup)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }

                    //?????? ??????
                    if (!empty($data['text'])) {
                        $ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey');
                        $count = count($data['text']);
                        $k = 0;
                        for ($i = 0; $i < $count; $i++) {
                            $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                            $exhibitionSurvey->exhibition_id = $result->id;
                            $exhibitionSurvey->text = $data['text'][$i];
                            $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                            $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                            $exhibitionSurvey->is_required = $data['is_required'][$i];
                            if ($data['is_multiple'][$i] == 'N') {
                                $exhibitionSurvey->is_multiple = 'N';
                            } else {
                                $exhibitionSurvey->is_multiple = 'Y';
                            }

                            if (!$surveyResult = $ExhibitionSurvey->save($exhibitionSurvey)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }

                            if ($surveyResult->is_multiple != 'N') {
                                $match = 0;
                                for ($k; $match < 1; $k++) {
                                    
                                    if (isset($data['child_text_' . $k])) {
                                        $childCount = count($data['child_text_' . $k]);
                                    
                                        for ($j = 0; $j < $childCount; $j++) {
                                            $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                            $exhibitionSurvey->exhibition_id = $surveyResult->exhibition_id;
                                            $exhibitionSurvey->text = $data['child_text_' . $k][$j];
                                            $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                            $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                            $exhibitionSurvey->is_required = $surveyResult->is_required;
                                            $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                            $exhibitionSurvey->parent_id = $surveyResult->id;
    
                                            if (!$ExhibitionSurvey->save($exhibitionSurvey)) {
                                                $connection->rollback(); 
                                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                                return $response;
                                            }
                                        }
                                        $match++;
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
                $exhibition = $this->Exhibition->get($id);
                $exhibition->image_path = 'img';
                $exhibition->image_name = 'img-no3.png';

                if ($this->Exhibition->save($exhibition)) {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    return $response;
                } else {
                    $connection->rollback(); 
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    return $response;
                }     
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
                
                //?????? ?????? ?????????
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
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => '????????? ??????????????? ??????????????????.',]));
                    return $response;
                }
            
            } else {
                
                $data = $this->request->getData();
                
                $exhibition->title = $data['title'];
                $exhibition->description = $data['description'];
                $exhibition->category = $data['category'];
                $exhibition->type = $data['type'];
                if (!empty($data['apply_sdate'])) : 
                $exhibition->apply_sdate = substr($data['apply_sdate'], 0, 10) .' '. substr($data['apply_sdate'], 11, 8);
                endif;
                if (!empty($data['apply_edate'])) :
                $exhibition->apply_edate = substr($data['apply_edate'], 0, 10) .' '. substr($data['apply_edate'], 11, 8);
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
                $exhibition->private = $data['private'];
                $exhibition->auto_approval = $data['auto_approval'];
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
                else :
                    $exhibition->require_name = 0;
                endif;
                if (!empty($data['require_email'])) :
                    $exhibition->require_email = $data['require_email'];
                else :
                    $exhibition->require_email = 0;
                endif;
                if (!empty($data['require_tel'])) :
                    $exhibition->require_tel = $data['require_tel'];
                else :
                    $exhibition->require_tel = 0;
                endif;
                if (!empty($data['require_age'])) :
                    $exhibition->require_age = $data['require_age'];
                else :
                    $exhibition->require_age = 0;
                endif;
                if (!empty($data['require_group'])) :
                    $exhibition->require_group = $data['require_group'];
                else :
                    $exhibition->require_group = 0;
                endif;
                if (!empty($data['require_sex'])) :
                    $exhibition->require_sex = $data['require_sex'];
                else :
                    $exhibition->require_sex = 0;
                endif;
                $exhibition->require_cert = $data['require_cert'];
                // if (!empty($data['detail_html'])) :
                $exhibition->detail_html = htmlspecialchars_decode($data['detail_html']);
                // endif;
                // $exhibition->email_notice = $data['email_notice'];
                $exhibition->additional = $data['additional'];
                if (!empty($data['status'])) :
                $exhibition->status = $data['status'];
                endif;
                $exhibition->is_event = $data['is_event'];
                if (!empty($data['event_member'])) {
                    $exhibition->event_member = $data['event_member'];
                }
                $exhibition->is_vod = $data['is_vod'];
                $exhibition->live_tab = $data['live_tab'];
                $exhibition->vod_tab = $data['vod_tab'];

                if ($this->Exhibition->save($exhibition)) {
                    $ExhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup');
                    
                    if (!empty($data['group_name'])) {    
                        $count = count($data['group_id']);

                        for ($i = 0; $i < $count; $i ++) {
                            
                            if ($data['group_id'][$i] != 0) {
                                $exhibitionGroup = $ExhibitionGroup->get($data['group_id'][$i]);
                                $exhibitionGroup->name = $data['group_name'][$i];
                                $exhibitionGroup->people = $data['group_people'][$i];
                                $string_amount = explode(',', $data['group_amount'][$i]);
                                $int_amount = '';
                                foreach ($string_amount as $amount) :
                                    $int_amount .= $amount;
                                endforeach;
                                $exhibitionGroup->amount = (int)$int_amount;
                            
                            } else {
                                $exhibitionGroup = $ExhibitionGroup->newEmptyEntity();
                                $exhibitionGroup->exhibition_id = $id;
                                $exhibitionGroup->name = $data['group_name'][$i];
                                $exhibitionGroup->people = $data['group_people'][$i];
                                $string_amount = explode(',', $data['group_amount'][$i]);
                                $int_amount = '';
                                foreach ($string_amount as $amount) :
                                    $int_amount .= $amount;
                                endforeach;
                                $exhibitionGroup->amount = (int)$int_amount;
                            }
                            
                            
                            if (!$ExhibitionGroup->save($exhibitionGroup)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                        }
                    }
                    
                    if (!empty($data['group_del'])) {
                        $ExhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup');
                        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
                        $count = count($data['group_del']);

                        for ($i = 0; $i < $count; $i ++) {
                            $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_group_id' => $data['group_del'][$i], 'status IS NOT' => 8])->toArray();
                            
                            if (!empty($exhibitionUsers)) {
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'exist']));
                                return $response;
                            }

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
                        $k = 0;
                        for ($i = 0; $i < $count; $i++) {
                            
                            if ($data['survey_id'][$i] != 0) {
                                $exhibitionSurvey = $ExhibitionSurvey->get($data['survey_id'][$i]);
                                $exhibitionSurvey->text = $data['text'][$i];
                                $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                                $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                                $exhibitionSurvey->is_required = $data['is_required'][$i];
                                if ($data['is_multiple'][$i] == 'N') {
                                    $exhibitionSurvey->is_multiple = 'N';
                                } else {
                                    $exhibitionSurvey->is_multiple = 'Y';
                                }
                            
                            } else {
                                $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                $exhibitionSurvey->exhibition_id = $id;
                                $exhibitionSurvey->text = $data['text'][$i];
                                $exhibitionSurvey->survey_type = $data['survey_type'][$i];
                                $exhibitionSurvey->is_duplicate = $data['is_duplicate'][$i];
                                $exhibitionSurvey->is_required = $data['is_required'][$i];
                                if ($data['is_multiple'][$i] == 'N') {
                                    $exhibitionSurvey->is_multiple = 'N';
                                } else {
                                    $exhibitionSurvey->is_multiple = 'Y';
                                }
                            }
                            
                            if (!$surveyResult = $ExhibitionSurvey->save($exhibitionSurvey)) {
                                $connection->rollback(); 
                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                return $response;
                            }
                            
                            if ($surveyResult->is_multiple != 'N') {
                                $match = 0;
                                for ($k; $match < 1; $k++) {
                                    
                                    if (isset($data['child_text_' . $k])) {

                                        $childCount = count($data['child_text_' . $k]);
                                    
                                        for ($j = 0; $j < $childCount; $j++) {
                                            
                                            if ($data['child_survey_id_' . $k][$j] != 0) {
                                                $exhibitionSurvey = $ExhibitionSurvey->get($data['child_survey_id_' . $k][$j]);
                                                $exhibitionSurvey->text = $data['child_text_' . $k][$j];
                                                $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                                $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                                $exhibitionSurvey->is_required = $surveyResult->is_required;
                                                $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                            
                                            } else {
                                                $exhibitionSurvey = $ExhibitionSurvey->newEmptyEntity();
                                                $exhibitionSurvey->exhibition_id = $surveyResult->exhibition_id;
                                                $exhibitionSurvey->text = $data['child_text_' . $k][$j];
                                                $exhibitionSurvey->survey_type = $surveyResult->survey_type;
                                                $exhibitionSurvey->is_duplicate = $surveyResult->is_duplicate;
                                                $exhibitionSurvey->is_required = $surveyResult->is_required;
                                                $exhibitionSurvey->is_multiple = $surveyResult->is_multiple;
                                                $exhibitionSurvey->parent_id = $surveyResult->id;
                                            }
    
                                            if (!$ExhibitionSurvey->save($exhibitionSurvey)) {
                                                $connection->rollback(); 
                                                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                                                return $response;
                                            }
                                        }
                                        $match++;
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

                    // if (!empty($data['child_survey_del'])) {
                    //     $count = count($data['child_survey_del']);

                    //     for ($i = 0; $i < $count; $i ++) {

                    //         if ($data['child_survey_del'][$i] != 0) {
                    //             $exhibitionSurvey = $ExhibitionSurvey->get($data['child_survey_del'][$i]);

                    //             if (!$ExhibitionSurvey->delete($exhibitionSurvey)) {
                    //                 $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    //                 return $response;
                    //             }
                    //         }
                    //     }
                    // }
                    $connection->commit();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'id' => $id]));
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
        $exhibitionStream = $this->getTableLocator()->get('ExhibitionStream')->find('all')->where(['exhibition_id' => $id])->toArray();
        $live_duration = 0;
        if (!empty($exhibitionStream)) {
            $live_duration = $exhibitionStream[0]['live_duration'];
        }
        $this->set(compact('id', 'exhibition', 'users', 'categories', 'types', 'exhibitionGroups', 'exhibitionSurveys', 'live_duration'));
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
        $this->request->allowMethod('delete');
        $exhibition = $this->Exhibition->get($id);
        $exhibition->status = 8;
        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id, 'status IS NOT' => 8])->toArray();
        $exhibitionStream = $this->getTableLocator()->get('ExhibitionStream')->find('all')->where(['exhibition_id' => $id])->toArray();

        require_once(ROOT . "/iamport-rest-client-php/src/iamport.php");            
        $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));

        if (!empty($exhibitionUsers)) {
            
            foreach($exhibitionUsers as $exhibitionUser) {
                $user = $ExhibitionUsers->get($exhibitionUser['id']);
                $user->status = 8;
                $ExhibitionUsers->save($user);

                if ($exhibitionUser['pay_id'] != '') {
                    $Pay = $this->getTableLocator()->get('Pay');
                    $pay = $Pay->get($exhibitionUser['pay_id']);
                    $now_day = date('Y-m-d', time()+32400);
                    
                    if ($pay->pay_method = 'trans' && date('Y-m-d', strtotime($pay->created->i18nFormat('yyyyMMddHHmmss'))) != $now_day) {
                        $pay->status = 4;
                        if ($Pay->save($pay)) {
                            $user_name = $exhibitionUser['users_name'];
                                
                            $mailer = new Mailer();
                            $mailer->setTransport('mailjet');
                            $mailer->setEmailFormat('html')
                                        ->setTo($exhibitionUser['users_email'])
                                        ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                        ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                            $mailer->setViewVars(['refund' => '???????????? ?????? ??? ?????? ???????????????.']);
                            $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                            
                            $mailer->deliver();
                        }

                    } else {
                        $result = $iamport->cancel(array(
                            'imp_uid'		=> $pay->imp_uid, 		
                            'merchant_uid'	=> $pay->merchant_uid, 	
                            'amount' 		=> 0,				
                            'reason'		=> '?????? ????????? ??????',			
                        ));
    
                        if ($result->success) {
                    
                            $payment_data = $result->data;
                            $now = date('Y-m-d H:i:s', time()+32400);
            
                            $pay->cancel_reason = '?????? ????????? ??????';
                            $pay->cancel_amount = $payment_data->cancel_amount;
                            $pay->cancel_date = $now;
                            $pay->status = 8;
                            
                            if ($Pay->save($pay)) {
                                
                                $user_name = $exhibitionUser['users_name'];
                                
                                $mailer = new Mailer();
                                $mailer->setTransport('mailjet');
                                $mailer->setEmailFormat('html')
                                            ->setTo($exhibitionUser['users_email'])
                                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                            ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                                $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                                
                                $mailer->deliver();
                            } 
                        }
                    }          
        
                } else {
                    $user_name = $exhibitionUser['users_name'];
                    
                    $mailer = new Mailer();
                    $mailer->setTransport('mailjet');
                    $mailer->setEmailFormat('html')
                                ->setTo($exhibitionUser['users_email'])
                                ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                    $mailer->setViewVars(['refund' => 0]);
                    $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                    
                    $mailer->deliver();
                }
            }
        }

        if (!empty($exhibitionStream)) {
            
            if ($exhibitionStream[0]['pay_id'] != '') {
                $Pay = $this->getTableLocator()->get('Pay');
                $pay = $Pay->get($exhibitionStream[0]['pay_id']);
                
                $result = $iamport->cancel(array(
                    'imp_uid'		=> $pay->imp_uid, 		
                    'merchant_uid'	=> $pay->merchant_uid, 	
                    'amount' 		=> 0,				
                    'reason'		=> '?????? ??????',			
                ));

                if ($result->success) {
            
                    $payment_data = $result->data;
                    $now = date('Y-m-d H:i:s', time()+32400);
    
                    $pay->cancel_reason = '?????? ??????';
                    $pay->cancel_amount = $payment_data->cancel_amount;
                    $pay->cancel_date = $now;
                    
                    $Pay->save($pay);
                }
            }
        }
        
        if ($this->Exhibition->save($exhibition)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));        
            return $response;    
        } else {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));     
            return $response;       
        }
    }

    public function managerPerson($id = null)
    {
        $this->paginate = ['limit' => 10];

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status IS NOT' => 8]))->toArray();

        $users_table = TableRegistry::get('Users');
        $users = [];
        for ($i=0; $i<count($exhibition_users); $i++) {
            if ($exhibition_users[$i]->users_id != null) {
                $users_data = $users_table->find()->where(['id' => $exhibition_users[$i]->users_id])->toArray();
                $users[$i]['id'] = $users_data[0]->id;
                if ($users_data[0]->birthday != null) {
                    $users[$i]['age'] = date('Y') - (int)$users_data[0]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $users[$i]['age'] = '?????? ??????';
                }
                $users[$i]['company'] = $users_data[0]->company;
            } else {
                $users[$i]['id'] = 0;
            }
        }
        
        $exhibitionSurvey_table = TableRegistry::get('ExhibitionSurvey');
        $exhibitionSurvey = $exhibitionSurvey_table->find('all', ['contain' => ['ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer']]);
        $exhibitionSurveys = $exhibitionSurvey->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.parent_id', 'ExhibitionSurvey.text', 'ExhibitionSurvey.is_multiple', 'ExhibitionSurveyUsersAnswer.text', 'ExhibitionSurvey.survey_type', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.text')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer', function ($q) {
                return $q->where(['ExhibitionSurveyUsersAnswer.text' => 'Y']);
            })
            ->group('ExhibitionSurvey.id')
            ->where(['exhibition_id' => $id])
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
                $j=0;
            } else {
                if ($exhibitionSurvey['parent_id'] == $parent_id) {
                    $beforeChildData[$parent_id][$j] = $exhibitionSurvey;
                    $j++;
                }
            }
        }
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'exhibition_users', 'users', 'beforeParentData', 'beforeChildData', 'exhibition'));
    }

    public function vodData($id = null)
    {
        $this->paginate = ['limit' => 10];

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_users = $this->paginate($exhibition_users_table->find('all', array('contain' => array('Exhibition', 'ExhibitionGroup', 'Pay', 'ExhibitionVodViewer')))->where(['ExhibitionUsers.exhibition_id' => $id, 'ExhibitionUsers.status IS NOT' => 8]))->toArray();

        $users_table = TableRegistry::get('Users');
        $users = [];
        for ($i=0; $i<count($exhibition_users); $i++) {
            if ($exhibition_users[$i]->users_id != null) {
                $users_data = $users_table->find()->where(['id' => $exhibition_users[$i]->users_id])->toArray();
                $users[$i]['id'] = $users_data[0]->id;
                if ($users_data[0]->birthday != null) {
                    $users[$i]['age'] = date('Y') - (int)$users_data[0]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $users[$i]['age'] = '?????? ??????';
                }
                $users[$i]['company'] = $users_data[0]->company;
            } else {
                $users[$i]['id'] = 0;
            }
        }

        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVods = $ExhibitionVod->find('all')->where(['ExhibitionVod.exhibition_id' => $id, 'ExhibitionVod.parent_id IS NOT' => null])->order(['ParentExhibitionVod.idx' => 'ASC', 'ExhibitionVod.idx' => 'ASC']);
        $exhibitionVods->contain([
            'ExhibitionVodViewer',
            'ParentExhibitionVod',
        ])->toArray();

        $total_duration = 0;
        foreach ($exhibitionVods as $vod) {
            $total_duration = $total_duration + $vod['duration'];
        }

        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'exhibition_users', 'users', 'exhibition', 'exhibitionVods', 'total_duration'));
    }


    public function vodWatching($id = null) {
        $this->paginate = ['limit' => 10];

        $exhibition_stream_table = TableRegistry::get('ExhibitionStream');
        $exhibition_stream = $this->paginate($exhibition_stream_table->find()->where(['exhibition_id' => $id]))->toArray();

        $exhibition_vod_table = TableRegistry::get('ExhibitionVod');
        // $exhibition_vod_parent = $this->paginate($exhibition_vod_table->find()->where(['exhibition_id' => $id, 'parent_id is' => null]))->toArray();
        // $exhibition_vod_child = $this->paginate($exhibition_vod_table->find()->where(['exhibition_id' => $id, 'parent_id is not' => null]))->toArray();
        
        $this->set(compact('id'));
    }

    public function exhibitionUsersStatus()
    {
        $id = $this->request->getData('id');
        $exhibition_id = $this->request->getData('exhibition_id');
        $to = $this->request->getData('users_email');
        $pay_id = $this->request->getData('pay_id');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {

            if (!$connection->delete('exhibition_survey_users_answer', ['users_id' => $id])) {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
            
            if ($pay_id != '') {
                $Pay = $this->getTableLocator()->get('Pay');
                $pay = $Pay->get($pay_id);
                
                require_once(ROOT . "/iamport-rest-client-php/src/iamport.php");
                
                $iamport = new Iamport(getEnv('IAMPORT_API_KEY'), getEnv('IAMPORT_API_SECRET'));
    
                $result = $iamport->cancel(array(
                    'imp_uid'		=> $pay->imp_uid, 		
                    'merchant_uid'	=> $pay->merchant_uid, 	
                    'amount' 		=> 0,				
                    'reason'		=> '?????? ????????? ??????',			
                ));
    
                if ($result->success) {
                
                    $payment_data = $result->data;
                    $now = date('Y-m-d H:i:s', time()+32400);
                    
    
                    $pay->cancel_reason = '?????? ????????? ??????';
                    $pay->cancel_amount = $payment_data->cancel_amount;
                    $pay->cancel_date = $now->i18nFormat('yyyy-MM-dd HH:mm:ss');
                    
                    if ($Pay->save($pay)) {
                        $connection->commit();
    
                        $mailer = new Mailer();
                        $mailer->setTransport('mailjet');
    
                        $exhibition = $this->Exhibition->get($exhibition_id);
                        $user_name = $this->request->getData('user_name');
                        
                        $mailer->setEmailFormat('html')
                                    ->setTo($to)
                                    ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                                    ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                        $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                        
                        $mailer->deliver();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    } else {
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                    }
                } else {
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                }
            } else {
                $mailer = new Mailer();
                $mailer->setTransport('mailjet');

                $exhibition = $this->Exhibition->get($exhibition_id);
                $user_name = $this->request->getData('users_name');  
                
                $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                $mailer->setViewVars(['refund' => 0]);
                $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                
                $mailer->deliver();
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }

    public function exhibitionUsersStatusTrans()
    {
        $id = $this->request->getData('id');
        $exhibition_id = $this->request->getData('exhibition_id');
        $to = $this->request->getData('users_email');
        $pay_id = $this->request->getData('pay_id');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);

        if($connection->update('exhibition_users', ['status' => '8'], ['id' => $id])) {

            if (!$connection->delete('exhibition_survey_users_answer', ['users_id' => $id])) {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
                return $response;
            }
            
            if ($connection->update('pay', ['status' => 4], ['id' => $pay_id])) {

                $mailer = new Mailer();
                $mailer->setTransport('mailjet');

                $exhibition = $this->Exhibition->get($exhibition_id);
                $user_name = $this->request->getData('user_name');
                
                $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - ???????????? ?????? ???????????????.')
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
                $mailer->setViewVars(['refund' => '?????????????????? ?????? ??? ?????? ?????? ???????????????.']);
                $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
                
                $mailer->deliver();

                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }
        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
        }

        return $response;
    }


    public function exhibitionUsersApproval()
    {
        $id = $this->request->getData('id');
        $exhibition_id = $this->request->getData('exhibition_id');
        $status = $this->request->getData('status');
        $to = $this->request->getData('email');
        $name = $this->request->getData('name');
        $group_id = $this->request->getData('group_id');

        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition_users_table = TableRegistry::get('ExhibitionUsers');
        $exhibition_user = $exhibition_users_table->get($id);
        
        if($connection->update('exhibition_users', ['status' => $status], ['id' => $id])) {
            $connection->commit();

            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $Exhibition = $this->getTableLocator()->get('Exhibition');
            $exhibition = $Exhibition->get($exhibition_id);
            
            if ($status == 4) {
                $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - ???????????? ?????? ???????????????.')
                            ->viewBuilder()
                            ->setTemplate('webinar_apply_confirmed');
            } elseif ($status == 2) {
                $mailer->setEmailFormat('html')
                            ->setTo($to)
                            ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => 'EXON'])
                            ->setSubject('Exon - ???????????? ?????? ???????????????.')
                            ->viewBuilder()
                            ->setTemplate('webinar_apply');
            }
            
            $mailer->setViewVars(['front_url' => FRONT_URL]);
            $mailer->setViewVars(['user_name' => $name]);
            $mailer->setViewVars(['title' => $exhibition->title]);
            $mailer->setViewVars(['apply_sdate' => $exhibition->apply_sdate]);
            $mailer->setViewVars(['apply_edate' => $exhibition->apply_edate]);
            $mailer->setViewVars(['sdate' => $exhibition->sdate]);
            $mailer->setViewVars(['edate' => $exhibition->edate]);
            $mailer->setViewVars(['name' => $exhibition->name]);
            $mailer->setViewVars(['tel' => $exhibition->tel]);
            $mailer->setViewVars(['email' => $exhibition->email]);
            if ($group_id != null) {
                $Group = $this->getTableLocator()->get('ExhibitionGroup');
                $group = $Group->get($group_id);
                
                $mailer->setViewVars(['group' => $group->name]);
            } else {
                $mailer->setViewVars(['group' => '????????? ????????? ????????????.']);
            }
            $mailer->setViewVars(['now' => date('Y-m-d H:i:s', time()+32400)]);
            $mailer->deliver();

            $response = $this->response->withType('json')->withStringBody(json_encode(['test' => 'success']));
        } else {
            $connection->rollback();
            $response = $this->response->withType('json')->withStringBody(json_encode(['test' => 'fail']));
        }
        return $response;
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

    public function sendEmailToParticipant($id = null)
    {
        $session = $this->request->getSession();
        $text = $session->consume('text');
        $name = $session->consume('name');
        $lists = $session->consume('data');

        if (!empty($lists)) {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();

        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('post')) {
            $mailer = new Mailer();
            $mailer->setTransport('mailjet');

            $users_email = $this->request->getData('users_email');
            $to = explode(",", $users_email);
            $contents = $this->request->getData('email_content');

            $mailer->setEmailFormat('html')
                        ->setTo($to)
                        ->setFrom([getEnv('EXON_EMAIL_ADDRESS') => $this->request->getData('name')])
                        ->setSubject('Exon - ?????? ???????????????.')
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
        $this->set(compact('id', 'exhibitionUsers', 'listExhibitionUsers', 'exhibitionGroups', 'text', 'name', 'lists'));
    }

    public function sendSmsToParticipant($id = null)
    {
        require_once(ROOT . "/solapi-php/lib/message.php");

        $session = $this->request->getSession();
        $text = $session->consume('text');
        $lists = $session->consume('data');
        
        if (!empty($lists)) {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['id IN' => $lists])->toArray();

        } else {
            $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find()->select('exhibition_id')->where(['exhibition_id' => $id])->toArray();
        }
        
        if ($this->request->is('post')) {
            
            $users_hp = $this->request->getData('users_hp');
            $to = explode(",", $users_hp);

            $messages = [
                [
                'to' => $to,
                'from' => getEnv('EXON_PHONE_NUMBER'),
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
        $this->set(compact('id', 'exhibitionUsers', 'listExhibitionUsers', 'exhibitionGroups', 'text', 'lists'));
    }

    public function participantList($id = null)
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData('data');
            $text = $this->request->getData('text');
            $name = $this->request->getData('name');
            $session = $this->request->getSession();
            $session->write('text', $text);
            $session->write('data', $data);
            $session->write('name', $name);
            
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
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

    public function sortByGroup($id = null, $group = 0) 
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

        //???????????? ?????????

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
        
        //???????????? ?????????

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
            if (!empty($data)) {
                $count = count($data);

                //?????? ?????? ??????
                $spreadsheet = new Spreadsheet();

                //Specify the properties for this document
                $spreadsheet->getProperties()
                    ->setTitle('?????? ?????????')
                    ->setCreator('EXON.live')
                    ->setLastModifiedBy('EXON.live');

                for ($i = 0; $i < ($count-1); $i++) {
                    $spreadsheet->createSheet();
                }

                for ($i = 0; $i < $count; $i++) {
                    $spreadsheet->setActiveSheetIndex($i)
                    ->setTitle('??????' . ($i+1))
                    ->setCellValue('A1', '');

                    // $spreadsheet->getActiveSheet($i)
                    // ->setCellValue('B1', '??????')
                    // ->setCellValue('C1', '?????????')
                    // ->setCellValue('D1', '??????' . ($i+1));
                }

                $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
                $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id, 'status IS NOT' => 8])->toArray();
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
                    ])->where(['users_id' => $exhibitionUsers[$i]['id']])->toArray();
                    
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
                        'users_id' => $exhibitionUsers[$i]['id'],
                        'answered' => $answered 
                    ];
                }
                
                for ($i = 0; $i < $count; $i++) {
                    $exhibitionSurvey = $ExhibitionSurvey->find('all')->where(['id' => $data[$i]])->toArray();
                    $question = $exhibitionSurvey[0]['text'];

                    $spreadsheet->setActiveSheetIndex($i)
                    // ->setTitle('??????')
                    ->setCellValue('A1', '');

                    // $spreadsheet->setActiveSheetIndex($i)
                    // ->getColumnDimension('C')->setWidth(30);	

                    // $spreadsheet->setActiveSheetIndex($i)
                    // ->getColumnDimension('D')->setWidth(30);

                    // $spreadsheet->setActiveSheetIndex($i)
                    // ->getColumnDimension('E')->setWidth(30);

                    // $spreadsheet->setActiveSheetIndex($i)
                    // ->getColumnDimension('F')->setWidth(30);

                    $spreadsheet->getActiveSheet($i)
                    ->setCellValue('B1', '??????')
                    ->setCellValue('C1', '?????????')
                    ->setCellValue('D1', '????????????')
                    ->setCellValue('E1', '??????         ')
                    ->setCellValue('F1', '??????         ')
                    ->setCellValue('G1', $question);

                    for ($j = 0; $j < $rowCount; $j++) {
                            $spreadsheet->getActiveSheet($i)
                            ->setCellValue('A' . ($j+2), ($j+1))
                            ->setCellValue('B' . ($j+2), $exhibitionUsers[$j]['users_name'])
                            ->setCellValue('C' . ($j+2), $exhibitionUsers[$j]['users_email'])
                            ->setCellValue('D' . ($j+2), $exhibitionUsers[$j]['users_hp'])
                            ->setCellValue('E' . ($j+2), $exhibitionUsers[$j]['company'])
                            ->setCellValue('F' . ($j+2), $exhibitionUsers[$j]['title']);       
                    }
                    for ($j = 0; $j < $rowCount; $j++) {
                        
                        if ($answerData[$j]['answered'][0] == '') {
                            $spreadsheet->getActiveSheet($i)
                            ->setCellValue('G' . ($j+2), '');
                        
                        } else {  
                            $text =  $answerData[$j]['answered'][$i];
                            $lists = explode(" ", $text);
                            
                            $spreadsheet->getActiveSheet($i)
                            ->setCellValue('G' . ($j+2), $text);
                        }
                    }

                    $spreadsheet->getActiveSheet($i)->getColumnDimension('A')->setAutoSize(true);
                    $spreadsheet->getActiveSheet($i)->getColumnDimension('C')->setAutoSize(true);
                    $spreadsheet->getActiveSheet($i)->getColumnDimension('D')->setAutoSize(true);
                    $spreadsheet->getActiveSheet($i)->getColumnDimension('E')->setAutoSize(true);
                    $spreadsheet->getActiveSheet($i)->getColumnDimension('F')->setAutoSize(true);
                    $spreadsheet->getActiveSheet($i)->getColumnDimension('G')->setAutoSize(true);

                    $spreadsheet->getActiveSheet($i)->getStyle('E')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet($i)->getStyle('F')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet($i)->getStyle('G')->getAlignment()->setWrapText(true);
                    $spreadsheet->getActiveSheet($i)->getStyle('A:G')->getAlignment()->setHorizontal('left');
                }
                
                $path = 'download' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
            
                if (!file_exists(WWW_ROOT . $path)) {
                    $oldMask = umask(0);
                    mkdir(WWW_ROOT . $path, 0777, true);
                    chmod(WWW_ROOT . $path, 0777);
                    umask($oldMask);
                }

                $exhibition = $this->Exhibition->get($id);
                $fileName = $exhibition->title . "_survey_data." . "xlsx";
                $destination = WWW_ROOT . $path . DS . $fileName;

                $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
                $writer->save($destination);
                
                //?????? ?????? ????????????
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
        }
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('beforeParentData', 'beforeChildData', 'normalParentData', 'normalChildData', 'id', 'exhibition'));
    }

    public function exhibitionStatisticsApply($id = null)
    {
        //????????? ???
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->toArray();
    
        //??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status IN' => [1, 2, 4]])->toArray();
        
        //?????????
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = null;
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status != 8) {
                if ($exhibition[0]->users[$i]->birthday != null) {
                    $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $ages[$i] = 0;
                }
            }
        }
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'applyRates', 'genderRates', 'ages', 'exhibition'));
    }

    public function exhibitionStatisticsParticipant($id = null)
    {
        //?????? ????????? ???
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //?????????
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4) {
                if ($exhibition[0]->users[$i]->birthday != null) {
                    $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $ages[$i] = 0;
                }
            }
        }

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup', 'exhibition'));
    }

    public function exhibitionStatisticsParticipantByGroup($id = null, $group = null)
    {
        //?????? ?????? ????????? ???
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $applyRates = $exhibitionUsers->select(['status', 'count' => $exhibitionUsers->func()->count('status')])->group('status')->where(['status IN' => [2, 4]])->toArray();

        //?????? ????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['status' => 4])->toArray();
        
        //?????? ?????????
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->status == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                if ($exhibition[0]->users[$i]->birthday != null) {
                    $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $ages[$i] = 0;
                }
            }
        }
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'group', 'applyRates', 'genderRates', 'ages', 'exhibitionGroup', 'exhibition'));
    }

    public function exhibitionStatisticsStream($id = null) 
    {
        //????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //?????? ?????? ??????
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

        //????????? ?????? ???
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 || $exhibition[0]->users[$i]->_joinData->attend == 4) {
                if ($exhibition[0]->users[$i]->birthday != null) {
                    $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $ages[$i] = 0;
                }
            }
        }

        //????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();

        $this->set(compact('id', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates', 'exhibition'));
    }

    public function exhibitionStatisticsStreamByGroup($id = null, $group = null)
    {
        //????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $participant = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4])->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $attended = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('id')])->where(['exhibition_group_id' => $group, 'status' => 4, 'attend IN' => [2, 4]])->toArray();

        $participantData = [
            'participant' => $participant[0]->count,
            'attended' => $attended[0]->count
        ];

        //?????? ?????? ??????
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
        
        //????????? ?????? ???
        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['id' => $id])->toArray();
        $count = count($exhibition[0]->users);
        $ages[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibition[0]->users[$i]->_joinData->attend == 2 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group || $exhibition[0]->users[$i]->_joinData->attend == 4 && $exhibition[0]->users[$i]->_joinData->exhibition_group_id == $group) {
                if ($exhibition[0]->users[$i]->birthday != null) {
                    $ages[$i] = date('Y')-(int)$exhibition[0]->users[$i]->birthday->i18nFormat('yyyy') + 1;
                } else {
                    $ages[$i] = 0;
                }
            }
        }

        //????????? ??????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $genderRates = $exhibitionUsers->select(['users_sex', 'count' => $exhibitionUsers->func()->count('users_sex')])
            ->group('users_sex')->where(['attend IN' => [2, 4]])->toArray();
        
        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        
        $this->set(compact('id', 'group', 'exhibitionGroup', 'participantData', 'answeredData', 'ages', 'genderRates', 'exhibition'));
    }

    public function exhibitionStatisticsExtra($id = null) 
    {
        //?????? ??? ?????????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id])->toArray();
        $count = count($exhibitionUsers);
        $ids[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibitionUsers[$i]->status == 2 || $exhibitionUsers[$i]->status == 4) {
                $ids[$i] = $exhibitionUsers[$i]->id;
            }
        }

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')
            ->where(['exhibition_id' => $id, 'ExhibitionSurveyUsersAnswer.parent_id IS' => null, 'ExhibitionSurveyUsersAnswer.users_id IN' => $ids]);
        $answerRates = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.text', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.id')])
            ->where(['ExhibitionSurveyUsersAnswer.text IS NOT' => ''])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer')
            ->group('ExhibitionSurvey.id')
            ->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id]);
        $applyRates = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('status')])->where(['status IN' => [2, 4]])->toArray();

        //????????? or ?????????

        //????????? ?????? ??????
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

        $exhibition = $this->Exhibition->find('all', ['contain' => 'Users'])->where(['users_id' => $exhibition[0]->users_id])->toArray();
        $count = count($exhibition);    
        $previousExhibition[] = '';
        if ($count != 0) {
            for ($i = 0; $i < $count; $i++ ) {
                if ((int)$exhibition[$i]->created->i18nFormat('yyyyMMddHHmmss') < (int)$currentExhibition[0]->created->i18nFormat('yyyyMMddHHmmss')) {
                    $previousExhibition[$i] = $exhibition[$i];
                }
            }
        }
        
        if (count($previousExhibition) != 1) {
            $previousExhibitionParticipant[] = '';
            $countI = count($previousExhibition);
            $k = 0;
            for ($i = 1; $i < $countI; $i++) {
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
        
        //????????? ???
        // $totalParticipant = 0;
        // $count = count($currentExhibition[0]->users);
        // for ($i = 0; $i < $count; $i++) {
        //     if ($currentExhibition[0]->users[$i]->_joinData->status == 4)  {
        //         $totalParticipant++;
        //     }
        // }

        $totalParticipant = count($this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'status' => 4])->toArray());
        
        $participatedData = [
            'total' => $totalParticipant,
            'participated' => $participatedCount,
        ];

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'answerRates', 'applyRates', 'participatedData', 'exhibitionGroup', 'exhibition'));
    }

    public function exhibitionStatisticsExtraByGroup ($id = null, $group = null) {
        //?????? ??? ?????????
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id])->toArray();
        $count = count($exhibitionUsers);
        $ids[] = '';
        for ($i = 0; $i < $count; $i++) {
            if ($exhibitionUsers[$i]->status == 2 || $exhibitionUsers[$i]->status == 4 && $exhibitionUsers[$i]->exhibition_group_id == $group) {
                $ids[$i] = $exhibitionUsers[$i]->id;
            }
        }

        $exhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')
            ->where(['exhibition_id' => $id, 'ExhibitionSurveyUsersAnswer.parent_id IS' => null, 'ExhibitionSurveyUsersAnswer.users_id IN' => $ids]);
        $answerRates = $exhibitionSurvey
            ->select(['ExhibitionSurvey.id', 'ExhibitionSurvey.text', 'count' => $exhibitionSurvey->func()->count('ExhibitionSurveyUsersAnswer.id')])
            ->leftJoinWith('ExhibitionSurveyUsersAnswer')
            ->group('ExhibitionSurvey.id')
            ->toArray();
        
        $exhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'exhibition_group_id' => $group]);
        $applyRates = $exhibitionUsers->select(['count' => $exhibitionUsers->func()->count('status')])->where(['status IN' => [2, 4]])->toArray();

        //????????? or ?????????

        //????????? ?????? ??????
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
        
        if (count($previousExhibition) != 1) {
            $previousExhibitionParticipant[] = '';
            $countI = count($previousExhibition);
            $k = 0;
            for ($i = 1; $i < $countI; $i++) {
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
        
        //????????? ???
        // $totalParticipant = 0;
        // $count = count($currentExhibition[0]->users);
        // for ($i = 0; $i < $count; $i++) {
        //     if ($currentExhibition[0]->users[$i]->_joinData->status == 4 && $currentExhibition[0]->users[$i]->_joinData->exhibition_group_id == $group)  {
        //         $totalParticipant++;
        //     }
        // }

        $totalParticipant = count($this->getTableLocator()->get('ExhibitionUsers')->find('all')->where(['exhibition_id' => $id, 'status' => 4, 'exhibition_group_id' => $group])->toArray());
        
        $participatedData = [
            'total' => $totalParticipant,
            'participated' => $participatedCount,
        ];

        $exhibitionGroup = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id])->toArray();
        $exhibition = $this->Exhibition->get($id);
        $this->set(compact('id', 'group', 'answerRates', 'applyRates', 'participatedData', 'exhibitionGroup', 'exhibition'));
    }

    public function exhibitionStatisticsVod($id = null)
    {
        $exhibition = $this->getTableLocator()->get('Exhibition')->get($id);

        $vods = $this->getTableLocator()->get('ExhibitionVod')->find('all');
        $sum = $vods->where(['exhibition_id' => $id])->sumOf('viewer');
        $vod_count = $vods->where(['exhibition_id' => $id, 'parent_id is not' => NULL])->count('*');

        $ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod');
        $exhibitionVods = $ExhibitionVod->find('all', ['contain' => ['ExhibitionVodViewer', 'ParentExhibitionVod']])->where(['ExhibitionVod.exhibition_id' => $id, 'ExhibitionVod.parent_id IS NOT' => null])->order(['ParentExhibitionVod.idx' => 'ASC', 'ExhibitionVod.idx' => 'ASC'])->toArray();

        $total_duration = 0;
        foreach ($exhibitionVods as $exhibitionVod) {
            $total_duration = $total_duration + $exhibitionVod['duration'];
        }

        $ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers');
        $exhibitionUsers = $ExhibitionUsers->find('all')->where(['exhibition_id' => $id])->toArray();

        if ($this->request->is('post')) {
        
            $spreadsheet = new Spreadsheet();

            $spreadsheet->getProperties()
                ->setTitle('VOD ?????????')
                ->setCreator('EXON.live')
                ->setLastModifiedBy('EXON.live');

            $spreadsheet->setActiveSheetIndex(0)
                ->setTitle('VOD ?????????')
                ->setCellValue('A1', '');

            $spreadsheet->getActiveSheet(0)->getColumnDimension('A')->setWidth(15);
            
            $i = 2;
            foreach ($exhibitionUsers as $exhibitionUser) {
                $j = "B";
                $spreadsheet->getActiveSheet(0)->getColumnDimension($j)->setAutoSize(true);
                $spreadsheet->getActiveSheet(0)
                    ->setCellValue('A' . $i, $exhibitionUser['users_name']);

                $sum = 0;
                foreach ($exhibitionVods as $exhibitionVod) {
                    $watching_duration = 0;
                    $cal = 0;
            
                    foreach ($exhibitionVod->exhibition_vod_viewer as $viewer) {
                        if ($exhibitionUser['id'] == $viewer['exhibition_users_id']) {
                            $watching_duration = $viewer['watching_duration'];
                        }
                        $cal = round(($watching_duration / $viewer['vod_duration']) * 100, 0);
                    }
                    if ($cal >= 100) {
                        $sum = $sum + 100;
                        $cal = '????????????';
                    } else {
                        $sum = $sum + $cal;
                        $cal = $cal . "%";
                    }
                    $spreadsheet->getActiveSheet(0)
                        ->setCellValue($j . $i, $cal);
                    $j++;
                }
                $spreadsheet->getActiveSheet(0)
                        ->setCellValue($j . $i, round($sum / count($exhibitionVods), 0) . '%');
            
                $i++;
            }

            $k = "B";
            foreach ($exhibitionVods as $exhibitionVod) {
                $spreadsheet->getActiveSheet(0)->getColumnDimension($k)->setWidth(20);
                $spreadsheet->getActiveSheet(0)
                    ->setCellValue($k . '1', $exhibitionVod['title']);
                $k++;
            }

            $last_column = $spreadsheet->getActiveSheet(0)->getHighestColumn();
            $next_column = chr(ord($last_column));
            $spreadsheet->getActiveSheet(0)->getColumnDimension($next_column)->setWidth(20);
            $spreadsheet->getActiveSheet(0)
                    ->setCellValue($next_column . '1', '?????? ?????? ??????');

            $path = 'download' . DS . 'vod' . DS . date("Y") . DS . date("m");
    
            if (!file_exists(WWW_ROOT . $path)) {
                $oldMask = umask(0);
                mkdir(WWW_ROOT . $path, 0777, true);
                chmod(WWW_ROOT . $path, 0777);
                umask($oldMask);
            }

            $exhibition = $this->Exhibition->get($id);
            $fileName = $exhibition->title . "_vod_data." . "xlsx";
            $destination = WWW_ROOT . $path . DS . $fileName;

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx"); //Xls is also possible
            $writer->save($destination);
            
            //?????? ?????? ????????????
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

        $this->set(compact('id', 'exhibition', 'vods', 'sum', 'vod_count'));
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

    public function search($key = null)
    {
        $this->paginate = ['limit' => 20];

        $exhibitions = $this->paginate($this->Exhibition->find('all')->where(['status' => 1, 'title LIKE' => '%'.$key.'%', 'private' => 0])->order(['created' => 'DESC']))->toArray();
        $count = count($this->Exhibition->find('all')->where(['status' => 1, 'title LIKE' => '%'.$key.'%', 'private' => 0])->toArray());

        $CommonCategory = $this->getTableLocator()->get('CommonCategory');
        $commonCategory = $CommonCategory->find('all')->toArray();
        
        $this->set(compact('exhibitions', 'commonCategory', 'key', 'count'));
        
        if ($this->request->is('put')) {
            $action = $this->request->getData('action');
            $key = $this->request->getData('key');
            $category = $this->request->getData('category');
            $type = $this->request->getData('type');
            $cost = $this->request->getData('cost');

            if ($action == 'category') {
                $this->paginate = ['limit' => 20];
                $exhibitions = $this->paginate($this->Exhibition->find('all')
                    ->where([
                        'status' => 1, 
                        'title LIKE' => '%'.$key.'%', 
                        'category IN' => $category,
                        'type IN' => $type,
                        'cost IN' => $cost,
                        'private' => 0
                    ])
                    ->order(['created' => 'DESC']))->toArray();
                $count = count($this->Exhibition->find('all')->where([
                    'status' => 1, 
                    'title LIKE' => '%'.$key.'%', 
                    'category IN' => $category,
                    'type IN' => $type,
                    'cost IN' => $cost,
                    'private' => 0
                ])->toArray());

                $CommonCategory = $this->getTableLocator()->get('CommonCategory');
                $commonCategory = $CommonCategory->find('all')->toArray();

                $view = new \Cake\View\View($this->request, $this->response);                                
                $view->set(compact('exhibitions', 'commonCategory', 'key', 'count'));
                $contents = $view->element('search'); 

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $contents, 'commonCategory' => $commonCategory, 'count' => $count]));
                return $response;
            
            } else {
                $order = $this->request->getData('order');

                $this->paginate = ['limit' => 20];

                if ($order == "accuracy") :
                $exhibitions = $this->paginate($this->Exhibition->find('all')
                    ->where([
                        'status' => 1, 
                        'title LIKE' => '%'.$key.'%', 
                        'category IN' => $category,
                        'type IN' => $type,
                        'cost IN' => $cost,
                        'private' => 0
                    ])
                    ->order('(CASE WHEN title LIKE "'.$key.'" then 1 when title LIKE "'.$key.'%" then 2 when title LIKE "%'.$key.'" then 3 when title LIKE "%'.$key.'%" then 4 else 5 END)'))->toArray();
                
                else :
                    $exhibitions = $this->paginate($this->Exhibition->find('all')
                    ->where([
                        'status' => 1, 
                        'title LIKE' => '%'.$key.'%', 
                        'category IN' => $category,
                        'type IN' => $type,
                        'cost IN' => $cost,
                        'private' => 0
                    ])
                    ->order(['created' => 'DESC']))->toArray();
                endif;

                $count = count($this->Exhibition->find('all')->where([
                    'status' => 1, 
                    'title LIKE' => '%'.$key.'%', 
                    'category IN' => $category,
                    'type IN' => $type,
                    'cost IN' => $cost,
                    'private' => 0
                ])->toArray());

                $CommonCategory = $this->getTableLocator()->get('CommonCategory');
                $commonCategory = $CommonCategory->find('all')->toArray();

                $view = new \Cake\View\View($this->request, $this->response);                                
                $view->set(compact('exhibitions', 'commonCategory', 'key', 'count'));
                $contents = $view->element('search'); 

                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $contents, 'commonCategory' => $commonCategory, 'count' => $count]));
                return $response;
            }
        }
    }

    public function contestSearch ($key = null) 
    {
        $this->paginate = ['ExhibitionStream' => ['limit' => 12]];
        $exhibitions = $this->paginate($this->getTableLocator()->get('ExhibitionStream')->find()
            ->select([
                'Exhibition.id', 'Exhibition.title', 'Exhibition.image_path', 'Exhibition.image_name',
                'ExhibitionStream.live_started', 'ExhibitionStream.vod_index', 'ExhibitionStream.viewer', 'ExhibitionStream.watched', 'ExhibitionStream.liked', 'ExhibitionStream.is_upload'
            ])
            ->LeftJoinWith('Exhibition')
            ->where([
                'Exhibition.title LIKE' => '%'.$key.'%',
                'Exhibition.status IS NOT' => 8,
                'Exhibition.private' => 0,
                'Exhibition.is_event' => 1,
                'OR' => [['ExhibitionStream.live_started IS NOT' => '0000-00-00 00:00:00'], ['ExhibitionStream.is_upload' => 1, 'ExhibitionStream.vod_index' => 1]],
            ])
            ->order(['ExhibitionStream.live_started' => 'DESC', 'Exhibition.created' => 'DESC']))->toArray();

        $count = count($this->getTableLocator()->get('ExhibitionStream')->find()
        ->select([
            'Exhibition.id', 'Exhibition.title', 'Exhibition.image_path', 'Exhibition.image_name',
            'ExhibitionStream.live_started', 'ExhibitionStream.vod_index', 'ExhibitionStream.viewer', 'ExhibitionStream.watched', 'ExhibitionStream.liked', 'ExhibitionStream.is_upload'
        ])
        ->LeftJoinWith('Exhibition')
        ->where([
            'Exhibition.title LIKE' => '%'.$key.'%',
            'Exhibition.status IS NOT' => 8,
            'Exhibition.private' => 0,
            'Exhibition.is_event' => 1,
            'OR' => [['ExhibitionStream.live_started IS NOT' => '0000-00-00 00:00:00'], ['ExhibitionStream.is_upload' => 1, 'ExhibitionStream.vod_index' => 1]],
        ])->toArray());        

        $this->set(compact('exhibitions', 'key', 'count'));
        
        if ($this->request->is('put')) {
            $key = $this->request->getData('key');
            $order = $this->request->getData('order');

            $this->paginate = ['ExhibitionStream' => ['limit' => 12]];

            if ($order == "popular") :
                $exhibitions = $this->paginate($this->getTableLocator()->get('ExhibitionStream')->find()
                    ->select([
                        'Exhibition.id', 'Exhibition.title', 'Exhibition.image_path', 'Exhibition.image_name',
                        'ExhibitionStream.live_started', 'ExhibitionStream.vod_index', 'ExhibitionStream.viewer', 'ExhibitionStream.watched', 'ExhibitionStream.liked', 'ExhibitionStream.is_upload'
                    ])
                    ->LeftJoinWith('Exhibition')
                    ->where([
                        'Exhibition.title LIKE' => '%'.$key.'%',
                        'Exhibition.status IS NOT' => 8,
                        'Exhibition.private' => 0,
                        'Exhibition.is_event' => 1,
                        'OR' => [['ExhibitionStream.live_started IS NOT' => '0000-00-00 00:00:00'], ['ExhibitionStream.is_upload' => 1, 'ExhibitionStream.vod_index' => 1]],
                    ])
                    ->order(['ExhibitionStream.live_started' => 'DESC', 'ExhibitionStream.liked' => 'DESC']))->toArray();
            
            else :
                $exhibitions = $this->paginate($this->getTableLocator()->get('ExhibitionStream')->find()
                    ->select([
                        'Exhibition.id', 'Exhibition.title', 'Exhibition.image_path', 'Exhibition.image_name',
                        'ExhibitionStream.live_started', 'ExhibitionStream.vod_index', 'ExhibitionStream.viewer', 'ExhibitionStream.watched', 'ExhibitionStream.liked', 'ExhibitionStream.is_upload'
                    ])
                    ->LeftJoinWith('Exhibition')
                    ->where([
                        'Exhibition.title LIKE' => '%'.$key.'%',
                        'Exhibition.status IS NOT' => 8,
                        'Exhibition.private' => 0,
                        'Exhibition.is_event' => 1,
                        'OR' => [['ExhibitionStream.live_started IS NOT' => '0000-00-00 00:00:00'], ['ExhibitionStream.is_upload' => 1, 'ExhibitionStream.vod_index' => 1]],
                    ])
                    ->order(['ExhibitionStream.live_started' => 'DESC', 'Exhibition.created' => 'DESC']))->toArray();
            endif;

            $count = count($this->getTableLocator()->get('ExhibitionStream')->find()
                ->select([
                    'Exhibition.id', 'Exhibition.title', 'Exhibition.image_path', 'Exhibition.image_name',
                    'ExhibitionStream.live_started', 'ExhibitionStream.vod_index', 'ExhibitionStream.viewer', 'ExhibitionStream.watched', 'ExhibitionStream.liked', 'ExhibitionStream.is_upload'
                ])
                ->LeftJoinWith('Exhibition')
                ->where([
                    'Exhibition.title LIKE' => '%'.$key.'%',
                    'Exhibition.status IS NOT' => 8,
                    'Exhibition.private' => 0,
                    'Exhibition.is_event' => 1,
                    'OR' => [['ExhibitionStream.live_started IS NOT' => '0000-00-00 00:00:00'], ['ExhibitionStream.is_upload' => 1, 'ExhibitionStream.vod_index' => 1]],
                ])->toArray());   

            $view = new \Cake\View\View($this->request, $this->response);                                
            $view->set(compact('exhibitions', 'key', 'count'));
            $contents = $view->element('contest_search'); 

            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $contents, 'count' => $count]));
            return $response;
        }
    }

    public function fileDown($id = null, $down_file_name = null) {
        $notice = $this->getTableLocator()->get('Notice')->find('all')->where(['id' => $id])->toArray();
        $down = "/var/www/exon/bomi/webroot" . $notice[0]->file_path . "/" . $down_file_name;
        
        if(is_file($down)) {
            header("Content-Type:application/octet-stream");
            header("Content-Disposition:attachment;filename= " . $down_file_name);
            header("Content-Transfer-Encoding:binary");
            header("Content-Length:" . filesize($down));
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
            debug("no");
        }
    }
}