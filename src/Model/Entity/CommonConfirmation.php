<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CommonConfirmation Entity
 *
 * @property int $id
 * @property string $confirmation_code
 * @property string $types
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $expired
 */
class CommonConfirmation extends Entity
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
        'confirmation_code' => true,
        'types' => true,
        'created' => true,
        'expired' => true,
    ];
}
