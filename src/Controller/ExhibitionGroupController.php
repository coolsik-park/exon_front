<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExhibitionGroup Controller
 *
 * @property \App\Model\Table\ExhibitionGroupTable $ExhibitionGroup
 * @method \App\Model\Entity\ExhibitionGroup[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionGroupController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Exhibition'],
        ];
        $exhibitionGroup = $this->paginate($this->ExhibitionGroup);

        $this->set(compact('exhibitionGroup'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition Group id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionGroup = $this->ExhibitionGroup->get($id, [
            'contain' => ['Exhibition', 'ExhibitionUsers'],
        ]);

        $this->set(compact('exhibitionGroup'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exhibitionGroup = $this->ExhibitionGroup->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionGroup = $this->ExhibitionGroup->patchEntity($exhibitionGroup, $this->request->getData());
            if ($this->ExhibitionGroup->save($exhibitionGroup)) {
                $this->Flash->success(__('The exhibition group has been saved.'));
            }
            $this->Flash->error(__('The exhibition group could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionGroup->Exhibition->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionGroup', 'exhibition'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Group id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibitionGroup = $this->ExhibitionGroup->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionGroup = $this->ExhibitionGroup->patchEntity($exhibitionGroup, $this->request->getData());
            if ($this->ExhibitionGroup->save($exhibitionGroup)) {
                $this->Flash->success(__('The exhibition group has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition group could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionGroup->Exhibition->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionGroup', 'exhibition'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition Group id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionGroup = $this->ExhibitionGroup->get($id);
        if ($this->ExhibitionGroup->delete($exhibitionGroup)) {
            $this->Flash->success(__('The exhibition group has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition group could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
