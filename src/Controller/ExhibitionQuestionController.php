<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExhibitionQuestion Controller
 *
 * @property \App\Model\Table\ExhibitionQuestionTable $ExhibitionQuestion
 * @method \App\Model\Entity\ExhibitionQuestion[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionQuestionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ExhibitionUsers', 'ParentExhibitionQuestion'],
        ];
        $exhibitionQuestion = $this->paginate($this->ExhibitionQuestion);

        $this->set(compact('exhibitionQuestion'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition Question id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionQuestion = $this->ExhibitionQuestion->get($id, [
            'contain' => ['ExhibitionUsers', 'ParentExhibitionQuestion', 'ChildExhibitionQuestion'],
        ]);

        $this->set(compact('exhibitionQuestion'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exhibitionQuestion = $this->ExhibitionQuestion->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionQuestion = $this->ExhibitionQuestion->patchEntity($exhibitionQuestion, $this->request->getData());
            if ($this->ExhibitionQuestion->save($exhibitionQuestion)) {
                $this->Flash->success(__('The exhibition question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition question could not be saved. Please, try again.'));
        }
        $exhibitionUsers = $this->ExhibitionQuestion->ExhibitionUsers->find('list', ['limit' => 200]);
        $parentExhibitionQuestion = $this->ExhibitionQuestion->ParentExhibitionQuestion->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionQuestion', 'exhibitionUsers', 'parentExhibitionQuestion'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Question id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibitionQuestion = $this->ExhibitionQuestion->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionQuestion = $this->ExhibitionQuestion->patchEntity($exhibitionQuestion, $this->request->getData());
            if ($this->ExhibitionQuestion->save($exhibitionQuestion)) {
                $this->Flash->success(__('The exhibition question has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition question could not be saved. Please, try again.'));
        }
        $exhibitionUsers = $this->ExhibitionQuestion->ExhibitionUsers->find('list', ['limit' => 200]);
        $parentExhibitionQuestion = $this->ExhibitionQuestion->ParentExhibitionQuestion->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionQuestion', 'exhibitionUsers', 'parentExhibitionQuestion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition Question id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionQuestion = $this->ExhibitionQuestion->get($id);
        if ($this->ExhibitionQuestion->delete($exhibitionQuestion)) {
            $this->Flash->success(__('The exhibition question has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition question could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
