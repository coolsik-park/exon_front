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

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <script src="./videojs-http-streaming.min.js"></script>
</head>
<body>
    
    <!-- <div class="row">
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
                        echo $this->Form->control('stream_key', ['label' => '스트림 키', 'id' => 'streamKey']);
                        echo $this->Form->control('url', ['id' => 'videoUri']);
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
                            echo $this->Form->button($tab->title, ['id' => 'tab' . $i, 'name' => $tab->title, 'type' => 'button']) . ' ';
                            echo $this->Form->control($tab->title, ['id' => 'tab' . $i, 'type' => 'hidden']);
                            $i--;
                        }
                        echo $this->Form->button('setting', ['id' => 'setting']);
                        echo $this->Form->control('setting', ['id' => 'setting', 'type' => 'hidden']);
                    ?>
                </fieldset>
            </div>
        </div>
            <div id = "tabContent">
        </div>
    </div> -->


    <div class="contents">
    <?= $this->Form->create($exhibitionStream) ?>
    <div class="section-webinar3">
        <div class="webinar-cont">
            <div class="wb-cont1">
            <video-js id=vid1 width=600 height=300 class="vjs-default-skin vjs-big-play-centered" controls>
                <source src = <?= "http://121.126.223.225:80/live/" . $exhibitionStream->stream_key . "/index.m3u8" ?> type = "application/x-mpegURL" id = "source">
            </video-js>

            <?php echo $this->Form->button('start', ['id' => 'start']); ?>
            <?php echo $this->Form->button('end', ['id' => 'end']); ?>
            </div>
            <div class="wb-cont2">
                <input type="text" placeholder="(필수) 방송제목">
                <textarea name="" id="" cols="30" rows="3" placeholder="방송 설명을 입력해주세요."></textarea>
            </div>
            <div class="wb-cont3">
                <button type="button" class="btn-ty4 black">저장</button>
                <button type="button" class="btn-ty4 gray">종료</button>
            </div>

            <div class="wb-stream-sect">
                <h2 class="s-hty3">스트림 키</h2>
                <div class="stream-sect">
                    <div class="row2">
                        <div class="col-th">프로모션 키</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text">
                                <button type="button" class="btn-ty2 bor">확인</button>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2">
                            <div class="col-th">시간</div>
                            <div class="col-td">
                                <div class="stream-itp2">
                                    <select>
                                        <option value="">half day</option>
                                        <option value="">all day</option>
                                    </select>
                                    <select>
                                        <option value="">50</option>
                                        <option value="">100</option>
                                        <option value="">150</option>
                                        <option value="">200</option>
                                        <option value="">150</option>
                                    </select>
                                    명
                                </div>
                            </div>
                        </div>
                        <div class="row2">
                            <div class="col-th">금액</div>
                            <div class="col-td">
                                <div class="stream-ipt1">
                                    <input type="text">
                                    <button type="button" class="btn-ty2 bor">결제</button>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div class="stream-btn">
                        <button type="button" class="btn-ty2">스트림 키 발급</button>
                    </div>
                    <div class="row2">
                        <div class="col-th">스트림 URL</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text">
                                <button type="button" class="btn-ty2 bor">복사</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wb-stream-sect">
                <h2 class="s-hty3">스트림 키</h2>
                <div class="stream-sect">
                    <div class="row2">
                        <div class="col-th">프로모션 키</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text">
                                <button type="button" class="btn-ty2 gray2">확인</button>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2">
                            <div class="col-th">시간</div>
                            <div class="col-td">
                                <div class="stream-itp2">
                                    <select>
                                        <option value="">half day</option>
                                        <option value="">all day</option>
                                    </select>
                                    <select>
                                        <option value="">50</option>
                                        <option value="">100</option>
                                        <option value="">150</option>
                                        <option value="">200</option>
                                        <option value="">150</option>
                                    </select>
                                    명
                                </div>
                            </div>
                        </div>
                        <div class="row2">
                            <div class="col-th">금액</div>
                            <div class="col-td">
                                <div class="stream-ipt1">
                                    <input type="text">
                                    <button type="button" class="btn-ty2 bor">결제</button>
                                </div>                    
                            </div>
                        </div>
                    </div>            
                    <div class="stream-ipt3">
                        <div class="ipt-eye">
                            <input type="password" class="ipt-tx">
                            <button type="button" class="ico-eye">히든</button>
                        </div>
                        <button type="button" class="btn-ty2 bor">복사</button>
                    </div>            
                    <div class="row2">
                        <div class="col-th">스트림 URL</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text">
                                <button type="button" class="btn-ty2 bor">복사</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- webinar-tab -->
        <div class="webinar-tab">
            <div class="webinar-tab-top">
                <div class="webinar-toggle">
                    <button type="button" class="webinar-tab-tg">토글버튼</button>
                    <button type="button" id="setting" class="ico-sett">설정</button>
                    <input type="hidden" id="setting">
                    <?php
                        echo $this->Form->control('tab', ['type' => 'hidden']);
                        $i = 9;
                        foreach ($tabs as $tab) {
                            echo $this->Form->control($tab->title, ['id' => 'tab' . $i, 'type' => 'hidden']);
                            $i--;
                        }
                    ?>
                </div>                        
                <div class="w-tab-wrap">
                    <div class="w-tab-wrap-inner">
                        <ul class="w-tab">
                            <li id="li9" class=""><button type="button" id="tab9" name="실시간 채팅">실시간 채팅</button></li>
                            <li id="li8" class=""><button type="button" id="tab8" name="설문">설문</button></li>
                            <li id="li7" class=""><button type="button" id="tab7" name="공지사항">공지사항</button></li>
                            <li id="li6" class=""><button type="button" id="tab6" name="질의 응답">질의 응답</button></li>
                            <li id="li5" class=""><button type="button" id="tab5" name="출석체크">출석체크</button></li>
                            <li id="li4" class=""><button type="button" id="tab4" name="프로그램">프로그램</button></li>
                            <li id="li3" class=""><button type="button" id="tab3" name="담당자 정보">담당자 정보</button></li>
                            <li id="li2" class=""><button type="button" id="tab2" name="개설자 정보">개설자 정보</button></li>
                            <li id="li1" class=""><button type="button" id="tab1" name="행사 정보">행사 정보</button></li>
                            <li id="li0" class=""><button type="button" id="tab0" name="자료">자료</button></li>
                        </ul>
                    </div>                            
                </div>
            </div>   
            <!-- // top -->
            <div class="webinar-tab-body">  
                <p class="wb-alert">사용할 탭을 선택해주세요</p>   
            </div>
            <!-- body -->
        </div>
        <!-- webinar-tab -->
    </div>
    <?= $this->Form->end() ?>
