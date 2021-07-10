<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionUsersSurveyAnswerFixture
 */
class ExhibitionUsersSurveyAnswerFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_users_survey_answer';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exhibition_survey_question_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exhibition_survey_question' => ['type' => 'string', 'length' => 2048, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'exhibition_survey_choice_binary_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '객관식인 경우 선택한 (이진수)값들의 합
 ', 'precision' => null, 'autoIncrement' => null],
        'exhibition_survey_answer' => ['type' => 'string', 'length' => 2048, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '주관식일경우 사용자가 답변한 내용', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_users_survey_answer_exhibition_users1_idx' => ['type' => 'index', 'columns' => ['exhibition_users_id'], 'length' => []],
            'fk_exhibition_users_survey_answer_exhibition_survey_questio_idx' => ['type' => 'index', 'columns' => ['exhibition_survey_question_id'], 'length' => []],
            'fk_exhibition_users_survey_answer_exhibition_survey_choice1_idx' => ['type' => 'index', 'columns' => ['exhibition_survey_choice_binary_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'uk_exhibition_users' => ['type' => 'unique', 'columns' => ['exhibition_users_id', 'exhibition_survey_question_id'], 'length' => []],
            'fk_exhibition_users_survey_answer_exhibition_survey_choice1' => ['type' => 'foreign', 'columns' => ['exhibition_survey_choice_binary_id'], 'references' => ['exhibition_survey_choice', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_users_survey_answer_exhibition_survey_question1' => ['type' => 'foreign', 'columns' => ['exhibition_survey_question_id'], 'references' => ['exhibition_survey_question', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_users_survey_answer_exhibition_users1' => ['type' => 'foreign', 'columns' => ['exhibition_users_id'], 'references' => ['exhibition_users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'exhibition_users_id' => 1,
                'exhibition_survey_question_id' => 1,
                'exhibition_survey_question' => 'Lorem ipsum dolor sit amet',
                'exhibition_survey_choice_binary_id' => 1,
                'exhibition_survey_answer' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-07-10 17:07:09',
                'modified' => 1625904429,
            ],
        ];
        parent::init();
    }
}
