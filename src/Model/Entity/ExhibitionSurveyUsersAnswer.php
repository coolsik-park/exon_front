<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionSurveyUsersAnswer Entity
 *
 * @property int $id
 * @property int $exhibition_survey_id
 * @property int $users_id
 * @property string $text
 * @property int|null $parent_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\ExhibitionSurvey $exhibition_survey
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ExhibitionSurveyUsersAnswer $parent_exhibition_survey_users_answer
 * @property \App\Model\Entity\ExhibitionSurveyUsersAnswer[] $child_exhibition_survey_users_answer
 */
class ExhibitionSurveyUsersAnswer extends Entity
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
        'exhibition_survey_id' => true,
        'users_id' => true,
        'text' => true,
        'parent_id' => true,
        'created' => true,
        'modified' => true,
        'exhibition_survey' => true,
        'user' => true,
        'parent_exhibition_survey_users_answer' => true,
        'child_exhibition_survey_users_answer' => true,
    ];
}
