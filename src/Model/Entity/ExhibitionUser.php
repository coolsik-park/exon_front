<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionUser Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property int $exhibition_group_id
 * @property int|null $users_id
 * @property string|null $users_email
 * @property string $users_name
 * @property string|null $users_hp
 * @property string|null $users_group
 * @property string|null $users_sex
 * @property int|null $pay_id
 * @property int|null $pay_amount
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 * @property \App\Model\Entity\ExhibitionGroup $exhibition_group
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Pay $pay
 */
class ExhibitionUser extends Entity
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
        'exhibition_id' => true,
        'exhibition_group_id' => true,
        'users_id' => true,
        'users_email' => true,
        'users_name' => true,
        'users_hp' => true,
        'users_group' => true,
        'users_sex' => true,
        'pay_id' => true,
        'pay_amount' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'exhibition' => true,
        'exhibition_group' => true,
        'user' => true,
        'pay' => true,
    ];
}
