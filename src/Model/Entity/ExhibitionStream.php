<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionStream Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property int|null $pay_id
 * @property int|null $coupon_id
 * @property string $title
 * @property string|null $description
 * @property string $stream_key
 * @property int $time
 * @property int $people
 * @property int $amount
 * @property int $coupon_amount
 * @property string|null $url
 * @property string $ip
 * @property int $tab
 * @property \Cake\I18n\FrozenTime|null $live_started
 * @property int|null $live_duration
 * @property int $is_upload
 * @property int $vod_index
 * @property int $viewer
 * @property int $watched
 * @property int $liked
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 * @property \App\Model\Entity\Pay $pay
 * @property \App\Model\Entity\Coupon $coupon
 * @property \App\Model\Entity\ExhibitionStreamChatLog[] $exhibition_stream_chat_log
 * @property \App\Model\Entity\ExhibitionUser[] $exhibition_users
 */
class ExhibitionStream extends Entity
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
        'pay_id' => true,
        'coupon_id' => true,
        'title' => true,
        'description' => true,
        'stream_key' => true,
        'time' => true,
        'people' => true,
        'amount' => true,
        'coupon_amount' => true,
        'url' => true,
        'ip' => true,
        'tab' => true,
        'live_started' => true,
        'live_duration' => true,
        'is_upload' => true,
        'vod_index' => true,
        'viewer' => true,
        'watched' => true,
        'liked' => true,
        'created' => true,
        'modified' => true,
        'exhibition' => true,
        'pay' => true,
        'coupon' => true,
        'exhibition_stream_chat_log' => true,
        'exhibition_users' => true,
    ];
}
