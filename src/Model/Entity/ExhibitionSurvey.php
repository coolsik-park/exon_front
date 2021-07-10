<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExhibitionSurvey Entity
 *
 * @property int $id
 * @property int $exhibition_id
 * @property string|null $survey_type
 * @property int|null $parent_id
 * @property string $text
 * @property string|null $is_duplicate
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Exhibition $exhibition
 * @property \App\Model\Entity\ExhibitionSurvey $parent_exhibition_survey
 * @property \App\Model\Entity\ExhibitionSurvey[] $child_exhibition_survey
 * @property \App\Model\Entity\ExhibitionSurveyUsersAnswer[] $exhibition_survey_users_answer
 */
class ExhibitionSurvey extends Entity
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
        'survey_type' => true,
        'parent_id' => true,
        'text' => true,
        'is_duplicate' => true,
        'created' => true,
        'modified' => true,
        'exhibition' => true,
        'parent_exhibition_survey' => true,
        'child_exhibition_survey' => true,
        'exhibition_survey_users_answer' => true,
    ];
}
