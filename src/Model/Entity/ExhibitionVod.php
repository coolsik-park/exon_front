<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionVod Entity
 *
 * @property int $id
 * @property string $type
 * @property int $exhibition_id
 * @property string $title
 * @property int|null $parent_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ExhibitionStream $exhibition_stream
 * @property \App\Model\Entity\ExhibitionVod $parent_exhibition_vod
 * @property \App\Model\Entity\ExhibitionVod[] $child_exhibition_vod
 */
class ExhibitionVod extends Entity
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
        'type' => true,
        'exhibition_id' => true,
        'title' => true,
        'parent_id' => true,
        'created' => true,
        'modified' => true,
        'exhibition_stream' => true,
        'parent_exhibition_vod' => true,
        'child_exhibition_vod' => true,
    ];
}
