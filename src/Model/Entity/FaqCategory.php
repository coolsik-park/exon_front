<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * FaqCategory Entity
 *
 * @property int $id
 * @property int $managers_id
 * @property string $text
 * @property int|null $status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Manager $manager
 * @property \App\Model\Entity\UserQuestion[] $user_question
 */
class FaqCategory extends Entity
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
        'managers_id' => true,
        'text' => true,
        'status' => true,
        'created' => true,
        'manager' => true,
        'user_question' => true,
    ];
}
