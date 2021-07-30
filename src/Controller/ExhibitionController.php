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
            'contain' => ['Banner', 'ExhibitionFile', 'ExhibitionGroup', 'ExhibitionStream', 'ExhibitionSurvey'],
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
                $path = 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    $imgName = $result->id . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);
                    
                    if ($connection->update('exhibition', ['image_path' => $path, 'image_name' => $imgName], ['id' => $result->id])) {
                        $parentId = 0;
                        $whereId = 0;

                        for ($i =0; $i < count($result->exhibition_survey); $i++) {

                            if ($result->exhibition_survey[$i]->survey_type != null && $result->exhibition_survey[$i]->is_duplicate != null) {
                                $parentId = $result->exhibition_survey[$i]->id;
                                $surveyType = $result->exhibition_survey[$i]->survey_type;
                                $isDuplicate = $result->exhibition_survey[$i]->is_duplicate;
                                $isMultiple = $result->exhibition_survey[$i]->is_multiple;
                            } else {
                                $whereId = $result->exhibition_survey[$i]->id;

                                if (!$connection->update('exhibition_survey', [
                                    'parent_id' => $parentId, 'survey_type' => $surveyType,
                                    'is_duplicate' => $isDuplicate, 'is_multiple' => $isMultiple], ['id' => $whereId])) {

                                        $connection->rollback(); 
                                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                                }
                            }
                        }
                        $connection->commit();
                        $this->Flash->success(__('The exhibition has been saved.'));
                        return $this->redirect(['action' => 'index']);
                        
                    } else {
                        $connection->rollback(); 
                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                    }
                
                }else {
                    $connection->rollback();
                    $this->Flash->error(__('Incorrect image type.'));
                    return $this->redirect(['action' => 'add']);
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
        $connection = ConnectionManager::get('default');
        $connection->begin();

        $exhibition = $this->Exhibition->get($id, [
            'contain' => ['ExhibitionGroup', 'ExhibitionSurvey'],
        ]);
        
        if ($this->request->is(['patch', 'post', 'put'])) {

            $connection->delete('exhibition_survey', ['exhibition_id' => $id]);
            $connection->delete('exhibition_group', ['exhibition_id' => $id]);
            
            $exhibition = $this->Exhibition->patchEntity($exhibition, $this->request->getData(), ['associated' => ['ExhibitionGroup', 'ExhibitionSurvey']]);
            
            if ($result = $this->Exhibition->save($exhibition)) {
                $img = $this->request->getData('image');
                $imgName = $img->getClientFilename();
                $index = strpos(strrev($imgName), strrev('.'));
                $expen = strtolower(substr($imgName, ($index * -1)));
                $path = 'upload' . DS . 'exhibition' . DS . date("Y") . DS . date("m");
                
                if ($expen == 'jpeg' || $expen == 'jpg' || $expen == 'png') {
                    
                    if (!file_exists(WWW_ROOT . $path)) {
                        $oldMask = umask(0);
                        mkdir(WWW_ROOT . $path, 0777, true);
                        chmod(WWW_ROOT . $path, 0777);
                        umask($oldMask);
                    }
    
                    $imgName = $result->id . "_main." . $expen;
                    $destination = WWW_ROOT . $path . DS . $imgName;
                    $img->moveTo($destination);
    
                    if ($connection->update('exhibition', ['image_path' => $path, 'image_name' => $imgName], ['id' => $result->id])) {
                        $parentId = 0;
                        $whereId = 0;

                        for ($i =0; $i < count($result->exhibition_survey); $i++) {

                            if ($result->exhibition_survey[$i]->survey_type != null && $result->exhibition_survey[$i]->is_duplicate != null) {
                                $parentId = $result->exhibition_survey[$i]->id;
                                $surveyType = $result->exhibition_survey[$i]->survey_type;
                                $isDuplicate = $result->exhibition_survey[$i]->is_duplicate;
                                $isMultiple = $result->exhibition_survey[$i]->is_multiple;
                            
                            } else {
                                $whereId = $result->exhibition_survey[$i]->id;

                                if (!$connection->update('exhibition_survey', [
                                    'parent_id' => $parentId, 'survey_type' => $surveyType,
                                    'is_duplicate' => $isDuplicate, 'is_multiple' => $isMultiple], ['id' => $whereId])) {

                                        $connection->rollback(); 
                                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                                }
                            }
                        }
                        $connection->commit();
                        $this->Flash->success(__('The exhibition has been saved.'));
                        return $this->redirect(['action' => 'index']);
                        
                    } else {
                        $connection->rollback(); 
                        $this->Flash->error(__('The exhibition survey could not be saved. Please, try again.'));
                    }
                
                }else {
                    $connection->rollback();
                    $this->Flash->error(__('Incorrect image type.'));
                    return $this->redirect(['action' => 'add']);
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
        $exhibitionSurveys = $this->getTableLocator()->get('ExhibitionSurvey')->find('all')->where(['exhibition_id' => $id]);
        $exhibitionGroups = $this->getTableLocator()->get('ExhibitionGroup')->find('all')->where(['exhibition_id' => $id]);
        $this->set(compact('exhibition', 'users', 'categories', 'types', 'exhibitionSurveys', 'exhibitionGroups'));
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
        $this->request->allowMethod(['get', 'post', 'delete']);
        
        $exhibition = $this->Exhibition->get($id);
        
        if ($this->Exhibition->delete($exhibition)) {
            $this->Flash->success(__('The exhibition has been deleted.')); 
        
        } else {
            $this->Flash->error(__('The exhibition could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);    
    }
}
