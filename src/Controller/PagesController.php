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

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
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

        // $this->Flash->set('The user has been saved.', [
        //     'element' => 'success'
        // ]);

        // https://book.cakephp.org/4/en/orm/retrieving-data-and-resultsets.html

        /* case 1 : ORM Query Generator */
        $this->loadModel('Banner');

        $banner = $this->Banner->find()
                        ->select(['Banner.id', 'Banner.img_path', 'Banner.img_name', 'Exhibition.title'])
                        ->leftJoinWith('Exhibition', function ($q) {
                            return $q->where(['Exhibition.title' => '테스트']);
                        })
                        ->where(['Banner.status'=>1])
                        ->order(['Banner.sort'])
                        ->toArray();



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

        //    echo($query->isEmpty()); //비었는지 확인
        //    echo("<pre>");print_r($query);  


        //case 5: threaded 샘플
        // $this->loadModel('ExhibitionSurvey');
        // $banner = $this->ExhibitionSurvey->find('threaded')
        //             ->where(['ExhibitionSurvey.exhibition_id'=>1])
    
        //             ->toArray();
        // echo("<pre>");print_r($banner);exit;


        //case 6: insert sample
        // $Users = $this->getTableLocator()->get('Users');
        // $user = $Users->newEmptyEntity();
        
        // $hashPswdObj = new DefaultPasswordHasher; //비밀번호 암호화
        // $user->email = 'coolsik@abc.com';
        // $user->password = $hashPswdObj->hash('1234'); 
        // $user->name = 'park';
        // $user->hp = '01048047466';
        // $user->refer = 'exon';
        // if(!$Users->save($user))
        // {
        //     echo("wrong!!");exit;
        // }
        // else
        // {
        //     echo("success");exit;
        // }
                        
        try {
            $this->set(compact('banner')); //key-value 연관배열을 쌍으로 적용('banner'=>$banner)
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }
    }

 
}