<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{

    public function initialize(): void
    {
        
        parent::initialize();
        $this->loadComponent('Auth');
        $this->Auth->allow();
    }

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function display(string ...$path): ?Response
    {


        // https://book.cakephp.org/4/en/orm/retrieving-data-and-resultsets.html

        /* case 1 : ORM Query Generator */
        $this->loadModel('Banner');

        //메인 배너
        $banner = $this->Banner->find('all')
                        ->select(['Banner.id', 'Banner.exhibition_id', 'Banner.img_path', 'Banner.img_name', 'Exhibition.title'])
                        ->contain(['Exhibition'])
                        // ->leftJoinWith('Exhibition', function ($q) {
                        //     return $q->where(['Exhibition.title' => '테스트']);
                        // })
                        ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'main'])
                        ->order(['Banner.sort'])
                        ->toArray();

        $banner_m = $this->Banner->find('all')
                        ->select(['Banner.id', 'Banner.exhibition_id', 'Banner.img_path', 'Banner.img_name', 'Exhibition.title'])
                        ->contain(['Exhibition'])
                        // ->leftJoinWith('Exhibition', function ($q) {
                        //     return $q->where(['Exhibition.title' => '테스트']);
                        // })
                        ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'mobile'])
                        ->order(['Banner.sort'])
                        ->toArray();
        
        //HOT 10
        // $hot = $this->Banner->find('all')
        //                 ->select(['Banner.id', 'Banner.exhibition_id', 'Banner.img_path', 'Banner.img_name'
        //                         ,"title" => 'Exhibition.title', "description"=>'Exhibition.description','sdate'=>'date_format(Exhibition.sdate,"%m. %d")','edate'=>'date_format(Exhibition.edate,"%m. %d")'
        //                         , 'playing'=>'now() between Exhibition.sdate and Exhibition.edate' // 진행여부 ,1: 진행중
        //                         ])
        //                 ->contain(['Exhibition'])
        //                 ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'hot'])
        //                 ->order(['Banner.sort'])
        //                 ->limit('10')
        //                 ->toArray();

        $conn = ConnectionManager::get('default'); 

        

        //HOT 10
        $query  = " SELECT ";
        $query .= "  id AS exhibition_id, ";
        $query .= "  title AS title, image_path as img_path, image_name as img_name, ";
        $query .= "  description AS description, ";
        $query .= "  date_format(sdate, '%m. %d. %H:%i') AS sdate, ";
        $query .= "  date_format(edate, '%m. %d. %H:%i') AS edate, ";
        $query .= "  date_ADD(now(), INTERVAL 9 HOUR) between sdate ";
        $query .= "  and edate AS playing ";
        $query .= "FROM ";
        $query .= "  exhibition  ";
        $query .= "WHERE ";
        $query .= "  private = 0 AND status != 4 AND status != 8 AND date_ADD(now(), INTERVAL 9 HOUR) < edate ";
        $query .= "ORDER BY ";
        $query .= "  sdate ";
        $query .= "LIMIT ";
        $query .= "  10 ";
        
        $stmt = $conn->query($query);
        $hot = $stmt->fetchAll('assoc');

                        // print_r($hot);exit;

        //NEW 10
        // $new = $this->Banner->find('all')
        // ->select(['Banner.id', 'Banner.exhibition_id', 'Banner.img_path', 'Banner.img_name'
        //         ,"title" => 'Exhibition.title', "description"=>'Exhibition.description','sdate'=>'date_format(Exhibition.sdate,"%m. %d")','edate'=>'date_format(Exhibition.edate,"%m. %d")'
        //         , 'playing'=>'now() between Exhibition.sdate and Exhibition.edate' // 진행여부 ,1: 진행중
        //         ])
        // ->contain(['Exhibition'])
        // ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'new'])
        // ->order(['Banner.sort'])
        // ->limit('10')
        // ->toArray();    
        $query  = " SELECT ";
        $query .= "  id AS exhibition_id, ";
        $query .= "  title AS title, image_path as img_path, image_name as img_name, ";
        $query .= "  description AS description, ";
        $query .= "  date_format(sdate, '%m. %d. %H:%i') AS sdate, ";
        $query .= "  date_format(edate, '%m. %d. %H:%i') AS edate, ";
        $query .= "  date_ADD(now(), INTERVAL 9 HOUR) between sdate ";
        $query .= "  and edate AS playing ";
        $query .= "FROM ";
        $query .= "  exhibition  ";
        $query .= "WHERE ";
        $query .= "  private = 0 AND status != 4 AND status != 8 AND date_ADD(now(), INTERVAL 9 HOUR) < edate AND date_format(sdate, '%m') = date_format(date_ADD(now(), INTERVAL 9 HOUR), '%m') ";
        $query .= "ORDER BY ";
        $query .= "  sdate ";
        $query .= "LIMIT ";
        $query .= "  10 ";
        
        $stmt = $conn->query($query);
        $new = $stmt->fetchAll('assoc');                    

         //NORMAL 10
        //  $normal = $this->Banner->find('all')
        //  ->select(['Banner.id', 'Banner.exhibition_id', 'Banner.img_path', 'Banner.img_name'
        //          ,"title" => 'Exhibition.title', "description"=>'Exhibition.description','sdate'=>'date_format(Exhibition.sdate,"%m. %d")','edate'=>'date_format(Exhibition.edate,"%m. %d")'
        //          , 'playing'=>'now() between Exhibition.sdate and Exhibition.edate' // 진행여부 ,1: 진행중
        //          ])
        //  ->contain(['Exhibition'])
        //  ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'normal'])
        //  ->order(['Banner.sort'])
        //  ->limit('10')
        //  ->toArray();
        $query  = " SELECT ";
        $query .= "  id AS exhibition_id, ";
        $query .= "  title AS title, image_path as img_path, image_name as img_name, ";
        $query .= "  description AS description, ";
        $query .= "  date_format(sdate, '%m. %d. %H:%i') AS sdate, ";
        $query .= "  date_format(edate, '%m. %d. %H:%i') AS edate, ";
        $query .= "  date_ADD(now(), INTERVAL 9 HOUR) between sdate ";
        $query .= "  and edate AS playing ";
        $query .= "FROM ";
        $query .= "  exhibition  ";
        $query .= "WHERE ";
        $query .= "  private = 0 AND status != 4 AND status != 8 AND date_ADD(now(), INTERVAL 9 HOUR) < edate ";
        $query .= "ORDER BY ";
        $query .= "  id desc ";
        $query .= "LIMIT ";
        $query .= "  10 ";
        
        $stmt = $conn->query($query);
        $normal = $stmt->fetchAll('assoc');

        //CONTEST 10
        $query  = " SELECT ";
        $query .= "  E.id AS exhibition_id, ";
        $query .= "  E.title AS title, E.image_path as img_path, E.image_name as img_name, ";
        $query .= "  E.description AS description, ES.live_started as live_started, ES.vod_index as vod_index, ";
        $query .= "  ES.viewer as viewer, ES.watched as watched, ES.liked as liked, ES.is_upload as is_upload ";
        $query .= "FROM ";
        $query .= "  exhibition_stream ES ";
        $query .= "LEFT JOIN exhibition E ON ES.exhibition_id = E.id ";
        $query .= "WHERE ";
        $query .= "  E.private = 0 AND E.is_event = 1 AND status != 4 AND E.status != 8 AND (live_started != '0000-00-00 00:00:00' OR vod_index != 0 AND is_upload = 1) ";
        $query .= "ORDER BY ";
        $query .= "  ES.live_started desc, E.created desc ";
        $query .= "LIMIT ";
        $query .= "  10 ";
        
        $stmt = $conn->query($query);
        $contest = $stmt->fetchAll('assoc');

       /* case 2 : Custom Query */ 
        // $this->conn = ConnectionManager::get('default'); 

        // $query = " select B.id, B.img_path, B.img_name, E.title ";
        // $query .= " from banner B ";
        // $query .= " LEFT JOIN exhibition E ON B.exhibition_id = E.id AND E.title='테스트' ";
        // $query .= " WHERE B.status=1 ";
        // $query .= " ORDER BY sort ";

        // $stmt = $this->conn->query($query);
        // $banner = $stmt->fetchAll('assoc');

       /* case 3: query count */
        //    $query = $this->Banner->find('all')
        //                         ->leftJoinWith('Exhibition', function ($q) {
        //                             return $q->where(['Exhibition.title' => '테스트']);
        //                         })
        //                         ->where(['Banner.status'=>1])
        //     ;
        //    $number = $query->count();       
        //    print_r($number);     
        
        
        /* case 4: search */

        //    $this->loadModel('Exhibition');
        //    $query = $this->Exhibition->findByTitle('테스트')->toArray();

        // //    print_r($query->isEmpty()); //비었는지 확인 -> 확인 필요
        //    echo("<pre>");print_r($query);  


        //case 5: threaded 샘플
        // $this->loadModel('ExhibitionSurvey');
        // $banner = $this->ExhibitionSurvey->find('threaded')
        //             ->where(['ExhibitionSurvey.exhibition_id'=>279])
        //             ->toArray();
        // echo("<pre>");print_r($banner);exit;


        //case 6: insert sample 
        // $Users = $this->getTableLocator()->get('Users');
        // $user = $Users->newEmptyEntity();
        // $hashPswdObj = new DefaultPasswordHasher; //비밀번호 암호화

        // $user->email = 'coolsik@ab32c2d.com';
        // // $user->password = $hashPswdObj->hash('1234'); 
        // $user->name = 'park';
        // $user->hp = '010480474d66';
        // $user->refer = 'exon';

        // if(!$Users->save($user))
        // {
        //     echo("wrong!!");exit;
        // }
        // else
        // {
        //     echo("success");exit;
        // }
           
        
        //case 7: update sample 
        // $Users = $this->getTableLocator()->get('Users');
        // $user = $Users->get('2');
        // $user->company = 'bbb';
        // if(!$Users->save($user))
        // {
        //     echo("wrong!!");exit;
        // }
        // else
        // {
        //     echo("success");exit;
        // }


        //case 8: delete sample 
        // $Banners = $this->getTableLocator()->get('Banner');
        // $banner = $Banners->get(2);
        // if ($Banners->delete($banner)) {
        //     $this->Flash->success(__('The user has been deleted.'));
        // } else {
        //     $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        // }

        // echo("<pre>");print_r($hot);exit;

        try {
            $this->set(compact('banner', 'banner_m', 'hot', 'new', 'normal', 'contest')); //key-value 연관배열을 쌍으로 적용('banner'=>$banner)
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

    public function introduce()
    {
        
    }
}