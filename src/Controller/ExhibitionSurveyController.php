<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\TableRegistry;

/**
 * ExhibitionSurvey Controller
 *
 * @property \App\Model\Table\ExhibitionSurveyTable $ExhibitionSurvey
 * @method \App\Model\Entity\ExhibitionSurvey[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionSurveyController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Exhibition', 'ParentExhibitionSurvey'],
        ];
        $exhibitionSurvey = $this->paginate($this->ExhibitionSurvey);

        $this->set(compact('exhibitionSurvey'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition Survey id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionSurvey = $this->ExhibitionSurvey->get($id, [
            'contain' => ['Exhibition', 'ParentExhibitionSurvey', 'ChildExhibitionSurvey', 'ExhibitionSurveyUsersAnswer'],
        ]);

        $this->set(compact('exhibitionSurvey'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exhibitionSurvey = $this->ExhibitionSurvey->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionSurvey = $this->ExhibitionSurvey->patchEntity($exhibitionSurvey, $this->request->getData());
            if ($this->ExhibitionSurvey->save($exhibitionSurvey)) {
                $this->Flash->success(__('The exhibition survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionSurvey->Exhibition->find('list', ['limit' => 200]);
        $parentExhibitionSurvey = $this->ExhibitionSurvey->ParentExhibitionSurvey->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionSurvey', 'exhibition', 'parentExhibitionSurvey'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Survey id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibitionSurvey = $this->ExhibitionSurvey->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionSurvey = $this->ExhibitionSurvey->patchEntity($exhibitionSurvey, $this->request->getData());
            if ($this->ExhibitionSurvey->save($exhibitionSurvey)) {
                $this->Flash->success(__('The exhibition survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionSurvey->Exhibition->find('list', ['limit' => 200]);
        $parentExhibitionSurvey = $this->ExhibitionSurvey->ParentExhibitionSurvey->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionSurvey', 'exhibition', 'parentExhibitionSurvey'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition Survey id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionSurvey = $this->ExhibitionSurvey->get($id);
        if ($this->ExhibitionSurvey->delete($exhibitionSurvey)) {
            $this->Flash->success(__('The exhibition survey has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition survey could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
