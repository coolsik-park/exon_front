<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string|null $password
 * @property string $name
 * @property string|null $hp
 * @property int $hp_cert
 * @property \Cake\I18n\FrozenDate|null $birthday
 * @property string|null $image_path
 * @property string|null $image_name
 * @property int $email_cert
 * @property string|null $sex
 * @property string|null $company
 * @property string|null $title
 * @property int $status
 * @property string $refer
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property string|null $ip
 * @property string|null $social_id
 * @property int|null $is_logged
 *
 * @property \App\Model\Entity\Exhibition[] $exhibition
 */
class User extends Entity
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
        'email' => true,
        'password' => true,
        'name' => true,
        'hp' => true,
        'hp_cert' => true,
        'birthday' => true,
        'image_path' => true,
        'image_name' => true,
        'email_cert' => true,
        'sex' => true,
        'company' => true,
        'title' => true,
        'status' => true,
        'refer' => true,
        'created' => true,
        'modified' => true,
        'ip' => true,
        'social_id' => true,
        'is_logged' => true,
        'exhibition' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
}
