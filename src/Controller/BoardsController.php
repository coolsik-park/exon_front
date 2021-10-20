<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class BoardsController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
        $this->Auth->allow();
    }


    public function index()
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $boards = $this->paginate($userquestion_table);
        $this->set(compact('boards'));
    }
    
    public function add()
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $userquestion_table = TableRegistry::get('UserQuestion');
        $board = $userquestion_table->newEmptyEntity();

        if ($this->request->is('post')) {
            $board->faq_category_id = $this->request->getData('faq_category_id');
            $board->users_id = $this->Auth->user('id');
            $board->title = $this->request->getData('title');
            $board->users_name = $this->request->getData('users_name');
            $board->users_hp = $this->request->getData('users_hp');
            $board->users_email = $this->request->getData('users_email');
            $board->question = $this->request->getData('question');

            if ($result = $userquestion_table->save($board)) {
                $connection->commit();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'users_question_id' => $result->id]));
            } else {
                $connection->rollback();
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'fail']));
            }
            return $response;
        }

        $faqCategory = $this->getTableLocator()->get('FaqCategory');
        $categories = $faqCategory->find('list', ['keyField' => 'id', 'valueField' => 'text'])->where(['status' => 1]);

        $this->set(compact('board', 'categories'));
    }

    public function fileUpload($question_id = null)
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $usersquestionfiles_table = TableRegistry::get('UserQuestionFiles');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $count = count($data['file']);
    
            for ($i=0; $i<$count; $i++) {
                $usersquestionfiles = $usersquestionfiles_table->newEmptyEntity();
                $usersquestionfiles->user_question_id = $question_id;
                $usersquestionfiles->file_path = '';
                $usersquestionfiles->file_name = '';
                
                if ($result = $usersquestionfiles_table->save($usersquestionfiles)) {
                    $file = $data['file'][$i];
                    $fileName = $file->getClientFilename();
                    $index = strpos(strrev($fileName), strrev('.'));
                    $expen = strtolower(substr($fileName, ($index * -1)));
                    $path = 'upload' . DS . 'user_question_files' . DS . date("Y") . DS . date("m");
    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    $fileName = $result->id . "_users_question." . $expen;
                    $destination = WWW_ROOT . $path . DS . $fileName;
                    $file->moveTo($destination);
        
                    if ($connection->update('user_question_files', ['file_path' => $path, 'file_name' => $fileName], ['id' => $result->id])) {
                        $connection->commit();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
                    } else {
                        $connection->rollback();
                        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'failaaaaaa']));
                    }
                } else {
                    $connection->rollback();
                    $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'failbbbbbb']));
                }
            }
            $connection->commit();
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));
            return $response;
        }
    }

    public function view($id = null) 
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $board = $userquestion_table->get($id, [
            'contain' => ['UserQuestionFiles']
        ]);
        $this->set(compact('board'));
    }

    public function edit($id = null)
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $board = $userquestion_table->get($id, [
            'contain' => [],
        ]);
        if($this->request->is(['patch', 'post', 'put'])) {
            $board = $userquestion_table->patchEntity($board, $this->request->getData());
            if($userquestion_table->save($board)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $faqCategory = $this->getTableLocator()->get('FaqCategory');
        $categories = $faqCategory->find('list')->select('text')->where(['status' => 1]);
        $this->set(compact('board', 'categories'));
    }

    public function delete($id = null)
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $this->request->allowMethod(['get', 'post', 'delete']);
        $board = $userquestion_table->get($id);
        if($userquestion_table->delete($board)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function notice()
    {
        $this->paginate = ['limit' => 10];
        
        $notice_table = TableRegistry::get('Notice');
        $boards = $this->paginate($notice_table);
        $this->set(compact('boards'));
    }

    public function searchTitle()
    {
        $this->paginate = ['limit' => 10];

        $search = $this->request->getData('search');

        $notice_table = TableRegistry::get('Notice');
        $boards = $this->paginate($notice_table->find('all')->where(['Notice.title LIKE' => '%'.$search.'%']));
        $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $boards]));

        return $response;
    }

    public function  noticeAdd() 
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $notice_table = TableRegistry::get('Notice');
        $board = $notice_table->newEmptyEntity();
        $board->file_path = '';
        $board->file_name = '';

        if($this->request->is('post')) {
            $board = $notice_table->patchEntity($board, $this->request->getData('board'));

            if($result = $notice_table->save($board)) {
                $file = $this->request->getData('file_name');
                $fileName = $file->getClientFilename();
                $index = strpos(strrev($fileName), strrev('.'));
                $expen = strtolower(substr($fileName, ($index*-1)));
                $path = 'upload' . DS . 'notice' . DS . date("Y") . date("m");

                if(!file_exists(WWW_ROOT . $path)) {
                    $oldMask = umask(0);
                    mkdir(WWW_ROOT . $path, 0777, true);
                    chmod(WWW_ROOT . $path, 0777);
                    umask($oldMask);
                }

                $fileName = $result->id . "_notice." . $expen;
                $destination = WWW_ROOT . $path . DS . $fileName;
                $file->moveTO($destination);

                if($connection->update('notice', ['file_path' => $path, 'file_name' => $fileName], ['id' => $result->id])) {
                    $connection->commit();
                    $this->Flash->success(__('Your Post has been saved.'));
                    return $this->redirect(['action' => 'notice']);
                } else {
                    $connection->rollback();
                    $this->Flash->error(__('Unable to add you post.'));
                }

            } else {
                $connection->rollback();
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
                
            }
        }
        $this->set(compact('board'));
    }

    public function noticeView($id = null)
    {
        $notice_table = TableRegistry::get('Notice');
        $board = $notice_table->get($id, ['contation' => []]);
        $this->set(compact('board'));
    }

    public function noticeEdit($id = null)
    {
        $notice_table = TableRegistry::get('Notice');
        $board = $notice_table->get($id, [
            'contain' => [],
        ]);
        if($this->request->is(['patch', 'post', 'put'])) {
            $board = $notice_table->patchEntity($board, $this->request->getData());
            if($notice_table->save($board)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'notice']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('board'));
    }

    public function noticeDelete($id = null)
    {
        $notice_table = TableRegistry::get('Notice');
        $board = $notice_table->get($id, [
            'contain' => [],
        ]);
        if($notice_table->delete($board)) {
            $this->Flash->error(__('The user has deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'notice']);
    }

    public function customerService()
    {
        $this->paginate = ['limit' => 10];

        $faq_table = TableRegistry::get('Faq');

        for ($i=0; $i<=6; $i++) {
            $count[$i] = $faq_table->find()->where(['faq_category_id' => $i+1])->count();
        }

        $faqs_main = $faq_table->find()->select(['id', 'title', 'content'])->where(['is_main' => 1]);

        $faqs = $this->paginate($faq_table->find()->select(['id', 'title', 'content']));

        $this->set(compact('count', 'faqs_main', 'faqs'));
    }

    public function faqsByCategory($categoryId = null)
    {
        $this->paginate = ['limit' => 10];

        $faq_table = TableRegistry::get('Faq');

        if ($categoryId == '0') {
            $faqs = $this->paginate($faq_table->find()->select(['id', 'title', 'content']));
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $faqs]));
        } else {
            $faqs = $this->paginate($faq_table->find()->select(['id', 'title', 'content'])->where(['faq_category_id' => $categoryId]));
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success', 'data' => $faqs]));
        }
    
        return $response;
    }
}