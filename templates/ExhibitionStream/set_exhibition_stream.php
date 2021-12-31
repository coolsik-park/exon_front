<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream $exhibitionStream
 */
?>

<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="shortcut icon" href="#" > <!-- 음량 올릴시 오류 해결 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <script src="/js/videojs-http-streaming.min.js"></script>

    <style>
        .wb-stream-sect {
            margin-bottom: 70px;
        }
    </style>
</head>

<div class="contents">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $exhibition_id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $exhibition_id ?>">설문 데이터</a></li>
                <li><a href="/exhibition/manager-person/<?= $exhibition_id ?>">참가자 관리</a></li>
                <li class="active"><a href="">웨비나 송출 설정</a></li>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $exhibition_id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>
    <?= $this->Form->create($exhibitionStream, ['id' => 'setForm']) ?>    
    <div class="section-webinar3">
        <div class="webinar-cont">
            <div class="wb-cont1">
                <video-js id=vid1 class="vjs-default-skin vjs-big-play-centered" controls data-setup='{"fluid": true}'></video-js>
            </div>
            <div class="wb-cont2">
                <input name="title" id="title" type="text" placeholder="(필수) 방송제목">
                <textarea name="description" id="description" cols="30" rows="3" placeholder="방송 설명을 입력해주세요."></textarea>
            </div>
            <div class="wb-cont3">
                <button id="save" type="button" class="btn-ty4 black">저장</button>
                <button id="exit" type="button" class="btn-ty4 gray">종료</button>
            </div>

            <div class="wb-stream-sect" id="stream_key_container">
                <h2 class="s-hty3">스트림 키</h2>
                <div class="stream-sect">
                    <div class="row2">
                        <div class="col-th">프로모션 키</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text" id="coupon_code" name="coupon_code">
                                <button type="button" id="confirm_coupon" name="confirm_coupon" onclick="validateCoupon()" class="btn-ty2 bor">확인</button>
                            </div>
                        </div>
                    </div>
                    <div class="row2-wp">
                        <div class="row2">
                            <div class="col-th">시간</div>
                            <div class="col-td">
                                <div class="stream-itp2">
                                    <select id="time" name="time">
                                        <option value="18000">half day</option>
                                        <option value="36000">all day</option>
                                    </select>
                                    <select id="people" name="people">
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                        <option value="250">250</option>
                                        <option value="300">300</option>
                                        <option value="350">350</option>
                                        <option value="400">400</option>
                                        <option value="450">450</option>
                                        <option value="500">500</option>
                                    </select>
                                    명
                                </div>
                            </div>
                        </div>
                        <div class="row2">
                            <div class="col-th">금액</div>
                            <div class="col-td">
                                <div class="stream-ipt1">
                                    <input type="text" id="amount" name="amount" value="0" readonly>
                                    <input type="hidden" id="is_paid"> 
                                    <input type="hidden" id="pay_id" name="pay_id">
                                    <button type="button" id="payment" class="btn-ty2 bor">결제</button>
                                </div>                    
                            </div>
                        </div>
                    </div>
                    <div id="stream_key_div">
                        <div class="stream-btn">
                            <button type="button" id="issue_stream_key" class="btn-ty2">스트림 키 발급</button>
                        </div>
                    </div>
                    <div class="row2">
                        <div class="col-th">스트림 URL</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text" id="url" name="url" readonly>
                                <button type="button" id="copy_url" class="btn-ty2 bor">복사</button>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row2" style="height:48px; padding-top:5px;">
                        <div class="col-th">VOD 저장</div>
                        <div class="col-td">
                            <span class="chk-dsg"><input type="checkbox" id="is_download" name="is_download" value="1"><label for="is_download"></label></span>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- webinar-tab -->
        <div class="webinar-tab">
            <div class="webinar-tab-top">
                <div class="webinar-toggle">
                    <button type="button" class="webinar-tab-tg">토글버튼</button>
                    <button type="button" id="setting_btn" name="btn_off" class="ico-sett">설정</button>
                    <input type="hidden" id="tab" name="tab" value="0">
                </div>                        
                <div class="w-tab-wrap">
                    <div class="w-tab-wrap-inner">
                        <ul class="w-tab">
                            <li id="li9" class=""><button type="button" id="btn_tab9" name="실시간 채팅">실시간 채팅</button></li>
                            <li id="li8" class=""><button type="button" id="btn_tab8" name="설문">설문</button></li>
                            <li id="li7" class=""><button type="button" id="btn_tab7" name="공지사항">공지사항</button></li>
                            <li id="li6" class=""><button type="button" id="btn_tab6" name="질의 응답">질의 응답</button></li>
                            <li id="li5" class=""><button type="button" id="btn_tab5" name="출석체크">출석체크</button></li>
                            <li id="li4" class=""><button type="button" id="btn_tab4" name="프로그램">프로그램</button></li>
                            <li id="li3" class=""><button type="button" id="btn_tab3" name="담당자 정보">담당자 정보</button></li>
                            <li id="li2" class=""><button type="button" id="btn_tab2" name="개설자 정보">개설자 정보</button></li>
                            <li id="li1" class=""><button type="button" id="btn_tab1" name="행사 정보">행사 정보</button></li>
                            <li id="li0" class=""><button type="button" id="btn_tab0" name="자료">자료</button></li>
                        </ul>
                    </div>                            
                </div>
            </div>   
            <!-- // top -->
            <div class="webinar-tab-body">  
                <p class="wb-alert">사용할 탭을 선택해주세요</p>   
                <p class="wb-alert">위에 표기된 메뉴를 사용하시기 위해서는 설정( <img src="../../img/ico-sett.png">   )버튼을 클릭해 활성화 시켜주시기 바랍니다.</p>  
                <p class="wb-alert">탭 설정이 활성화 된 후 참가자에게 공개할 탭(메뉴)을 선택하시면 선택된 탭이 참가자 화면에 표시됩니다.</p>  
                <p class="wb-alert">방송중에도 탭 설정은 가능합니다. </p>  
            </div>
            <!-- body -->
        </div>
        <!-- webinar-tab -->
    </div>
    <?php $this->Form->end(); ?>
