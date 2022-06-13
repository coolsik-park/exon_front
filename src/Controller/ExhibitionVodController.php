<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ExhibitionVod Controller
 *
 * @property \App\Model\Table\ExhibitionVodTable $ExhibitionVod
 * @method \App\Model\Entity\ExhibitionVod[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ExhibitionVodController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        
        parent::beforeFilter($event);
        $this->loadComponent('Auth');
    }

    public function isAuthorized() 
    {
        if(!empty($this->Auth->user('id'))) {
            return true;
        }
        // Default deny
        return parent::isAuthorized($user);
    }
    
    public function addChapter($exhibition_id = null)
    {
        $exhibitionVod = $this->ExhibitionVod->newEmptyEntity();
        
        $exhibitionVod->exhibition_id = $exhibition_id;
        $exhibitionVod->title = $this->request->getData('title');
        
        if ($this->ExhibitionVod->save($exhibitionVod)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));    
            return $response;
        }
    }

    public function addVod($exhibition_id = null)
    {
        $file = $this->request->getData('file');
        $path = '/svc' . DS . 'exon' . DS . 'data' . DS . 'video' . DS . $exhibition_id;

        if (!file_exists($path)) {
            $oldMask = umask(0);
            mkdir($path, 0777, true);
            chmod($path, 0777);
            umask($oldMask);
        }

        $destination = $path . DS . $this->request->getData('title') . '.mp4';
        $file->moveTo($destination);

        $exhibitionVod = $this->ExhibitionVod->newEmptyEntity();

        $exhibitionVod->exhibition_id = $exhibition_id;
        $exhibitionVod->title = $this->request->getData('title');
        $exhibitionVod->description = $this->request->getData('description');
        $exhibitionVod->parent_id = $this->request->getData('parent_id');

        if ($this->ExhibitionVod->save($exhibitionVod)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));    
            return $response;
        } 
    }

    public function edit($id = null)
    {
        if ($this->request->is(['patch', 'post', 'put'])) {
            $exhibitionVod = $this->ExhibitionVod->get($id);

            $exhibitionVod->title = $this->request->getData('title');
            $exhibitionVod->description = $this->request->getData('description');
            if ($this->ExhibitionVod->save($exhibitionVod)) {
                $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));    
                return $response;
            } 
        }
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $exhibitionVod = $this->ExhibitionVod->get($id);

        if ($this->ExhibitionVod->delete($exhibitionVod)) {
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));    
            return $response;
        } 
    }

    public function hideVod($id = null)
    {
        if ($this->request->is('post')) {
            $exhibitionVod = $this->ExhibitionVod->get($id);
            if ($this->request->getData('action') == 'hide') {
                if ($exhibitionVod->parent_id == null) {
                    $chapter = $this->ExhibitionVod->find('all', ['contain' => 'ChildExhibitionVod'])->where(['id' => $id])->toArray();
                    foreach ($chapter[0]['child_exhibition_vod'] as $child) {
                        $exhibitionVod = $this->ExhibitionVod->get($child['id']);
                        $exhibitionVod->is_show = 0;
                        $this->ExhibitionVod->save($exhibitionVod);
                    }
                    $exhibitionVod = $this->ExhibitionVod->get($chapter[0]['id']);
                    $exhibitionVod->is_show = 0;
                    $this->ExhibitionVod->save($exhibitionVod);
                } else {
                    $exhibitionVod = $this->ExhibitionVod->get($id);
                    $exhibitionVod->is_show = 0;
                    $this->ExhibitionVod->save($exhibitionVod);
                }
            } else {
                if ($exhibitionVod->parent_id == null) {
                    $chapter = $this->ExhibitionVod->find('all', ['contain' => 'ChildExhibitionVod'])->where(['id' => $id])->toArray();
                    foreach ($chapter[0]['child_exhibition_vod'] as $child) {
                        $exhibitionVod = $this->ExhibitionVod->get($child['id']);
                        $exhibitionVod->is_show = 1;
                        $this->ExhibitionVod->save($exhibitionVod);
                    }
                    $exhibitionVod = $this->ExhibitionVod->get($chapter[0]['id']);
                    $exhibitionVod->is_show = 1;
                    $this->ExhibitionVod->save($exhibitionVod);
                } else {
                    $exhibitionVod = $this->ExhibitionVod->get($id);
                    $exhibitionVod->is_show = 1;
                    $this->ExhibitionVod->save($exhibitionVod);
                }
            }
            $response = $this->response->withType('json')->withStringBody(json_encode(['status' => 'success']));    
            return $response;
        } 
    }
}
