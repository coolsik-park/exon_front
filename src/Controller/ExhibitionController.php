<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Filesystem\Folder;
use Cake\Datasource\ConnectionManager;

/**
 * Exhibition Controller
 *
 * @property \App\Model\Table\ExhibitionTable $Exhibition
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');

        $this->Auth->allow();
        // $this->Auth->deny(['test'])
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $exhibition = $this->paginate($this->Exhibition);

        $this->set(compact('exhibition'));
    }

    /**
     * View method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['Users', 'Banner', 'ExhibitionFile', 'ExhibitionGroup', 'ExhibitionStream', 'ExhibitionSurvey'],
        ]);

        $this->set(compact('exhibition'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition = $this->Exhibition->newEmptyEntity();

        if ($this->request->is('post')) {
            $exhibition = $this->Exhibition->patchEntity($exhibition, $this->request->getData(), ['associated' => ['ExhibitionGroup', 'ExhibitionSurvey']]);

            if ($result = $this->Exhibition->save($exhibition)) {
                $img = $this->request->getData('image');
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = WWW_ROOT . 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists($path)) {
                        $oldMask = umask(0);
                        mkdir($path, 0777, true);
                        chmod($path, 0777);
                        umask($oldMask);
                    }
    
                    $imgName = $result->id . "_main." . $expen;
                    $destination = $path . DS . $imgName;
                    $img->moveTo($destination);
    
                    $query  = "UPDATE exhibition SET";
                    $query .= " image_path='" . $path . "'";
                    $query .= ", image_name='" . $imgName . "'";
                    $query .= " where id=" . $result->id;
                
                }else {
                    $this->Flash->error(__('Incorrect image type.'));
                    return $this->redirect(['action' => 'add']);
                }
               
                
                if ($connection->query($query)) {
                    $parentId = $result->exhibition_survey[0]->id;
                    $whereId = $parentId + 1;

                    $query  = "UPDATE exhibition_survey SET";
                    $query .= " parent_id=" . $parentId;
                    $query .= " where id=" . $whereId;

                    if ($connection->query($query)) {
                        $connection->commit();
                        $this->Flash->success(__('The exhibition has been saved.'));
                        return $this->redirect(['action' => 'index']);
                    
                    } else {
                        $connection->rollback(); 
                        $this->Flash->error(__('The exhibition img could not be saved. Please, try again.'));
                    }

                } else {
                    $connection->rollback(); 
                    $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                }

            } else {
                $connection->rollback(); 
                $this->Flash->error(__('The exhibition could not be saved. Please, try again.'));
            }       
        }
        $commonCategory = $this->getTableLocator()->get('CommonCategory');
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $categories = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'category']);
        $types = $commonCategory->find('list')->select('title')->where(['tables' => 'exhibition', 'types' => 'type']);
        $this->set(compact('exhibition', 'users', 'categories', 'types'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['Users'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibition = $this->Exhibition->patchEntity($exhibition, $this->request->getData());
            if ($this->Exhibition->save($exhibition)) {
                $this->Flash->success(__('The exhibition has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The exhibition could not be saved. Please, try again.'));
        }
        $users = $this->Exhibition->Users->find('list', ['limit' => 200]);
        $this->set(compact('exhibition', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Exhibition id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibition = $this->Exhibition->get($id);
        if ($this->Exhibition->delete($exhibition)) {
            $this->Flash->success(__('The exhibition has been deleted.'));
        } else {
            $this->Flash->error(__('The exhibition could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