</div>    
</body>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    videojs('vid1').play();
</script>
<script>
    $("#start").click(function () {
        var data = {
            stream_key: $("#streamKey").val(),
            video_uri: $("#videoUri").val()
        }
        var jsonData = JSON.stringify(data) ;

        jQuery.ajax({
            url: "http://121.126.223.225:9920/live",
            method: 'POST',
            type: 'json',
            data: jsonData
        }).done(function (status) {
            if (status == 200) {
                alert("방송이 시작되었습니다.");
            }
        });
    });

    $("#end").click(function () {
        var data = {
            stream_key: $("#streamKey").val(),
            video_uri: $("#videoUri").val()
        }
        var jsonData = JSON.stringify(data) ;

        jQuery.ajax({
            url: "http://121.126.223.225:9920/live",
            method: 'DELETE',
            type: 'json',
            data: jsonData
        }).done(function (status) {
            if (status == 200) {
                alert("방송이 종료되었습니다.");
            }
        });
    });
</script>
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
                    url: "/pay/import-pay", 
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
            $("#li" + i).attr("class", "active"); 
        }
    }

    $("button#setting").click(function () {
        if ($("input#setting").val() == null || $("input#setting").val() == 0) {
            $("input#setting").val(1);
            alert("사용할 탭을 선택해주세요.");
        } else {
            $("input#setting").val(0);
            alert("탭 설정이 완료되었습니다.");
        }
    });

    $("button#tab0").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab0").val() == 0) {
                $("input#tab0").val(1);
                $("#li0").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 512);
                // alert($("button#tab0").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab0").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab0").val(0);
                $("#li0").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 512);
                // alert($("button#tab0").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab0").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-exhibition-files/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab1").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab1").val() == 0) {
                $("input#tab1").val(1);
                $("#li1").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 256);
                // alert($("button#tab1").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab1").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab1").val(0);
                $("#li1").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 256);
                // alert($("button#tab1").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab1").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab2").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab2").val() == 0) {
                $("input#tab2").val(1);
                $("#li2").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 128);
                // alert($("button#tab2").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab2").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab2").val(0);
                $("#li2").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 128);
                // alert($("button#tab2").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab2").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab3").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab3").val() == 0) {
                $("input#tab3").val(1);
                $("#li3").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 64);
                // alert($("button#tab3").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab3").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab3").val(0);
                $("#li3").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 64);
                // alert($("button#tab3").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab3").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab4").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab4").val() == 0) {
                $("input#tab4").val(1);
                $("#li4").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 32);
                // alert($("button#tab4").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab4").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab4").val(0);
                $("#li4").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 32);
                // alert($("button#tab4").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab4").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-program/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab5").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab5").val() == 0) {
                $("input#tab5").val(1);
                $("#li5").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 16);
                // alert($("button#tab5").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab5").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab5").val(0);
                $("#li5").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 16);
                // alert($("button#tab5").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab5").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/attendance/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab6").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab6").val() == 0) {
                $("input#tab6").val(1);
                $("#li6").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 8);
                // alert($("button#tab6").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab6").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab6").val(0);
                $("#li6").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 8);
                // alert($("button#tab6").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab6").attr('name')+' 탭이 비활성화되었습니다.');
            } 
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/question-menu/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab7").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab7").val() == 0) {
                $("input#tab7").val(1);
                $("#li7").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 4);
                // alert($("button#tab7").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab7").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab7").val(0);
                $("#li7").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 4);
                // alert($("button#tab7").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab7").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-notice/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab8").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab8").val() == 0) {
                $("input#tab8").val(1);
                $("#li8").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 2);
                // alert($("button#tab8").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab8").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab8").val(0);
                $("#li8").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 2);
                // alert($("button#tab8").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab8").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-survey/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });

    $("button#tab9").click(function () {
        if ($("input#setting").val() == 1) {
            if ($("input#tab9").val() == 0) {
                $("input#tab9").val(1);
                $("#li9").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 1);
                // alert($("button#tab9").attr('name')+' 탭이 활성화되었습니다.');
                $(".wb-alert").html($("button#tab9").attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("input#tab9").val(0);
                $("#li9").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 1);
                // alert($("button#tab9").attr('name')+' 탭이 비활성화되었습니다.');
                $(".wb-alert").html($("button#tab9").attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream->exhibition_id ?>);
        }
    });
</script>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
