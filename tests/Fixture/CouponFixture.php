<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CouponFixture
 */
class CouponFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'coupon';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'product_type' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => 'S', 'collate' => 'utf8_general_ci', 'comment' => '사용 가능한 상품 유형
E: 행사
S: 스트림
', 'precision' => null],
        'code' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '쿠폰코드', 'precision' => null],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '쿠폰금액
', 'precision' => null, 'autoIncrement' => null],
        'sdate' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '쿠폰 시작일', 'precision' => null],
        'edate' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '쿠폰 종료일', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '쿠폰상태
1: 발행
2: 사용자 할당
4: 사용완료 ', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'fk_coupon_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_coupon_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'users_id' => 1,
                'product_type' => 'Lo',
                'code' => 'Lorem ipsum dolor sit amet',
                'amount' => 1,
                'sdate' => 'Lorem ',
                'edate' => 'Lorem ',
                'status' => 1,
                'created' => '2021-07-16 13:52:14',
                'modified' => 1626411134,
            ],
        ];
        parent::init();
    }
}
