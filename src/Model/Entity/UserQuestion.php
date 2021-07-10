<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserQuestion Entity
 *
 * @property int $id
 * @property int|null $users_id
 * @property string|null $users_name
 * @property int|null $users_hp
 * @property string|null $users_email
 * @property string $question
 * @property string|null $answer
 * @property string $ip
 * @property int $faq_category_id
 * @property int $managers_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\FaqCategory $faq_category
 * @property \App\Model\Entity\Manager $manager
 * @property \App\Model\Entity\UserQuestionFile[] $user_question_files
 */
class UserQuestion extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'users_id' => true,
        'users_name' => true,
        'users_hp' => true,
        'users_email' => true,
        'question' => true,
        'answer' => true,
        'ip' => true,
        'faq_category_id' => true,
        'managers_id' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'faq_category' => true,
        'manager' => true,
        'user_question_files' => true,
    ];
}
