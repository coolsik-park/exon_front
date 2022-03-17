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
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
    <script src="//vjs.zencdn.net/7.10.2/video.min.js"></script>
    <script src="/js/videojs-http-streaming.min.js"></script>

    <style>
        .video-js .vjs-time-control{display:block;}
        .video-js .vjs-remaining-time{display: none;}
        .video-js .vjs-progress-holder {
            height:4px;
            width:100%;
            /* position:absolute; */
            /* margin:0px;
            top:0%; */
        }
        
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
            .stream-ipt1 {
                align-items: flex-end;
            }
            .stream-ipt3 {
                flex-direction: column;
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
            <div id="videoWrap" class="wb-cont1" >
                <video class="video-js vjs-default-skin vjs-big-play-centered" id="vid1"></video>
            </div>
            <div class="wb-cont2">
                <div class="w-desc">
                    <p class="wd1"><span class="w-dt">스트리밍 시간 : </span><span id="live_duration_time" class="w-dd">00:00:00</span></p>
                    <p class="wd2"><span class="w-dt">시청자 : </span><span id="viewer" class="w-dd">0명</span></p>
                </div>
                <div class="w-desc">
                    <p class="wd1"><span class="w-dt">남은 스트리밍 시간 : </span><span id="remain_duration_time" class="w-dd">00:00:00</span></p>
                </div>
            </div>   
            <div id="liveButtons" class="wb-cont2">
                <?php if ($exhibitionStream->live_started == '') : ?>
                <button id="start" type="button" class="btn-ty4 black">방송시작</button>
                <?php else : ?>
                <button id="end" type="button" class="btn-ty4 gray">방송종료</button>
                <?php endif; ?>
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
                    <div id="stream_key_div">
                        <div class="stream-ipt3">
                            <div class="ipt-eye">
                                <input id="stream_key" name="stream_key" type="password" class="ipt-tx" readonly>
                                <button type="button" id="hidden_stream_key" class="ico-eye">히든</button>
                            </div>
                            <button type="button" id="copy_stream_key" class="btn-ty2 bor">복사</button>
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
        <div id="toggle" class="webinar-tab">
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
                <p class="wb-alert wb-alert2">탭 설정이 활성화 된 후 참가자에게 공개할 탭(메뉴)을 선택한 뒤 저장 버튼을 누르면 선택된 탭이 참가자 화면에 표시됩니다.</p>  
                <p class="wb-alert wb-alert2">방송중에도 탭 설정은 가능합니다. </p>  
            </div>
            <!-- body -->
        </div>
        <!-- webinar-tab -->
    </div>
    <?php $this->Form->end(); ?>
</div>        

<script>
    //video.js
    var player = videojs('vid1', {
        controls: true,
        autoplay: true,
        preload: 'auto',
        muted: true,
        liveui: true,
        fluid: true,
        liveTracker: {
            trackingThreshold: 0
        }
    });

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
    setInterval("countViewer()" , 3000);
    setInterval("updateLiveDurationTime()" , 1000);
    setInterval("getRemainLiveDuration()" , 1000);

    function getRemainLiveDuration() {
        jQuery.ajax({
            url: "/exhibition-stream/get-remain-live-duration/" + <?= $exhibitionStream->id ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            var time = new Date(data.time * 1000).toISOString().substr(11, 8);
            $("#remain_duration_time").html(time);
        });
    }
    
    function countViewer () {
        jQuery.ajax({
            url: "/exhibition-stream/count-viewer/" + <?= $exhibitionStream->exhibition_id ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            $("#viewer").html(data.count + "명");
        });
    }

    function updateLiveDurationTime () {
        jQuery.ajax({
            url: "/exhibition-stream/get-live-duration-time/" + <?= $exhibitionStream->id ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            var time = new Date(data.time * 1000).toISOString().substr(11, 8);
            $("#live_duration_time").html(time);
        });
    }

    $("#title").val("<?=$exhibitionStream->title?>");
    $("#description").val("<?=$exhibitionStream->description?>");
    $("#stream_key").val("<?=$exhibitionStream->stream_key?>");
    $("#url").val("<?=$exhibitionStream->url?>");
    $("#tab").val("<?=$exhibitionStream->tab?>");

    var timeCheck;
    var timeCheckBeforeTen;

    timeCheck = setInterval("liveTimeCheck()", 1000);
    timeCheckBeforeTen = setInterval("liveTimeCheckBeforeTen()", 1000);
    var is_timeCheck = 1;
    var is_timeCheckBeforeTen = 1;

    //OBS방송 중 체크
    $(document).ready(function () {
        var live_started = "<?=$exhibitionStream->live_started?>";
        if (live_started != "") {
            player.src({src: video_uri, type: 'application/x-mpegURL'});
            player.load();
            player.play();
        }
    });

    //방송 종료시간 컨트롤
    function liveTimeCheck () {
        var exhibition_stream_id = "<?=$exhibitionStream->id?>";
        jQuery.ajax({
            url: "/exhibition-stream/live-time-check/" + exhibition_stream_id, 
            method: 'POST',
            type: 'json',
            success: function (data) {
                if (data.time <= data.live_duration) {
                    clearInterval(timeCheck);
                    clearInterval(timeCheckBeforeTen);
                    is_timeCheck = 0;
                    is_timeCheckBeforeTen = 0; 

                    // liveEnd();
                    
                    player.dispose();
                    var html = '<video class="video-js vjs-default-skin vjs-big-play-centered" id="vid1"></video>';
                    $("#videoWrap").append(html);
                    player = videojs('vid1', {
                        controls: true,
                        autoplay: true,
                        preload: 'auto',
                        muted: true,
                        liveui: true,
                        fluid: true,
                        liveTracker: {
                            trackingThreshold: 0
                        }
                    });
                    player.load();
                    $("#liveButtons").children().remove();
                    $("#liveButtons").append('<button id="start" type="button" class="btn-ty4 black">방송시작</button>');

                    alert("서비스 시간 만료로 방송이 종료되었습니다.");
                }
            }
        });
    }

    function liveTimeCheckBeforeTen () {
        var exhibition_stream_id = "<?=$exhibitionStream->id?>";
        jQuery.ajax({
            url: "/exhibition-stream/live-time-check/" + exhibition_stream_id, 
            method: 'POST',
            type: 'json',
            success: function (data) {
                if (data.time - data.live_duration == 600) {
                clearInterval(timeCheckBeforeTen);
                is_timeCheckBeforeTen = 0;     
                confirm("결제하신 방송 서비스 시간이 10분 남았습니다.\n10분 후 방송이 자동 종료됩니다. \n추가 결제가 필요하신 경우 결제를 클릭해주세요.");
                }
            }
        });
    }

    //방송 컨트롤
    var video_uri = "https://orcaexon.co.kr/live/<?=$exhibitionStream->stream_key?>/index.m3u8"
    var stream_key = "<?=$exhibitionStream->stream_key?>"

    $(document).on("click", "#start", function () {
        var remain_time = "<?=$exhibitionStream->time?>";
        var live_duration = "<?=$exhibitionStream->live_duration?>";

        $.ajax({
            url: video_uri,
            type: 'HEAD',
            success: function () {
                if (confirm("방송 종료후 영상vod를 제공하고 있습니다.\n영상의 품질은 사용PC환경과 방송프로그램 설정에 따라\n달라질 수 있으니 송출 프로그램 자체녹화를 권장합니다.\n방송을 시작하시겠습니까?")) {
                    $.ajax({
                        url: "/exhibition-stream/set-started-time/<?=$exhibitionStream->id?>", 
                        type: 'POST',
                    }).done(function (data) {
                        if (data.status == 'success') {
                            player.src({src: video_uri, type: 'application/x-mpegURL' });
                            player.load();
                            player.play();

                            if (is_timeCheck == 0) {
                                timeCheck = setInterval("liveTimeCheck()", 1000);
                            }
                            if (is_timeCheckBeforeTen == 0) {
                                timeCheckBeforeTen = setInterval("liveTimeCheckBeforeTen()", 1000);

                            }
                            $("#liveButtons").children().remove();
                            $("#liveButtons").append('<button id="end" type="button" class="btn-ty4 gray">방송종료</button>');
                        
                        } else {
                            alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
                        }
                    });
                } else {
                    return false;
                }
            },
            error: function () {
                alert("송출 프로그램에서 송출을 시작해주세요.\n(송출 시작 후 약 10초 정도의 지연시간이 존재합니다.)");
            }
        });
    });

    $(document).on("click", "#end", function () {
        clearInterval(timeCheck);
        clearInterval(timeCheckBeforeTen); 
        liveEnd();
        alert("저장된 VOD는 인코딩이 완료된 후 마이페이지>개설행사관리 페이지에서 다운로드 받으실 수 있습니다.");
    });

    function liveEnd () {
        clearInterval(timeCheck);
        clearInterval(timeCheckBeforeTen); 
        is_timeCheck = 0;
        is_timeCheckBeforeTen = 0; 

        var obj = new Object();
        obj.stream_key = stream_key;
        obj.video_uri = stream_key;
        obj.stream_title = "<?=$exhibitionStream->title?>";
        obj.stream_id = <?=$exhibitionStream->id?>;
        var jsonData = JSON.stringify(obj);
        
        $.ajax({
            url: video_uri,
            type: 'HEAD',
            success: function () {
                jQuery.ajax({
                    url: "https://orcaexon.co.kr/end", 
                    method: 'DELETE',
                    type: 'json',
                    data: jsonData,
                    success: function () {
                        player.dispose();
                        var html = '<video class="video-js vjs-default-skin vjs-big-play-centered" id="vid1"></video>';
                        $("#videoWrap").append(html);
                        player = videojs('vid1', {
                            controls: true,
                            autoplay: true,
                            preload: 'auto',
                            muted: true,
                            liveui: true,
                            fluid: true,
                            liveTracker: {
                                trackingThreshold: 0
                            }
                        });
                        player.load();

                        $("#liveButtons").children().remove();
                        $("#liveButtons").append('<button id="start" type="button" class="btn-ty4 black">방송시작</button>');
                    },
                    error: function (data) {
                        alert("오류가 발생했습니다. 잠시 후 다시 시도해주세요.");
                    }
                });
            }
        });
    }

    //저장
    $(document).on("click", "#save", function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("방송제목을 입력해 주세요.");
            $("#title").focus();
            return false;
        }

        //ajax
        var formData = $("#setForm").serialize();
        
        $.ajax({
            url: "/exhibition-stream/test2/<?=$exhibition_id?>",
            method: 'PUT',
            type: 'json',
            data: formData
        }).done(function(data) {
            alert("저장되었습니다.");
            location.reload();
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
            alert('복사되었습니다.');
        
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
    
    //remove comma
    function removeComma(obj) {
        var amount = obj.replace(",","");
        return amount
    }

    //탭 컨트롤
    var dec = $("#tab").val();
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
            $("#li" + i).attr("class", "active");
        }
    }
  
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
            $("#save").click();
        }
    });

    var chatInterval
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
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
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/set-survey/" + <?= $exhibition_id ?>);
        }
    });

    var now = new Date();
    now = now.toISOString();
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
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibition_id ?> + "/" + now);
        }
    });

</script>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>