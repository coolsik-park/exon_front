<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Banner Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string $type
 * @property string $sdate
 * @property string $edate
 * @property string $img_path
 * @property string $img_name
 * @property int $sort
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 */
class Banner extends Entity
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
        'type' => true,
        'sdate' => true,
        'edate' => true,
        'img_path' => true,
        'img_name' => true,
        'sort' => true,
        'status' => true,
        'created' => true,
        'exhibition' => true,
    ];
}
