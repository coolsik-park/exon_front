<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionSurveyQuestionFixture
 */
class ExhibitionSurveyQuestionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_survey_question';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'survey_type' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => 'N', 'collate' => 'utf8_general_ci', 'comment' => ' 설문방식
N:  일반설문
B:  사전설문', 'precision' => null],
        'question' => ['type' => 'string', 'length' => 2048, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'choice_type' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => 'S', 'collate' => 'utf8_general_ci', 'comment' => '답변 형태
‘C’ : 객관식
’S’: 주관식', 'precision' => null],
        'is_duplicate' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => 'N', 'collate' => 'utf8_general_ci', 'comment' => '답변 중복가능여부
‘Y’: 중복가능
’N’: 중복 불가능', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_survey_question_exhibition1_idx' => ['type' => 'index', 'columns' => ['exhibition_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_survey_question_exhibition1' => ['type' => 'foreign', 'columns' => ['exhibition_id'], 'references' => ['exhibition', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'exhibition_id' => 1,
                'survey_type' => 'Lo',
                'question' => 'Lorem ipsum dolor sit amet',
                'choice_type' => 'Lo',
                'is_duplicate' => 'Lo',
                'created' => '2021-07-10 17:07:09',
                'modified' => 1625904429,
            ],
        ];
        parent::init();
    }
}
