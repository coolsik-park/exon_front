<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExhibitionSpeaker Controller
 *
 * @property \App\Model\Table\ExhibitionSpeakerTable $ExhibitionSpeaker
 * @method \App\Model\Entity\ExhibitionSpeaker[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionSpeakerController extends AppController
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
        $exhibitionSpeaker = $this->paginate($this->ExhibitionSpeaker);

        $this->set(compact('exhibitionSpeaker'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition Speaker id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibitionSpeaker = $this->ExhibitionSpeaker->get($id, [
            'contain' => ['Exhibition'],
        ]);

        $this->set(compact('exhibitionSpeaker'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $exhibitionSpeaker = $this->ExhibitionSpeaker->newEmptyEntity();
        if ($this->request->is('post')) {
            $exhibitionSpeaker = $this->ExhibitionSpeaker->patchEntity($exhibitionSpeaker, $this->request->getData());
            if ($this->ExhibitionSpeaker->save($exhibitionSpeaker)) {
                $this->Flash->success(__('The exhibition speaker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition speaker could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionSpeaker->Exhibition->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionSpeaker', 'exhibition'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition Speaker id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibitionSpeaker = $this->ExhibitionSpeaker->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionSpeaker = $this->ExhibitionSpeaker->patchEntity($exhibitionSpeaker, $this->request->getData());
            if ($this->ExhibitionSpeaker->save($exhibitionSpeaker)) {
                $this->Flash->success(__('The exhibition speaker has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition speaker could not be saved. Please, try again.'));
        }
        $exhibition = $this->ExhibitionSpeaker->Exhibition->find('list', ['limit' => 200]);
        $this->set(compact('exhibitionSpeaker', 'exhibition'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition Speaker id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionSpeaker = $this->ExhibitionSpeaker->get($id);
        if ($this->ExhibitionSpeaker->delete($exhibitionSpeaker)) {
            $this->Flash->success(__('The exhibition speaker has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition speaker could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
