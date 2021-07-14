<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Coupon Entity
 *
 * @property int $id
 * @property int|null $users_id
 * @property string $product_type
 * @property string $code
 * @property int $amount
 * @property string $sdate
 * @property string $edate
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ExhibitionStream[] $exhibition_stream
 */
class Coupon extends Entity
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
        'product_type' => true,
        'code' => true,
        'amount' => true,
        'sdate' => true,
        'edate' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'exhibition_stream' => true,
    ];
}
