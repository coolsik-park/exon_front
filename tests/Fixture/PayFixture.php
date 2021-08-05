<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PayFixture
 */
class PayFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'pay';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'product_type' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => 'E', 'collate' => 'utf8_general_ci', 'comment' => '상품 타입
E: 행사결제
S: 스트림 결제', 'precision' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'merchant_uid' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '엑손에서 관리하는 결제 uniq ID', 'precision' => null],
        'pg_tid' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'PG사 거래번호', 'precision' => null],
        'pay_method' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '결제수단 \\n collect (착불)\\n card (신용카드)\\n trans (실시간계좌이체)\\n vbank (가상계좌)\\n phone (휴대폰 소액결제)\\n samsung (삼성페이 / 이니시스전용)\\n kpay (kPay 앱 직접호출 / 이니시스 전용)\\n cultureland ( 문화상품권 / 이니시스 전용)\\n smartculture ( 스마트 문화상품권 / 이니시스 전용)\\n happymoney ( 해피머니 / 이니시스 전용) \\n late (후불정산 ) ', 'precision' => null],
        'amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '전체금액', 'precision' => null, 'autoIncrement' => null],
        'pay_amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '실 결제금액 \\n', 'precision' => null, 'autoIncrement' => null],
        'coupon_amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '쿠폰 할인금액', 'precision' => null, 'autoIncrement' => null],
        'status' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '1', 'comment' => '결제 (주문) 상태\\n
0: 비정상
1 : 결제대기
2 : 결제(주문)완료 
4 : 결제(주문) 취소 요청
8 : 결제(주문) 취소 완료
16 : 결제(주문) 실패 ', 'precision' => null, 'autoIncrement' => null],
        'receipt_url' => ['type' => 'string', 'length' => 1024, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '매출전표(영수증) url', 'precision' => null],
        'pay_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '결제승인일시'],
        'ip' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => '등록일시'],
        'modified' => ['type' => 'timestamp', 'length' => null, 'precision' => null, 'null' => false, 'default' => 'current_timestamp()', 'comment' => ''],
        'cancel_amount' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'cancel_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '결제취소 일시'],
        'cancel_reason' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '결제취소 사유', 'precision' => null],
        'fail_date' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => true, 'default' => null, 'comment' => '결제실패 일시'],
        'fail_reason' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '결제실패 사유', 'precision' => null],
        'managers_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'manager_ip' => ['type' => 'string', 'length' => 16, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '강제 상태 변경시 관리자 IP 기록', 'precision' => null],
        'imp_uid' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '아임포트 고유번호', 'precision' => null],
        '_indexes' => [
            'fk_pay_users1_idx' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
            'fk_pay_managers1_idx' => ['type' => 'index', 'columns' => ['managers_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'fk_pay_users1' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'fk_pay_managers1' => ['type' => 'foreign', 'columns' => ['managers_id'], 'references' => ['managers', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
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
                'product_type' => 'Lo',
                'users_id' => 1,
                'merchant_uid' => 'Lorem ipsum dolor sit amet',
                'pg_tid' => 'Lorem ipsum dolor sit amet',
                'pay_method' => 'Lorem ipsum do',
                'amount' => 1,
                'pay_amount' => 1,
                'coupon_amount' => 1,
                'status' => 1,
                'receipt_url' => 'Lorem ipsum dolor sit amet',
                'pay_date' => '2021-08-05 15:42:11',
                'ip' => 'Lorem ipsum do',
                'created' => '2021-08-05 15:42:11',
                'modified' => 1628145731,
                'cancel_amount' => 1,
                'cancel_date' => '2021-08-05 15:42:11',
                'cancel_reason' => 'Lorem ipsum dolor sit amet',
                'fail_date' => '2021-08-05 15:42:11',
                'fail_reason' => 'Lorem ipsum dolor sit amet',
                'managers_id' => 1,
                'manager_ip' => 'Lorem ipsum do',
                'imp_uid' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
