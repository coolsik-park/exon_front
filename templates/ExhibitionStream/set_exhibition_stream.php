<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream $exhibitionStream
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Stream'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionStream form content">
            <?= $this->Form->create($exhibitionStream, ['url' => ['controller' => 'ExhibitionStream', 'action' => 'setTitleDescription', $exhibitionStream->exhibition_id]]) ?>
            <fieldset>
                <legend><?= __('Add Exhibition Stream') ?></legend>
                <?php
                    echo $this->Form->control('title', ['label' => '방송 제목']);
                    echo $this->Form->control('description', ['label' => '방송 설명']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('저장')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="column-responsive column-80">
        <div class="exhibitionStream form content">
            <!-- <?= $this->Form->postButton('결제', ['controller' => 'Pay', 'action' => 'importPay', $exhibitionStream->amount, 'S']) ?> -->
            <?= $this->Form->create($exhibitionStream) ?>
            <fieldset>
                <legend><?= __('Add Exhibition Stream') ?></legend>
                <button id="check_module" type="button">결제</button>
                <?php
                    echo $this->Form->control('coupon_code', ['label' => '프로모션 키']);
                    echo $this->Form->button(__('Confirm'));
                    echo $this->Form->control('time', ['type' => 'select', 'label' => '시간', 'options' => [18000 => 'Half day', 36000 => 'All day']]);
                    echo $this->Form->control('people', ['type' => 'select', 'label' => '인원수', 'options' => [
                        50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300', 350 => '350', 400 => '400', 450 => '450', 500 => '500+']]);
                    echo $this->Form->control('amount', ['label' => '금액']);
                    echo $this->Form->control('stream_key', ['label' => '스트림 키', 'required' => 'false']);
                    echo $this->Form->control('url');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    $("#check_module").click(function () {
        var IMP = window.IMP; 
        IMP.init('imp43823679');
        IMP.request_pay({
            pg : 'inicis',
            pay_method : 'card',
            merchant_uid : 'merchant_' + new Date().getTime(),
            name : '주문명:결제테스트',
            amount : 1000,
            buyer_email : '',
            buyer_name : '구매자이름',
            buyer_tel : '010-1234-5678',
            buyer_addr : '서울특별시 강남구 삼성동',
            buyer_postcode : '123-456'
        }, function(rsp) {
            if ( rsp.success ) {
                jQuery.ajax({
                    url: "http://121.126.223.225:8765/pay/import-pay", 
                    method: 'POST',
                    type: 'json',
                    data: {
                        imp_uid: rsp.imp_uid,
                        merchant_uid: rsp.merchant_uid
                    }
                }).done(function(data) {
                    if (data.status == 'success') { 
                        var msg = '결제가 완료되었습니다.';
                        msg += '\n고유ID : ' + rsp.imp_uid;
                        msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                        msg += '\n결제 금액 : ' + rsp.paid_amount;
                        msg += '\n카드 승인번호 : ' + rsp.apply_num;

                        alert(msg);
                    } 
                }).fail(function(xhr, status, errorThrown) {
                    alert(xhr + ' ' + status + ' ' + errorThrown); 
                });
                
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;

                alert(msg);
            }
        });
    });
</script>