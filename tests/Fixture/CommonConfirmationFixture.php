<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CommonConfirmationFixture
 */
class CommonConfirmationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'common_confirmation';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'confirmation_code' => ['type' => 'string', 'length' => 6, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '인증코드 번호', 'precision' => null],
        'types' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '인증 유형', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        'expired' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => '(current_timestamp() + interval 3 minute)', 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'confirmation_code' => 'Lore',
                'types' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-07-27 14:27:00',
                'expired' => '2021-07-27 14:27:00',
            ],
        ];
        parent::init();
    }
}
