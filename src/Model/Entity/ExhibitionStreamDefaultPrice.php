<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionStreamDefaultPrice Entity
 *
 * @property int $id
 * @property int|null $people
 * @property int|null $halfday_price
 * @property int|null $allday_price
 * @property \Cake\I18n\FrozenTime $create
 * @property \Cake\I18n\FrozenTime|null $modified
 */
class ExhibitionStreamDefaultPrice extends Entity
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
        'people' => true,
        'halfday_price' => true,
        'allday_price' => true,
        'create' => true,
        'modified' => true,
    ];
}
