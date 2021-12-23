<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ExhibitionFixture
 */
class ExhibitionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'exhibition';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 200, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '전시/행사 제목', 'precision' => null],
        'description' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '간단설명', 'precision' => null],
        'category' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '행사 분야', 'precision' => null],
        'type' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '행사 유형\\n', 'precision' => null],
        'detail_html' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '행사 상세
', 'precision' => null],
        'apply_sdate' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '모집 시작일시'],
        'apply_edate' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '모집 종료일시'],
        'sdate' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '행사 시작일'],
        'edate' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '행사 종료일\\\\\\\\n'],
        'image_path' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '이미지 경로', 'precision' => null],
        'image_name' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '이미지 파일 명', 'precision' => null],
        'private' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '비공개 여부
0: 공개
1: 비공개
', 'precision' => null, 'autoIncrement' => null],
        'auto_approval' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'name' => ['type' => 'string', 'length' => 45, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '담당자 이름', 'precision' => null],
        'tel' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '담당자 연락처', 'precision' => null],
        'email' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '담당자 이메일\\\\n', 'precision' => null],
        'require_name' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '이름 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_email' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '이메일 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_tel' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '전화번호 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_age' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '나이 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_group' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '소속 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_sex' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '성별 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'require_cert' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '본인인증 필요여부
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'email_notice' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '시작전 이메일 공지
0: 비활성
1: 활성', 'precision' => null, 'autoIncrement' => null],
        'additional' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '추가신청 사용
0: 미사용
1: 사용', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '2', 'comment' => ' 상태\\n1: 활성\\n2: 비활성 \\n4: 임시저장', 'precision' => null, 'autoIncrement' => null],
        'created' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => '최초 등록일시'],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => '수정일시'],
        'notice' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '탭에 있는 공지', 'precision' => null],
        'program' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '탭에있는 프로그램', 'precision' => null],
        'cost' => ['type' => 'string', 'length' => 16, 'null' => false, 'default' => 'free', 'collate' => 'utf8_general_ci', 'comment' => '행사 유/무료 여부 free: 무료 charged: 유료', 'precision' => null],
        '_indexes' => [
            'fk_exhibition_members_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_exhibition_members' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
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
                'title' => 'Lorem ipsum dolor sit amet',
                'description' => 'Lorem ipsum dolor sit amet',
                'category' => 'Lorem ipsum dolor sit amet',
                'type' => 'Lorem ipsum dolor sit amet',
                'detail_html' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'apply_sdate' => '2021-12-23 00:54:08',
                'apply_edate' => '2021-12-23 00:54:08',
                'sdate' => '2021-12-23 00:54:08',
                'edate' => '2021-12-23 00:54:08',
                'image_path' => 'Lorem ipsum dolor sit amet',
                'image_name' => 'Lorem ipsum dolor sit amet',
                'private' => 1,
                'auto_approval' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'tel' => 'Lorem ipsum do',
                'email' => 'Lorem ipsum dolor sit amet',
                'require_name' => 1,
                'require_email' => 1,
                'require_tel' => 1,
                'require_age' => 1,
                'require_group' => 1,
                'require_sex' => 1,
                'require_cert' => 1,
                'email_notice' => 1,
                'additional' => 1,
                'status' => 1,
                'created' => 1640220848,
                'modified' => 1640220848,
                'notice' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'program' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'cost' => 'Lorem ipsum do',
            ],
        ];
        parent::init();
    }
}
