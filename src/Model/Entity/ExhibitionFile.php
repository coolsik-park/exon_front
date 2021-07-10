<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionFile Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string $name
 * @property string $file_path
 * @property string $file_name
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 */
class ExhibitionFile extends Entity
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
        'name' => true,
        'file_path' => true,
        'file_name' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'exhibition' => true,
    ];
}
