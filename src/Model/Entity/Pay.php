<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pay Entity
 *
 * @property int $id
 * @property string $product_type
 * @property int|null $users_id
 * @property string|null $merchant_uid
 * @property string|null $pg_tid
 * @property string|null $pay_method
 * @property int $amount
 * @property int $pay_amount
 * @property int $coupon_amount
 * @property int $status
 * @property string|null $receipt_url
 * @property \Cake\I18n\FrozenTime|null $pay_date
 * @property string|null $ip
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $cancel_amount
 * @property \Cake\I18n\FrozenTime|null $cancel_date
 * @property string|null $cancel_reason
 * @property \Cake\I18n\FrozenTime|null $fail_date
 * @property string|null $fail_reason
 * @property int|null $managers_id
 * @property string|null $manager_ip
 * @property string|null $imp_uid
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Manager $manager
 * @property \App\Model\Entity\ExhibitionStream[] $exhibition_stream
 * @property \App\Model\Entity\ExhibitionUser[] $exhibition_users
 */
class Pay extends Entity
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
        'product_type' => true,
        'users_id' => true,
        'merchant_uid' => true,
        'pg_tid' => true,
        'pay_method' => true,
        'amount' => true,
        'pay_amount' => true,
        'coupon_amount' => true,
        'status' => true,
        'receipt_url' => true,
        'pay_date' => true,
        'ip' => true,
        'created' => true,
        'modified' => true,
        'cancel_amount' => true,
        'cancel_date' => true,
        'cancel_reason' => true,
        'fail_date' => true,
        'fail_reason' => true,
        'managers_id' => true,
        'manager_ip' => true,
        'imp_uid' => true,
        'user' => true,
        'manager' => true,
        'exhibition_stream' => true,
        'exhibition_users' => true,
    ];
}
