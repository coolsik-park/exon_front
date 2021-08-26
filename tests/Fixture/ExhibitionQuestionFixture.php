<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionQuestionFixture
 */
class ExhibitionQuestionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_question';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '질문자 id
', 'precision' => null, 'autoIncrement' => null],
        'target_users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '질문받을 사용자 ID
(ID가 없을경우 전체에게 질문 또는 답변)
', 'precision' => null, 'autoIncrement' => null],
        'target_users_name' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '질문받은 사용자 명', 'precision' => null],
        'parent_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '답변일 경우 질문의 ID값 
', 'precision' => null, 'autoIncrement' => null],
        'contents' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '질문 또는 답변', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_question_exhibition_users1_idx' => ['type' => 'index', 'columns' => ['exhibition_users_id'], 'length' => []],
            'fk_exhibition_question_exhibition_users2_idx' => ['type' => 'index', 'columns' => ['target_users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_question_exhibition_users2' => ['type' => 'foreign', 'columns' => ['target_users_id'], 'references' => ['exhibition_users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_question_exhibition_users1' => ['type' => 'foreign', 'columns' => ['exhibition_users_id'], 'references' => ['exhibition_users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'target_users_id' => 1,
                'target_users_name' => 'Lorem ipsum dolor sit amet',
                'parent_id' => 1,
                'contents' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2021-08-26 05:08:43',
            ],
        ];
        parent::init();
    }
}
