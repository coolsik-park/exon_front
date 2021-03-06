<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionVodViewer Entity
 *
 * @property int $id
 * @property int|null $exhibition_id
 * @property int $exhibition_vod_id
 * @property int $user_id
 * @property int|null $watching_duration
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ExhibitionVod $exhibition_vod
 * @property \App\Model\Entity\User $user
 */
class ExhibitionVodViewer extends Entity
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
        'exhibition_vod_id' => true,
        'user_id' => true,
        'watching_duration' => true,
        'created' => true,
        'modified' => true,
        'exhibition_vod' => true,
        'user' => true,
    ];
}
