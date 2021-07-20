<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserQuestionFile Entity
 *
 * @property int $id
 * @property int $user_question_id
 * @property string $file_path
 * @property string|null $file_name
 * @property string|null $type
 * @property \Cake\I18n\FrozenTime $created
 * @property string|null $file_type
 *
 * @property \App\Model\Entity\UserQuestion $user_question
 */
class UserQuestionFile extends Entity
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
        'user_question_id' => true,
        'file_path' => true,
        'file_name' => true,
        'type' => true,
        'created' => true,
        'file_type' => true,
        'user_question' => true,
    ];
}
