<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionSpeaker Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string|null $name
 * @property string|null $image_path
 * @property string|null $image_name
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 */
class ExhibitionSpeaker extends Entity
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
        'image_path' => true,
        'image_name' => true,
        'created' => true,
        'exhibition' => true,
    ];
}
