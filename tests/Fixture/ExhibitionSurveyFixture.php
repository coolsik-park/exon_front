<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionSurveyFixture
 */
class ExhibitionSurveyFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_survey';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'survey_type' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => 'N', 'collate' => 'utf8_general_ci', 'comment' => ' 설문방식\\\\nN:  일반설문\\\\nB:  사전설문', 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '객관식 보기일 경우 부모 질문 따라가기', 'precision' => null, 'autoIncrement' => null],
        'text' => ['type' => 'string', 'length' => 2048, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '내용', 'precision' => null],
        'is_duplicate' => ['type' => 'string', 'length' => 2, 'null' => true, 'default' => 'N', 'collate' => 'utf8_general_ci', 'comment' => '답변 중복가능여부\\\\n‘Y’: 중복가능\\\\n’N’: 중복 불가능', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_survey_exhibition1_idx' => ['type' => 'index', 'columns' => ['exhibition_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_survey_exhibition1' => ['type' => 'foreign', 'columns' => ['exhibition_id'], 'references' => ['exhibition', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'parent_id' => 1,
                'text' => 'Lorem ipsum dolor sit amet',
                'is_duplicate' => 'Lo',
                'created' => '2021-07-16 13:52:20',
                'modified' => 1626411140,
            ],
        ];
        parent::init();
    }
}
