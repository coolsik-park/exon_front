<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionVod Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string $title
 * @property string|null $description
 * @property int|null $file_size
 * @property int|null $parent_id
 * @property int|null $duration
 * @property int|null $is_paid
 * @property int $viewer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Exhibition $exhibition
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
        'exhibition_id' => true,
        'title' => true,
        'description' => true,
        'file_size' => true,
        'parent_id' => true,
        'duration' => true,
        'is_paid' => true,
        'viewer' => true,
        'created' => true,
        'modified' => true,
        'exhibition' => true,
        'parent_exhibition_vod' => true,
        'child_exhibition_vod' => true,
    ];
}
