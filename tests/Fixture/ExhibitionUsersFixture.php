<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionUsersFixture
 */
class ExhibitionUsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'exhibition_group_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '신청한 그룹 ID
', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'users_name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'users_hp' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'users_group' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'users_sex' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '성별
F/M', 'precision' => null],
        'pay_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pay_amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '상태
1: 신청전
2: 신청완료
4: 취소(환불)
', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => true, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_users_exhibition1_idx' => ['type' => 'index', 'columns' => ['exhibition_id'], 'length' => []],
            'fk_exhibition_users_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_exhibition_users_exhibition_group1_idx' => ['type' => 'index', 'columns' => ['exhibition_group_id'], 'length' => []],
            'fk_exhibition_users_pay1_idx' => ['type' => 'index', 'columns' => ['pay_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_users_exhibition1' => ['type' => 'foreign', 'columns' => ['exhibition_id'], 'references' => ['exhibition', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_users_exhibition_group1' => ['type' => 'foreign', 'columns' => ['exhibition_group_id'], 'references' => ['exhibition_group', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_users_pay1' => ['type' => 'foreign', 'columns' => ['pay_id'], 'references' => ['pay', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_users_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'exhibition_group_id' => 1,
                'users_id' => 1,
                'users_email' => 'Lorem ipsum dolor sit amet',
                'users_name' => 'Lorem ipsum dolor sit amet',
                'users_hp' => 'Lorem ipsum do',
                'users_group' => 'Lorem ipsum dolor sit amet',
                'users_sex' => 'L',
                'pay_id' => 1,
                'pay_amount' => 1,
                'status' => 1,
                'created' => '2021-07-10 19:04:46',
                'modified' => 1625911486,
            ],
        ];
        parent::init();
    }
}
