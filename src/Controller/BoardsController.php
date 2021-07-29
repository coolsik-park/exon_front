<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

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

        if($this->request->is('post')) {
            $board = $userquestion_table->patchEntity($board, $this->request->getData());
            
            if($result = $userquestion_table->save($board)) {
                $file = $this->request->getData('file_name');
                $fileName = $file->getClientFilename();
                $index = strpos(strrev($fileName), strrev('.'));
                $expen = strtolower(substr($fileName, ($index * -1)));
                $path = 'upload' . DS . 'boards' . DS . 'user_question' . DS . date("Y") . DS . date("m");

                if (!file_exists(WWW_ROOT . $path)) {
                    $oldMask = umask(0);
                    mkdir(WWW_ROOT . $path, 0777, true);
                    chmod(WWW_ROOT . $path, 0777);
                    umask($oldMask);
                }
                
                $fileName = $result->id . "_question." . $expen;
                $destination = WWW_ROOT . $path . DS . $fileName;
                $file->moveTo($destination);

                $query = "INSERT INTO user_question_files(user_question_id, file_path, file_name)";
                $query .= " values(" . $result->id . ", '" . $path . "', '" . $fileName . "')";

                if($connection->query($query)) {
                    $connection->commit();
                    $this->Flash->success(__('Your post has been saved.'));
                    return $this->redirect(['action' => 'index']);
                } else {
                    $connection->rollback();
                    $this->Flash->error(__('Unable to add your post.'));
                }
            } else {
                $connection->rollback();
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $faqCategory = $this->getTableLocator()->get('FaqCategory');
        $categories = $faqCategory->find('list')->select('text')->where(['status' => 1]);
        $this->set(compact('board', 'categories'));
    }

    public function view($id = null) 
    {
        echo($id);
        exit;
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
        $this->set(compact('board'));
    }

    public function delete($id = null)
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $this->request->allowMethod(['post', 'delete']);
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
        $notice_table = TableRegistry::get('Notice');
        $boards = $this->paginate($notice_table);
        $this->set(compact('boards'));
    }

    public function notice_view($id = null)
    {
        echo($id);
        exit;
    }

    public function faqsByCategory($FaqCategoryId = null)
    {
        $faqs = $this->getTableLocator()->get('Faq');
        if($FaqCategoryId == null) {
            $faqs = $faqs->find()->select(['id', 'title']);
        } else {
            $faqs = $faqs->find()->select(['id', 'title'])->where(['faq_category_id' => $FaqCategoryId]);
        }
        $faqs = $this->paginate($faqs);
        $this->set(compact('faqs'));
    }
}