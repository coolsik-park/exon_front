<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class BoardsController extends AppController
{

    public function index()
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $boards = $this->paginate($userquestion_table);
        $this->set(compact('boards'));
    }
    
    public function add()
    {
        $userquestion_table = TableRegistry::get('UserQuestion');
        $board = $userquestion_table->newEmptyEntity();
        $board->faq_category_id = 1;   
        if($this->request->is('post')) {
            $board = $userquestion_table->patchEntity($board, $this->request->getData());
            echo($board);
            if($userquestion_table->save($board)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('board'));
    }

    public function fileadd()
    {
        $userquestionfiles_table = TableRegistry::get('UserQuestionFiles');
        $board_file = $userquestionfiles_table->newEmptyEntity();
        $board_file->user_question_id = 1;
        // $board_file->file_path = 
        if($this->request->is('post')) {
            $postdata = $this->request->getData();
            $postfile = $this->request->getData('file_name');
            // debug($postfile);
            $name = $postfile->getClientFilename();
            // debug($name);
            $type = $postfile->getClientMediaType();
            // debug($type);
            $file_path = WWW_ROOT. 'upload/boards/';
            if($type == 'image/jpeg' || $type == 'image/jpg' || $type == 'image/png') {
                if(!empty($name)) {
                    if($postfile->getSize() > 0 && $postfile->getError() == 0) {
                        $postfile->moveTo($file_path.$name);
                        $postdata['file_name'] = $name;
                        $postdata['file_path'] = $file_path;
                    }
                }
            }
            $board_file = $userquestionfiles_table->patchEntity($board_file, $postdata);
            if($userquestionfiles_table->save($board_file)) {
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
        $this->set(compact('board_file'));
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