</div>        

<script>
    //페이지 로드시
    
    var amount = 0;
    var coupon_id = 0;
    var discount_rate = 0;
    var coupon_amount = 0;
    var halfday_price = [];
    var allday_price = [];

    var i = 50;
    <?php foreach ($prices as $price) : ?>
        halfday_price[i] = <?=$price->halfday_price?>;
        allday_price[i] = <?=$price->allday_price?>;
        i += 50; 
    <?php endforeach; ?>
    
    if ($("#time").val() == 18000) {
        
        switch($("#people").val()) {
            case "50" : amount = halfday_price[50]; break;
            case "100" : amount = halfday_price[100]; break;
            case "150" : amount = halfday_price[150]; break;
            case "200" : amount = halfday_price[200]; break;
            case "250" : amount = halfday_price[250]; break;
            case "300" : amount = halfday_price[300]; break;
            case "350" : amount = halfday_price[350]; break;
            case "400" : amount = halfday_price[400]; break;
            case "450" : amount = halfday_price[450]; break;
            case "500" : amount = halfday_price[500]; break;
        }

    } else {

        switch($("#people").val()) {
            case "50" : amount = allday_price[50]; break;
            case "100" : amount = allday_price[100]; break;
            case "150" : amount = allday_price[150]; break;
            case "200" : amount = allday_price[200]; break;
            case "250" : amount = allday_price[250]; break;
            case "300" : amount = allday_price[300]; break;
            case "350" : amount = allday_price[350]; break;
            case "400" : amount = allday_price[400]; break;
            case "450" : amount = allday_price[450]; break;
            case "500" : amount = allday_price[500]; break;
        }
    }

    $("#amount").val(amount);

    //방송 버튼 클릭시
    $("#vid1").click(function () {
        alert("결제 및 설정을 완료해주세요.");
    });

    //저장
    $(document).on("click", "#save", function() {
        
        //Validation
        if ($("#title").val().length == 0) {
            alert("방송제목을 입력해 주세요.");
            $("#title").focus();
            return false;
        }

        if ($("#is_paid").val() == 0) {
            alert("결제를 완료해주세요.");
            return false;
        }

        if ($("#stream_key").val().length == 0) {
            alert("스트림 키를 발급해주세요.");
            return false;
        }

        //ajax
        var formData = $("#setForm").serialize();
        formData += '&coupon_amount=' + coupon_amount;
        formData += '&coupon_id=' + coupon_id;
        
        $.ajax({
            url: "/exhibition-stream/set-exhibition-stream/<?=$exhibition_id?>",
            method: 'POST',
            type: 'json',
            data: formData
        }).done(function(data) {
            if (data.status == 'success') {
                var coupon_code = $("#coupon_code").val();
                        
                if (coupon_code != '') {
                    jQuery.ajax({
                        url: "/exhibition-stream/change-coupon-status", 
                        method: 'POST',
                        type: 'json',
                        data: {
                            coupon_code: coupon_code,
                        }
                    }). done(function () {
                        alert("저장되었습니다.");
                        location.reload();
                    });
                
                } else {
                    alert("저장되었습니다.");
                    location.reload();
                }

            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    //종료
    $("#exit").click(function () {
        location.replace("/exhibition/edit/<?=$exhibition_id?>");
    });

    //스트림키 표시
    $(document).on("click", "#hidden_stream_key", function() {
        
        if ($("#stream_key").attr("type") == "text") {
            $("#stream_key").attr("type", "password");
        } else {
            $("#stream_key").attr("type", "text");
        }  
    });

    //복사
    $(document).on("click", "#copy_stream_key", function() {
        
        if ($("#stream_key").attr("type") == "text") {
            $("#stream_key").select();
            document.execCommand("copy");
            alert('복사완료');
        
        } else {
            $("#stream_key").attr("type", "text");
            $("#stream_key").select();
            document.execCommand("copy");
            alert('복사되었습니다.');
            $("#stream_key").attr("type", "password");
        }
    });

    $(document).on("click", "#copy_url", function() {
        $("#url").select();
        document.execCommand("copy");
        alert('복사되었습니다.');
    });
    
    //스트림키 발급
    $("#issue_stream_key").click(function() { 
        
        if ($("#is_paid").val() == 1) {
            
            $.ajax({
                url: "/exhibition-stream/issue-stream-key/",
                method: 'POST',
                type: 'json',
                data: null
            }).done(function(data) {
                if (data.status == 'success') {
                    var html = '';
                    html += '<div class="stream-ipt3">';
                    html += '   <div class="ipt-eye">';
                    html += '       <input id="stream_key" name="stream_key" type="password" class="ipt-tx" readonly>';
                    html += '       <button type="button" id="hidden_stream_key" class="ico-eye">히든</button>';
                    html += '   </div>';
                    html += '   <button type="button" id="copy_stream_key" class="btn-ty2 bor">복사</button>';
                    html += '</div> ';
                
                    $("#stream_key_div").children().remove();
                    $("#stream_key_div").append(html);
                    $("#stream_key").val(data.stream_key);
                    $("#confirm_coupon").attr("class", "btn-ty2 gray2");
                    $("#confirm_coupon").attr("onclick", "");
                    $("#url").val(data.stream_url);
                
                } else {
                    alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                }
            });
        
        } else {
            alert("결제를 완료해주세요.");
            return false;
        }
    });
    
    //쿠폰 검증
    function validateCoupon() {
        if (coupon_amount != 0) {
            alert("프로모션이 이미 적용되어 있습니다.");
            return false
        }
        var coupon_code = $("#coupon_code").val();
        $.ajax({
            url: "/exhibition-stream/validate-coupon/",
            method: 'POST',
            type: 'json',
            data: {
                coupon_code: coupon_code,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("프로모션이 적용되었습니다.");
                $("#coupon_code").attr("readonly", true);
                coupon_amount = $("#amount").val() * data.discount_rate / 100;
                $("#amount").val($("#amount").val() - ($("#amount").val() * data.discount_rate / 100));
                discount_rate = data.discount_rate
                coupon_id = data.coupon_id;
    
            } else {
                alert("프로모션 키를 다시 확인해주세요.");
            }
        });
    }

    //결제
    $("#payment").click(function () {
        var IMP = window.IMP; 
        IMP.init('imp43823679'); //아임포트 id -> 추후 교체
        IMP.request_pay({
            pg : 'inicis',
            pay_method : 'card',
            merchant_uid : 'merchant_' + new Date().getTime(),
            name : '스트리밍 서비스',
            amount : $('input#amount').val()
            //세션 유저정보에서 가져오기
            // buyer_email : '',
            // buyer_name : '구매자이름',
            // buyer_tel : '010-1234-5678',
            // buyer_addr : '서울특별시 강남구 삼성동',
            // buyer_postcode : '123-456'
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
                        coupon_amount: coupon_amount,
                        receipt_url: rsp.receipt_url,
                        paid_at: rsp.paid_at,
                        pg_tid: rsp.pg_tid
                    }
                }).done(function(data) {
                    if (data.status == 'success') { 
                        $("#is_paid").val(1);
                        $("#pay_id").val(data.pay_id);
                        if ($("#title").val().length == 0) {
                            $("#title").val("<?=$title?>");
                        }

                        var msg = '결제가 완료되었습니다.';
                        msg += '\n고유ID : ' + rsp.imp_uid;
                        msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                        msg += '\n결제 금액 : ' + rsp.paid_amount;
                        msg += '\n카드 승인번호 : ' + rsp.apply_num; 

                        alert(msg);

                        $("#issue_stream_key").click();
                        setTimeout(function () {
                            $("#save").click();
                        }, 500);

                    } else {
                        alert("결제에 실패하였습니다. 잠시 후 다시 시도해 주세요.")
                    }
                });
                
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;

                alert(msg);
            }
        });
    });

    //금액 설정
    $(document).on("change", "#people", function () {

        if ($("#time").val() == 18000) {
            
            switch($("#people").val()) {
                case "50" : amount = halfday_price[50]; break;
                case "100" : amount = halfday_price[100]; break;
                case "150" : amount = halfday_price[150]; break;
                case "200" : amount = halfday_price[200]; break;
                case "250" : amount = halfday_price[250]; break;
                case "300" : amount = halfday_price[300]; break;
                case "350" : amount = halfday_price[350]; break;
                case "400" : amount = halfday_price[400]; break;
                case "450" : amount = halfday_price[450]; break;
                case "500" : amount = halfday_price[500]; break;
            }

        } else {

            switch($("#people").val()) {
                case "50" : amount = allday_price[50]; break;
                case "100" : amount = allday_price[100]; break;
                case "150" : amount = allday_price[150]; break;
                case "200" : amount = allday_price[200]; break;
                case "250" : amount = allday_price[250]; break;
                case "300" : amount = allday_price[300]; break;
                case "350" : amount = allday_price[350]; break;
                case "400" : amount = allday_price[400]; break;
                case "450" : amount = allday_price[450]; break;
                case "500" : amount = allday_price[500]; break;
            }
        }
        coupon_amount = amount * discount_rate / 100;
        $("#amount").val(amount - coupon_amount);
    });

    $(document).on("change", "#time", function () {

        if ($("#time").val() == 18000) {
            
            switch($("#people").val()) {
                case "50" : amount = halfday_price[50]; break;
                case "100" : amount = halfday_price[100]; break;
                case "150" : amount = halfday_price[150]; break;
                case "200" : amount = halfday_price[200]; break;
                case "250" : amount = halfday_price[250]; break;
                case "300" : amount = halfday_price[300]; break;
                case "350" : amount = halfday_price[350]; break;
                case "400" : amount = halfday_price[400]; break;
                case "450" : amount = halfday_price[450]; break;
                case "500" : amount = halfday_price[500]; break;
            }

        } else {

            switch($("#people").val()) {
                case "50" : amount = allday_price[50]; break;
                case "100" : amount = allday_price[100]; break;
                case "150" : amount = allday_price[150]; break;
                case "200" : amount = allday_price[200]; break;
                case "250" : amount = allday_price[250]; break;
                case "300" : amount = allday_price[300]; break;
                case "350" : amount = allday_price[350]; break;
                case "400" : amount = allday_price[400]; break;
                case "450" : amount = allday_price[450]; break;
                case "500" : amount = allday_price[500]; break;
            }
        }
        coupon_amount = amount * discount_rate / 100;
        $("#amount").val(amount - coupon_amount);
    });

    //탭 컨트롤    
    $(document).on("click", "#setting_btn", function () {
        
        if ($(this).attr("name") == "btn_off") {
            $(this).attr("name", "btn_on");
            alert("탭 설정이 활성화 되었습니다.");
        } else {
            $(this).attr("name", "btn_off");
            alert("탭 설정이 비활성화 되었습니다.");
        }
    });

    $("#btn_tab0").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li0").attr("class") == "") {
                $("#li0").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 512);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li0").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 512);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-exhibition-files/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab1").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li1").attr("class") == "") {
                $("#li1").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 256);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li1").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 256);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab2").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li2").attr("class") == "") {
                $("#li2").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 128);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li2").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 128);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab3").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li3").attr("class") == "") {
                $("#li3").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 64);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li3").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 64);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab4").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li4").attr("class") == "") {
                $("#li4").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 32);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li4").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 32);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-program/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab5").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li5").attr("class") == "") {
                $("#li5").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 16);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li5").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 16);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/attendance/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab6").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li6").attr("class") == "") {
                $("#li6").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 8);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li6").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 8);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            } 
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/question-menu/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab7").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li7").attr("class") == "") {
                $("#li7").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 4);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li7").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 4);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-notice/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab8").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li8").attr("class") == "") {
                $("#li8").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 2);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li8").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 2);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream/set-survey/" + <?= $exhibition_id ?>);
        }
    });

    $("#btn_tab9").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li9").attr("class") == "") {
                $("#li9").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 1);
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li9").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 1);
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat-not-exist/" + <?= $exhibition_id ?>);
        }
    });

</script>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
