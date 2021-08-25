<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionQuestion Entity
 *
 * @property int $id
 * @property int $exhibition_users_id
 * @property int|null $target_users_id
 * @property string|null $target_users_name
 * @property int|null $parent_id
 * @property string $contents
 * @property string $created
 *
 * @property \App\Model\Entity\ExhibitionUser $exhibition_user
 * @property \App\Model\Entity\ParentExhibitionQuestion $parent_exhibition_question
 * @property \App\Model\Entity\ChildExhibitionQuestion[] $child_exhibition_question
 */
class ExhibitionQuestion extends Entity
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
        'exhibition_users_id' => true,
        'target_users_id' => true,
        'target_users_name' => true,
        'parent_id' => true,
        'contents' => true,
        'created' => true,
        'exhibition_user' => true,
        'parent_exhibition_question' => true,
        'child_exhibition_question' => true,
    ];
}
