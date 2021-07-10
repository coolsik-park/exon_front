<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Exhibition Entity
 *
 * @property int $id
 * @property int|null $users_id
 * @property string $title
 * @property string|null $description
 * @property string $category
 * @property string|null $type
 * @property string|null $detail_html
 * @property \Cake\I18n\FrozenTime|null $apply_sdate
 * @property \Cake\I18n\FrozenTime|null $apply_edate
 * @property \Cake\I18n\FrozenTime|null $sdate
 * @property \Cake\I18n\FrozenTime|null $edate
 * @property string|null $image_path
 * @property string|null $image_name
 * @property int $private
 * @property int $auto_approval
 * @property string $name
 * @property string $tel
 * @property string $email
 * @property int $require_name
 * @property int $require_email
 * @property int $require_tel
 * @property int $require_age
 * @property int $require_group
 * @property int $require_sex
 * @property int $require_cert
 * @property int $email_notice
 * @property int $additional
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User[] $users
 * @property \App\Model\Entity\Banner[] $banner
 * @property \App\Model\Entity\ExhibitionFile[] $exhibition_file
 * @property \App\Model\Entity\ExhibitionGroup[] $exhibition_group
 * @property \App\Model\Entity\ExhibitionSurvey[] $exhibition_survey
 */
class Exhibition extends Entity
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
        'users_id' => true,
        'title' => true,
        'description' => true,
        'category' => true,
        'type' => true,
        'detail_html' => true,
        'apply_sdate' => true,
        'apply_edate' => true,
        'sdate' => true,
        'edate' => true,
        'image_path' => true,
        'image_name' => true,
        'private' => true,
        'auto_approval' => true,
        'name' => true,
        'tel' => true,
        'email' => true,
        'require_name' => true,
        'require_email' => true,
        'require_tel' => true,
        'require_age' => true,
        'require_group' => true,
        'require_sex' => true,
        'require_cert' => true,
        'email_notice' => true,
        'additional' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'users' => true,
        'banner' => true,
        'exhibition_file' => true,
        'exhibition_group' => true,
        'exhibition_survey' => true,
    ];
}
