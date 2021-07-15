<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\Locator\LocatorAwareTrait;
// use Cake\ORM\Entity;

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
        $board->id = 2;
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
}