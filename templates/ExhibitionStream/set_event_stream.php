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
        .pay {
            width: 244px;
            margin: 0px 0px 0px 12px;
        }
        .stream-sect .row2-wp .row2 {
            width: 60%;
        }
        .payDiv {
            width: 60%;
        }
        .sett-btn {
            display: block;
            position: absolute;
            top: -5px;
            right: 1px;
            padding: 8px;
            border-radius: 10px;
            border: 1px solid lightgray;
            color: black;
        }
        .save-btn {
            display: inline-block;
            position: absolute;
            top: -5px;
            right: 1px;
            padding: 8px;
            border-radius: 10px;
            border: 1px solid black;
            color: black;
        }
        @media  screen and (max-width: 768px) {
            .stream-sect .row2-wp .row2 {
                width: 99%;
            }
            .pay {
                width: 100%;
            }
            .payDiv {
                width: 100%;
            }
            .stream-ipt1 {
                flex-direction: column;
            }
            .btn-ty2.bor {
                margin: 16px 0px 0px 0px;
            }
            .stream-sect .row2-wp .row2 + .row2 .col-th {
                margin-bottom: 155px;
            }
            .btnDiv {
                align-items: flex-end;
            }
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
    <div class="section-webinar4">
        <div class="webinar-cont">
            <div class="wb-cont1">
                <video-js id=vid1 class="vjs-default-skin vjs-big-play-centered" controls data-setup='{"fluid": true}'></video-js>
            </div>
            <div class="wb-cont2">
                <input name="title" id="title" type="text" placeholder="(필수) 방송제목">
                <textarea name="description" id="description" cols="30" rows="3" placeholder="방송 설명을 입력해주세요."></textarea>
            </div>
            <div class="wb-stream-sect" id="stream_key_container">
                <h2 class="s-hty3">스트림 키</h2>
                <div class="stream-sect">
                    <div class="row2">
                        <div class="col-th">프로모션 키</div>
                        <div class="col-td">
                            <div class="stream-ipt1">
                                <input type="text" id="coupon_code" name="coupon_code">
                                <button type="button" id="confirm_coupon" name="confirm_coupon" class="btn-ty2 bor">확인</button>
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
                </div>
            </div>
        </div>
        <!-- webinar-tab -->
        <div class="webinar-tab" id="toggle">
            <div class="webinar-tab-top">
                <div class="webinar-toggle">
                    <button type="button" class="webinar-tab-tg">토글버튼</button>
                    <button type="button" id="setting_btn" name="btn_off" class="sett-btn">메뉴설정</button>
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
                <p class="wb-alert wb-alert2">위에 표기된 메뉴를 사용하시기 위해서는 메뉴설정 버튼을 클릭해 활성화 시켜주시기 바랍니다.</p>  
                <p class="wb-alert wb-alert2">탭 설정이 활성화 된 후 참가자에게 공개할 탭(메뉴)을 선택한 뒤 결제를 진행하시면 선택된 탭이 참가자 화면에 표시됩니다.</p>  
                <p class="wb-alert wb-alert2">방송중에도 탭 설정은 가능합니다. </p>  
            </div>
            <!-- body -->
        </div>
        <!-- webinar-tab -->
    </div>
    <?php $this->Form->end(); ?>
</div>        

<script>
    //hide sub-menu
    $(document).on("click", ".webinar-tab-tg", function () {
        if ($("#toggle").hasClass("close")) {
            $(".sub-menu").show();
        } else {
            $(".sub-menu").hide();
        }
    });

    //페이지 로드시
    $(".sub-menu").hide();

    //저장
    $(document).on("click", "#confirm_coupon", function() {
        //Validation
        if ($("#coupon_code").val() != 'exonwebinar') {
            alert("프로모션 키를 다시 확인해주세요.");
            $("#coupon_code").focus();
            return false;
        } 

        if ($("#title").val().length == 0) {
            alert("방송제목을 입력해 주세요.");
            $("#title").focus();
            return false;
        }

        //ajax
        var formData = $("#setForm").serialize();

        $.ajax({
            url: "/exhibition-stream/issue-stream-key/",
            method: 'POST',
            type: 'json',
            data: null
        }).done(function (data) {
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

            $.ajax({
                url: "/exhibition-stream/test/<?=$exhibition_id?>",
                method: 'POST',
                type: 'json',
                data: formData
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("저장되었습니다.");
                    location.reload();
                } else {
                    alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                }
            });
        });
    });

    $(document).on("click", "#issue_stream_key", function() {
        //Validation
        if ($("#coupon_code").val() != 'exonwebinar') {
            alert("프로모션 키를 다시 확인해주세요.");
            $("#coupon_code").focus();
            return false;
        } 

        if ($("#title").val().length == 0) {
            alert("방송제목을 입력해 주세요.");
            $("#title").focus();
            return false;
        }

        //ajax
        $.ajax({
            url: "/exhibition-stream/issue-stream-key/",
            method: 'POST',
            type: 'json',
            data: null
        }).done(function (data) {
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

            var formData = $("#setForm").serialize();

            $.ajax({
                url: "/exhibition-stream/test/<?=$exhibition_id?>",
                method: 'POST',
                type: 'json',
                data: formData
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("스트림 키가 발급되었습니다.");
                    location.reload();
                } else {
                    alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                }
            });
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

    //탭 컨트롤    
    $(document).on("click", "#setting_btn", function () {
        
        if ($(this).attr("name") == "btn_off") {
            $(this).attr("name", "btn_on");
            $(this).removeClass("sett-btn");
            $(this).addClass("save-btn");
            $(this).html("저장");
            alert("탭 설정이 활성화 되었습니다.");
        } else {
            $(this).attr("name", "btn_off");
            $(this).removeClass("save-btn");
            $(this).addClass("sett-btn");
            $(this).html("메뉴설정");
            alert("탭 설정이 비 활성화 되었습니다.");
        }
    });

    $("#btn_tab0").click(function () {
        if ($("#setting_btn").attr("name") == "btn_on") {
            if ($("#li0").attr("class") == "") {
                $("#li0").attr("class", "active");
                $("#tab").val(parseInt($("#tab").val()) + 512);
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li0").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 512);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li1").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 256);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li2").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 128);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li3").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 64);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li4").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 32);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li5").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 16);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li6").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 8);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li7").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 4);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li8").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 2);
                $(".wb-alert2").css({"display": "none"});
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
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 활성화되었습니다.');
            } else {
                $("#li9").attr("class", "");
                $("#tab").val(parseInt($("#tab").val()) - 1);
                $(".wb-alert2").css({"display": "none"});
                $(".wb-alert").html($(this).attr('name')+' 탭이 비활성화되었습니다.');
            }
        } else {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat-not-exist/" + <?= $exhibition_id ?>);
        }
    });

</script>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
