<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\ORM\Locator\LocatorAwareTrait;

/**
 * Boards Controller
 *
 * @method \App\Model\Entity\Board[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BoardsController extends AppController
{
    public function userQuestionsByCategory($FaqCategoryId = null)
    {
        $userQuestions = $this->getTableLocator()->get('UserQuestion');
        if($FaqCategoryId == null) {
            $userQuestions = $userQuestions->find()->select(['id', 'title'])->order(['created' => 'DESC']);
        } else {
            $userQuestions = $userQuestions->find()->select(['id', 'title'])->where(['faq_category_id' => $FaqCategoryId])->order(['created' => 'DESC']);
        }
        $userQuestions = $this->paginate($userQuestions);
        $this->set(compact('userQuestions'));
    }
}
