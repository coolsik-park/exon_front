<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionStreamFixture
 */
class ExhibitionStreamFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition_stream';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'pay_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'coupon_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'time' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '시간', 'precision' => null, 'autoIncrement' => null],
        'people' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '10', 'comment' => '연결허용 인원', 'precision' => null, 'autoIncrement' => null],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '금액', 'precision' => null, 'autoIncrement' => null],
        'coupon_amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '쿠폰금액', 'precision' => null, 'autoIncrement' => null],
        'url' => ['type' => 'string', 'length' => 2048, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '스트림 url', 'precision' => null],
        'ip' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'CURRENT_TIMESTAMP', 'comment' => ''],
        '_indexes' => [
            'fk_exhibition_stream_exhibition1_idx' => ['type' => 'index', 'columns' => ['exhibition_id'], 'length' => []],
            'fk_exhibition_stream_pay1_idx' => ['type' => 'index', 'columns' => ['pay_id'], 'length' => []],
            'fk_exhibition_stream_coupon1_idx' => ['type' => 'index', 'columns' => ['coupon_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_stream_coupon1' => ['type' => 'foreign', 'columns' => ['coupon_id'], 'references' => ['coupon', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_stream_exhibition1' => ['type' => 'foreign', 'columns' => ['exhibition_id'], 'references' => ['exhibition', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_exhibition_stream_pay1' => ['type' => 'foreign', 'columns' => ['pay_id'], 'references' => ['pay', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'pay_id' => 1,
                'coupon_id' => 1,
                'time' => 1,
                'people' => 1,
                'amount' => 1,
                'coupon_amount' => 1,
                'url' => 'Lorem ipsum dolor sit amet',
                'ip' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-07-14 13:04:20',
                'modified' => 1626235460,
            ],
        ];
        parent::init();
    }
}