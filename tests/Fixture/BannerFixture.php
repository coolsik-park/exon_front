<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BannerFixture
 */
class BannerFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'banner';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'exhibition_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'type' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '배너 노출 유형\\banner’\\n’hot’', 'precision' => null],
        'sdate' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '노출 시작 일', 'precision' => null],
        'edate' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '노출 종료일', 'precision' => null],
        'img_path' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'img_name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sort' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '노출 순서', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '상태
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        '_indexes' => [
            'fk_banner_exhibition1_idx' => ['type' => 'index', 'columns' => ['exhibition_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_banner_exhibition1' => ['type' => 'foreign', 'columns' => ['exhibition_id'], 'references' => ['exhibition', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'type' => 'Lorem ',
                'sdate' => 'Lorem ',
                'edate' => 'Lorem ',
                'img_path' => 'Lorem ipsum dolor sit amet',
                'img_name' => 'Lorem ipsum dolor sit amet',
                'sort' => 1,
                'status' => 1,
                'created' => '2021-07-16 13:52:11',
            ],
        ];
        parent::init();
    }
}
