<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'name' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '이름', 'precision' => null],
        'hp' => ['type' => 'string', 'length' => 16, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'hp_cert' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '핸드폰 인증 여부
0: 미인증
1: 인증
', 'precision' => null, 'autoIncrement' => null],
        'birthday' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '생년월일\\n', 'precision' => null],
        'image_path' => ['type' => 'string', 'length' => 2048, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '첨부 파일 경로', 'precision' => null],
        'image_name' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'sex' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '성별
F
M
', 'precision' => null],
        'company' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '소속', 'precision' => null],
        'title' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '직함', 'precision' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '회원 상태
1: 활성
2: 비활성
4: 탈퇴 
', 'precision' => null, 'autoIncrement' => null],
        'refer' => ['type' => 'string', 'length' => 45, 'null' => false, 'default' => 'exon', 'collate' => 'utf8_general_ci', 'comment' => '회원 유형
 exon
 kakao
 naver', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => '가입일'],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => '최근 수정일'],
        'ip' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
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
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'hp' => 'Lorem ipsum do',
                'hp_cert' => 1,
                'birthday' => '2021-08-26',
                'image_path' => 'Lorem ipsum dolor sit amet',
                'image_name' => 'Lorem ipsum dolor sit amet',
                'sex' => 'L',
                'company' => 'Lorem ipsum dolor sit amet',
                'title' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'refer' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-08-26 09:54:56',
                'modified' => '2021-08-26 09:54:56',
                'ip' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
