<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pay Entity
 *
 * @property int $id
 * @property string $product_type
 *
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
        'exhibition_stream' => true,
        'exhibition_users' => true,
    ];
}
