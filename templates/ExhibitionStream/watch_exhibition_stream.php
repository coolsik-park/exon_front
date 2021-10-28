
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="shortcut icon" href="#" > <!-- 음량 올릴시 오류 해결 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <script src="/js/videojs-http-streaming.min.js"></script>

    <style>
        .video-js .vjs-time-control{display:block;}
        .video-js .vjs-remaining-time{display: none;}
        .video-js .vjs-progress-holder {
            position:absolute;
            margin:0px;
            top:0%;
            width:100%;
        }
    </style>
</head>

<div id="container">       
    <div class="contents">            
        <div class="section-webinar4">
            <div class="webinar-cont">
                <div class="wb-cont1">
                    <!-- autoplay="autoplay" muted="muted" -->
                    <video-js id=vid1 class="vjs-default-skin vjs-big-play-centered" controls data-setup='{"fluid": true}' muted="muted" autoplay="autoplay"></video-js>
                </div>
                <div class="wb-cont2">
                    <h3 class="w-tit"><?= $exhibitionStream[0]['title'] ?></h3>
                    <div class="w-desc">
                        <p class="wd1"><span class="w-dt">스트리밍 시간 : </span><span id="live_duration_time" class="w-dd">00:00:00</span></p>
                        <p class="wd2"><span class="w-dt">시청자 : </span><span id="viewer" class="w-dd">0명</span></p>
                    </div>
                </div>                   
            </div>

            <!-- webinar-tab -->
            <div class="webinar-tab">
                <div class="webinar-tab-top">
                    <div class="webinar-toggle">
                        <button type="button" class="webinar-tab-tg">토글버튼</button>                           
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

                </div>
                <!-- // body-->
            </div>
            <!-- //webinar-tab -->
        </div>
    </div>        
</div>

<script>
    //방송 중 체크
    $(document).ready(function () {
        $.ajax({
            url: "http://121.126.223.225:80/live/<?=$exhibitionStream[0]['stream_key']?>/index.m3u8",
            type: 'HEAD',
            error: function () {
                window.location.replace("/exhibition-stream/stream-not-exist");
            }
        });
    });

    $(document).ready(function () {
        //시청자수 카운트
        setInterval("updateLastViewTime()" , 1000);
        setInterval("countViewer()" , 1000);
        setInterval("updateLiveDurationTime()" , 1000);
        
        //video.js 컨트롤
        var address = "http://121.126.223.225:80/live/<?=$exhibitionStream[0]['stream_key']?>/index.m3u8"
        window.onload = function () {
            var player = videojs(document.querySelector('#vid1'));
            player.src({
                    src: address, type: 'application/x-mpegURL' });
            player.load();
        }

        //탭 컨트롤 
        var dec = "<?=$exhibitionStream[0]['tab']?>";
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

        $("#li0").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/exhibition-files/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li1").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li2").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li3").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li4").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/program/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            } 
        });

        $("#li5").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load('/exhibition-stream/set-attendance/' + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li6").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/set-question/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li7").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/notice/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li8").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream/answer-survey/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            }
        });

        $("#li9").click(function () {
            if ($(this).attr("class") == "active") {
                $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);           
            }
        });
    });

    function updateLastViewTime() {
        var exhibition_users_id = "<?=$exhibition_users_id?>";
        jQuery.ajax({
            url: "/exhibition-stream/update-last-view-time/" + exhibition_users_id, 
            method: 'POST',
            type: 'json',
        });
    }
    
    function countViewer () {
        jQuery.ajax({
            url: "/exhibition-stream/count-viewer/" + <?= $exhibitionStream[0]['exhibition_id'] ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            $("#viewer").html(data.count + "명");
        });
    }

    function updateLiveDurationTime () {
        jQuery.ajax({
            url: "/exhibition-stream/get-live-duration-time/" + <?= $exhibitionStream[0]['id'] ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            var time = new Date(data.time * 1000).toISOString().substr(11, 8);
            $("#live_duration_time").html(time);
        });
    }
    
</script>
