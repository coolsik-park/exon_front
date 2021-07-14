<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionSurveyUsersAnswerFixture
 */
class ExhibitionSurveyUsersAnswerFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_survey_users_answer';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_survey_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'text' => ['type' => 'string', 'length' => 2048, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '질문 또는 주관식 또는 객관식 답변 내용', 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_survey_users_answer_exhibition_survey1_idx' => ['type' => 'index', 'columns' => ['exhibition_survey_id'], 'length' => []],
            'fk_exhibition_survey_users_answer_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_survey_users_answer_exhibition_survey1' => ['type' => 'foreign', 'columns' => ['exhibition_survey_id'], 'references' => ['exhibition_survey', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_survey_users_answer_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'exhibition_survey_id' => 1,
                'users_id' => 1,
                'text' => 'Lorem ipsum dolor sit amet',
                'parent_id' => 1,
                'created' => '2021-07-14 13:04:20',
                'modified' => 1626235460,
            ],
        ];
        parent::init();
    }
}
