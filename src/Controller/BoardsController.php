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
    public function faqsByCategory($FaqCategoryId = null)
    {
        $faqs = $this->getTableLocator()->get('Faq');
        if($FaqCategoryId == null) {
            $faqs = $faqs->find()->select(['id', 'title']);
        } else {
            $faqs = $faqs->find()->select(['id', 'title'])->where(['faq_category_id' => $FaqCategoryId]);
        }
        $faqs = $this->paginate($faqs);
        $this->set(compact('faqs'));
    }
}
