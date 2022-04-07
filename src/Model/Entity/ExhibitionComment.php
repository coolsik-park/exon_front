<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionComment Entity
 *
 * @property int $id
 * @property int $exhibition_stream_id
 * @property int $users_id
 * @property int|null $parent_id
 * @property string $message
 * @property int|null $liked
 * @property string $user_name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ExhibitionStream $exhibition_stream
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ParentExhibitionComment $parent_exhibition_comment
 * @property \App\Model\Entity\ChildExhibitionComment[] $child_exhibition_comment
 */
class ExhibitionComment extends Entity
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
        'exhibition_stream_id' => true,
        'users_id' => true,
        'parent_id' => true,
        'message' => true,
        'liked' => true,
        'user_name' => true,
        'created' => true,
        'modified' => true,
        'exhibition_stream' => true,
        'user' => true,
        'parent_exhibition_comment' => true,
        'child_exhibition_comment' => true,
    ];
}
