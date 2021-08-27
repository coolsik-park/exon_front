<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream $exhibitionStream
 */
?>
<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $exhibitionStream->exhibition_id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $exhibitionStream->exhibition_id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $exhibitionStream->exhibition_id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $exhibitionStream->exhibition_id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'ExhibitionStatisticsApply', $exhibitionStream->exhibition_id, 'class' => 'side-nav-item']) ?>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Stream'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column-responsive column-80">
        <div class="exhibitionStream form content">
            <?= $this->Form->create($exhibitionStream) ?>
            <fieldset>
                <legend><?= __('Add Exhibition Stream') ?></legend>
                <button id="check_module" type="button">결제</button>
                <?php
                    echo $this->Form->control('title', ['label' => '방송 제목']);
                    echo $this->Form->control('description', ['label' => '방송 설명']);
                    echo $this->Form->control('time', ['type' => 'select', 'label' => '시간', 'options' => [18000 => 'Half day', 36000 => 'All day']]);
                    echo $this->Form->control('people', ['type' => 'select', 'label' => '인원수', 'options' => [
                        50 => '50', 100 => '100', 150 => '150', 200 => '200', 250 => '250', 300 => '300', 350 => '350', 400 => '400', 450 => '450', 500 => '500+']]);
                    echo $this->Form->control('amount', ['label' => '금액']);
                    echo $this->Form->control('stream_key', ['label' => '스트림 키']);
                    echo $this->Form->control('url');
                    echo $this->Form->control('tab', ['type' => 'hidden']);
                    echo $this->Form->control('coupon_amount', ['type' => 'hidden', 'id' => 'coupon']);
                    echo $this->Form->control('paid', ['type' => 'hidden', 'value' => 0]);
                    echo $this->Form->control('id', ['type' => 'hidden']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
    <div class="column-responsive column-80">
        <div class="exhibitionStream form content">
            <fieldset>
                <legend><?= __('Set Exhibition Stream Tab') ?></legend>
                <?php
                    $i = 9;
                    foreach ($tabs as $tab) {
                        echo $this->Form->button($tab->title, ['id' => 'tab' . $i, 'type' => 'button']);
                        echo $this->Form->control($tab->title, ['id' => 'tab' . $i, 'type' => 'hidden']);
                        $i--;
                    }
                ?>
            </fieldset>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    $("#check_module").click(function () {
        var IMP = window.IMP; 
        IMP.init('imp43823679'); //아임포트 id -> 추후 교체
        IMP.request_pay({
            pg : 'inicis',
            pay_method : 'card',
            merchant_uid : 'merchant_' + new Date().getTime(),
            name : '주문명:결제테스트',
            amount : 1000, //$('input#amount').val()
            //세션 유저정보에서 가져오기
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
                        merchant_uid: rsp.merchant_uid,
                        pay_method: rsp.pay_method,
                        paid_amount: rsp.paid_amount,
                        coupon_amount: $('#coupon').val(),
                        receipt_url: rsp.receipt_url,
                        paid_at: rsp.paid_at,
                        pg_tid: rsp.pg_tid
                    }
                }).done(function(data) {
                    if (data.status == 'success') { 
                        var msg = '결제가 완료되었습니다.';
                        msg += '\n고유ID : ' + rsp.imp_uid;
                        msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                        msg += '\n결제 금액 : ' + rsp.paid_amount;
                        msg += '\n카드 승인번호 : ' + rsp.apply_num; 

                        alert(msg);

                        $('input#paid').val(1);
                        $('input#id').val(data.pay_id);
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
<script>
    $("#people").change(function () {
        amount = 0;
        time = 0;

        switch($("#people").val()) {
            case "50" : amount = 200000; break;
            case "100" : amount = 400000; break;
            case "150" : amount = 600000; break;
            case "200" : amount = 800000; break;
            case "250" : amount = 1000000; break;
            case "300" : amount = 1200000; break;
            case "350" : amount = 1400000; break;
            case "400" : amount = 1600000; break;
            case "450" : amount = 1800000; break;
            case "500" : amount = 2000000; break;
        }

        switch($("#time").val()) {
            case "18000" : time = 1; break;
            case "36000" : time = 2; break;
        }

        $("#amount").val(amount*time);
    });

    $("#time").change(function () {
        amount = 0;
        time = 0;

        switch($("#people").val()) {
            case "50" : amount = 200000; break;
            case "100" : amount = 400000; break;
            case "150" : amount = 600000; break;
            case "200" : amount = 800000; break;
            case "250" : amount = 1000000; break;
            case "300" : amount = 1200000; break;
            case "350" : amount = 1400000; break;
            case "400" : amount = 1600000; break;
            case "450" : amount = 1800000; break;
            case "500" : amount = 2000000; break;
        }

        switch($("#time").val()) {
            case "18000" : time = 1; break;
            case "36000" : time = 2; break;
        }

        $("#amount").val(amount*time);
    });
</script>
<script>
    var dec = $('#tab').val();
    dec = parseInt(dec);
    var bin = dec.toString(2);
    if (bin.length < 10) {
        var zero = '';
        for (i=0; i<10-bin.length; i++) {
            zero += '0';
        }
        bin = zero+bin;
    }
    for (i=0; i<bin.length; i++) {
        var result = bin.substring(i,i+1);
        if (parseInt(result) == 1) {
            $("input#tab" + i).val(1);
            $("button#tab" + i).css("background-color", "blue"); 
        }
    }

    $("button#tab0").click(function () {
        if ($("input#tab0").val() == 0) {
            $("input#tab0").val(1);
            $("button#tab0").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 512);
        } else {
            $("input#tab0").val(0);
            $("button#tab0").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 512);
        }
    });

    $("button#tab1").click(function () {
        if ($("input#tab1").val() == 0) {
            $("input#tab1").val(1);
            $("button#tab1").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 256);
        } else {
            $("input#tab1").val(0);
            $("button#tab1").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 256);
        }
    });

    $("button#tab2").click(function () {
        if ($("input#tab2").val() == 0) {
            $("input#tab2").val(1);
            $("button#tab2").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 128);
        } else {
            $("input#tab2").val(0);
            $("button#tab2").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 128);
        }
    });

    $("button#tab3").click(function () {
        if ($("input#tab3").val() == 0) {
            $("input#tab3").val(1);
            $("button#tab3").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 64);
        } else {
            $("input#tab3").val(0);
            $("button#tab3").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 64);
        }
    });

    $("button#tab4").click(function () {
        if ($("input#tab4").val() == 0) {
            $("input#tab4").val(1);
            $("button#tab4").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 32);
        } else {
            $("input#tab4").val(0);
            $("button#tab4").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 32);
        }
    });

    $("button#tab5").click(function () {
        if ($("input#tab5").val() == 0) {
            $("input#tab5").val(1);
            $("button#tab5").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 16);
        } else {
            $("input#tab5").val(0);
            $("button#tab5").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 16);
        }
    });

    $("button#tab6").click(function () {
        if ($("input#tab6").val() == 0) {
            $("input#tab6").val(1);
            $("button#tab6").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 8);
        } else {
            $("input#tab6").val(0);
            $("button#tab6").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 8);
        }
    });

    $("button#tab7").click(function () {
        if ($("input#tab7").val() == 0) {
            $("input#tab7").val(1);
            $("button#tab7").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 4);
        } else {
            $("input#tab7").val(0);
            $("button#tab7").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 4);
        }
    });

    $("button#tab8").click(function () {
        if ($("input#tab8").val() == 0) {
            $("input#tab8").val(1);
            $("button#tab8").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 2);
        } else {
            $("input#tab8").val(0);
            $("button#tab8").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 2);
        }
    });

    $("button#tab9").click(function () {
        if ($("input#tab9").val() == 0) {
            $("input#tab9").val(1);
            $("button#tab9").css("background-color", "blue");
            $("#tab").val(parseInt($("#tab").val()) + 1);
        } else {
            $("input#tab9").val(0);
            $("button#tab9").css("background-color", "white");
            $("#tab").val(parseInt($("#tab").val()) - 1);
        }
    });
</script>