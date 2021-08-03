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

        $banner = $this->Banner->find('all')
                        ->select(['Banner.id', 'Banner.img_path', 'Banner.img_name', 'Exhibition.title'])
                        ->leftJoinWith('Exhibition', function ($q) {
                            return $q->where(['Exhibition.title' => '테스트']);
                        })
                        ->where(['Banner.status'=>1, 'now() between Banner.sdate AND Banner.edate', 'Banner.type'=>'main'])
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

        // //    print_r($query->isEmpty()); //비었는지 확인 -> 확인 필요
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

        // echo("<pre>");print_r($banner);exit;

        try {
            $this->set(compact('banner')); //key-value 연관배열을 쌍으로 적용('banner'=>$banner)
            return $this->render(implode('/', $path));
        } catch (MissingTemplateException $exception) {
            if (Configure::read('debug')) {
                throw $exception;
            }
            throw new NotFoundException();
        }

        //파일 업로드 예제

        if($this->getRequest()->getData('type')==1){ //이력서 직접등록
            parse_str($this->getRequest()->getData('queryString'), $output); //serilaize된 querystring 파싱
            // echo(“<pre>“);print_r($utput);exit;o
            $index = strpos(strrev($_FILES['file']['name']) , strrev('.'));
            $expen = strtolower(substr( $_FILES['file']['name'] , ($index * -1) )); //파일 확장자 분리
            $name =  date("YmdHis") . "_" . $_FILES['file']['name'];
            //do the actual uploading of the file. First arg is the tmp name, second arg is
            //where we are putting it
            if(move_uploaded_file( $_FILES['file']['tmp_name'], WWW_ROOT . 'upload/proposal/' . $name)){
                //데이터 저장
                $applicant->name = $output['name'];
                $applicant->yyyymmdd = $output['yyyymmdd'];
                $applicant->hp = $output['hp'];
                $applicant->email = $output['email'];
                $applicant->worknet = $output['worknet'];
                $applicant->company_id_1st = $output['company_id_1st'];
                $applicant->company_name_1st = $this->getRequest()->getData('company_name_1st');
                // $applicant->selected_day_1st = $output[‘selected_day_1st’];
                $applicant->company_id_2st = $output['company_id_2st'];
                $applicant->company_name_2st = $this->getRequest()->getData('company_name_2st');
                // $applicant->selected_day_2st = $output['selected_day_2st'];
                $applicant->interview_type = $output['interview_type'];
                $applicant->interview_place = $this->getRequest()->getData('interview_place');
                $applicant->proposal_type = $output['proposal_type'];
                $applicant->resume_image_path = 'upload/proposal/' . $name;
                $applicant->reg_date = date("Y-m-d H:i:s");
                if ($applicantTable->save($applicant)) {
                    // The $article entity contains the id now
                    $conn->commit();
                    echo json_encode(array("data"=>true,'msg'=>'등록이 완료되었습니다.'));exit;
                }
                else{
                    //오류
                    $conn->rollback();
                    echo json_encode(array("data"=>false,'msg'=>'등록에 실패하였습니다.'));exit;
                }
            }
            else{
                //오류
                $conn->rollback();
                echo json_encode(array("data"=>false,‘msg’=>'등록에 실패하였습니다.'));exit;
            }
        }
    }
}