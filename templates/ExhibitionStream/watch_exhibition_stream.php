
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
        .chapter {
            font-size: 25px;
        }
        .vod-ul {
            margin:2% 0 2% 3%;
            font-size: 20px;
        }
        .vod-li {
            margin-top: 1%;
        }
        .vod-time {
            float: right;
        }
        .section-webinar4 .webinar-tab.close .webinar-tab-tg {
            top: 78px;
        }
        .webinar-cont-ty1-body {
            height: calc(100% - 100px);
            overflow: hidden;
            overflow-y: auto;
        }
        .msgln {
            word-break: break-word;
        }
    </style>
</head>

<div id="container">       
    <div class="contents">      
        <div class="section-webinar4">
            <div class="webinar-cont">
                <div class="wb-cont1">
                    <video class="video-js vjs-default-skin vjs-big-play-centered" id="vid1" autoplay muted webkit-playsinline playsinline><source id="vid1-src" src="https://orcaexon.co.kr/live/<?=$exhibitionStream[0]['stream_key']?>/index.m3u8" type="application/x-mpegURL"></video>
                </div>
                <div class="wb-cont2">
                    <?php if ($exhibition->id == 295 || $exhibition->id == 296 || $exhibition->id == 297) : ?>
                        <div class="w-desc">
                            <p class="wd1"><span class="w-dt"></span></p>
                            <p class="wd2"></span><button class="btn-ty4 red korean" style="border:2px solid black;">Korean</button> <button class="btn-ty4 red english">English</button></p>
                        </div>
                    <?php endif; ?>
                    <h3 class="w-tit"><?= $exhibitionStream[0]['title'] ?></h3>
                    <div class="w-desc">
                        <p class="wd1"><span class="w-dt"></span></p>
                        <p class="wd2"><span class="w-dt">시청자 : </span><span id="viewer" class="w-dd">0명</span></p>
                    </div>
                </div>   
                <div class="wb-cont2">
                    <a href="<?=$front_url?>" class="btn-ty4 black">나가기</a>
                </div>                
            </div>

            <!-- webinar-tab -->
            <div id="webinar-tab" class="webinar-tab">
                <div class="webinar-tab-top">
                    <div class="webinar-toggle">
                        <button type="button" class="webinar-tab-tg">토글버튼</button>                           
                    </div>  
                    <div class="w-tab-wrap">
                        <div class="w-tab-wrap-inner">
                            <ul class="w-tab">
                                <?php if ($exhibition->id == 295 || $exhibition->id == 296 || $exhibition->id == 297) : ?>
                                    <li id="li10" class=""><button type="button" id="tab10" name="트랙 이동">트랙 이동</button></li>
                                <?php endif; ?>
                                <li id="li9" class="" style="display:none;"><button type="button" id="tab9" name="실시간 채팅">실시간 채팅</button></li>
                                <li id="li8" class="" style="display:none;"><button type="button" id="tab8" name="설문">설문</button></li>
                                <li id="li7" class="" style="display:none;"><button type="button" id="tab7" name="공지사항">공지사항</button></li>
                                <li id="li6" class="" style="display:none;"><button type="button" id="tab6" name="질의 응답">질의 응답</button></li>
                                <li id="li5" class="" style="display:none;"><button type="button" id="tab5" name="출석체크">출석체크</button></li>
                                <li id="li4" class="" style="display:none;"><button type="button" id="tab4" name="프로그램">프로그램</button></li>
                                <li id="li3" class="" style="display:none;"><button type="button" id="tab3" name="담당자 정보">담당자 정보</button></li>
                                <li id="li2" class="" style="display:none;"><button type="button" id="tab2" name="개설자 정보">개설자 정보</button></li>
                                <li id="li1" class="" style="display:none;"><button type="button" id="tab1" name="행사 정보">행사 정보</button></li>
                                <li id="li0" class="" style="display:none;"><button type="button" id="tab0" name="자료">자료</button></li>
                                <!-- <li id="vod" class=""><button type="button" id="tabVod" name="vod">VOD</button></li> -->
                            </ul>
                        </div>                            
                    </div>
                </div>   
                <!-- // top -->
                <?= $this->Form->create() ?>   
                <div class="webinar-tab-body">  
                       
                </div>
                <?php $this->Form->end(); ?>    
                <!-- // body-->
            </div>
            <!-- //webinar-tab -->
        </div>
    </div>    
</div>
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color:transparent; border:none;">
            <div class="popup-wrap popup-ty2">
                <div class="popup-head">
                    <h1>공유하기</h1>
                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                </div>
                <br>
                <div class="popup-body">
                    <img id="blog" class="popup-img" src ="/img/blog.png" onclick="naverShare()">
                    <img id="kakao" class="popup-img" src ="/img/kakao.png" onclick="kakaoShare()">
                    <img id="inst" class="popup-img" src ="/img/inst.png" onclick="instShare()">
                    <img id="fb" class="popup-img" src ="/img/fb.png" onclick="fbShare()">
                    <div class="copy">
                        <input type="text" id="url" value="https://exon.live/exhibition/view/<?=$id?>" readonly><button type="button" id="url-copy" class="btn">복사</button>
                    </div>
                </div>
                <div class="popup-btm">
                </div>
            </div>
        </div>
    </div>
</div>

<script> 
    var chatInterval

    //auto redirect
    function autoRedirect() {
        jQuery.ajax({
            url: "/exhibition-stream/auto-redirect/" + <?= $exhibition_users_id ?>, 
            method: 'POST',
            success: function (data) {
                if (data.status == 'redirect') {
                    alert('다른 브라우저에서 접속하였습니다. 메인페이지로 이동합니다.');
                    location.href = '/';
                }
            }
        });
    }

    //auto attendance
    jQuery.ajax({
        url: "/exhibition-stream/auto-attendance/" + <?= $exhibition_users_id ?>, 
        method: 'POST',
        type: 'json',
    });

    //go top when open tab
    $(document).on("click", ".webinar-tab-tg", function() {
        if (!$("#toggle").hasClass("close")) {
            window.scrollTo(0, 0);
        }
    });

    //video.js
    let player = videojs('vid1', {
        html5: {
            vhs: {
                overrideNative: !videojs.browser.IS_SAFARI
            },
            nativeAudioTracks: false,
            nativeVideoTracks: false
        },
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

    //11월 행사 전용 코드
    let is_english = 0;

    $(document).on('click', '.english', function () {
        if (is_english === 0) {
            if (!player.paused) {
                player.pause();
            }
                
            player.src({ type: 'application/x-mpegURL', src: 'https://orcaexon.co.kr/live/<?=$exhibitionStream[0]['stream_key']?>_eng/index.m3u8' });
            
            player.load();
            player.play();

            is_english = 1;
            $(this).css('border', '2px solid black');
            $(this).prev().css('border', '1px solid red');
        }
    });

    $(document).on('click', '.korean', function () {
        if (is_english === 1) {
            if (!player.paused) {
                player.pause();
            }
                
            player.src({ type: 'application/x-mpegURL', src: 'https://orcaexon.co.kr/live/<?=$exhibitionStream[0]['stream_key']?>/index.m3u8' });
            
            player.load();
            player.play();

            is_english = 0;
            $(this).css('border', '2px solid black');
            $(this).next().css('border', '1px solid red');
        }
    });
    
    // 방송 중 체크
    // $(document).ready(function () {
    //     $.ajax({
    //         url: "https://orcaexon.co.kr/live/<?=$exhibitionStream[0]['stream_key']?>/index.m3u8",
    //         type: 'HEAD',
    //         error: function () {
    //             window.location.replace("/exhibition-stream/stream-not-exist");
    //         }
    //     });
    // });
    
    //잘못된 접근 차단
    var ref = document.referrer;
    var pass = 0;
    if (ref != '<?= $front_url ?>/exhibition/view/<?=$exhibitionStream[0]['exhibition_id']?>' 
            && ref != '<?= $front_url ?>/exhibition-users/sign-up/application' 
            && ref != '<?= $front_url ?>/exhibition-stream/certification/<?=$exhibitionStream[0]['exhibition_id']?>' 
            && ref.indexOf('<?= $front_url ?>/exhibition-users/add/<?=$exhibitionStream[0]['exhibition_id']?>') 
            && ref.indexOf('<?= $front_url ?>/exhibition-stream/vod-chapter/<?=$exhibitionStream[0]['exhibition_id']?>') 
            && ref.indexOf('<?= $front_url ?>/exhibition-stream/vods/<?=$exhibitionStream[0]['exhibition_id']?>') 
            && ref.indexOf('<?= $front_url ?>/exhibition-stream/watch-exhibition-vod/<?=$exhibitionStream[0]['exhibition_id']?>') 
            && ref.indexOf('<?= $front_url ?>/exhibition-stream/tmp-chapter/298/') && ref.indexOf('<?= $front_url ?>/exhibition-stream/watch-exhibition-stream/')
        ) {
        alert('허용되지 않는 잘못된 접근입니다.');
        history.go(-1);
    }

    $(document).ready(function () {
        //시청자수 카운트
        setInterval("updateLastViewTime()" , 1000);
        setInterval("countViewer()" , 3000);
        setInterval("liveEndCheck()", 1000);
        setInterval("autoRedirect()" , 5000);

        //탭 컨트롤 
        var dec = "<?=$exhibition->live_tab?>";
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
                $("#li" + i).attr("style", "display:true");
            }
        }

        var now = new Date();
        now = now.toISOString();
        if (bin.substring(9,10) == 1) {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream[0]['exhibition_id'] ?> + "/" + now + "/" + <?=$exhibition_users_id?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "active");
            $("#li10").attr("class", "");           
        }

        $("#li0").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/exhibition-files/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "active");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#vod").attr("class", "");
        });

        $("#li1").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "active");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li2").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "active");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li3").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "active");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li4").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/program/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "active");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li5").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load('/exhibition-stream/set-attendance/' + <?= $exhibitionStream[0]['exhibition_id'] ?> + '/' + <?= $exhibition_users_id ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "active");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li6").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/set-question/" + <?= $exhibitionStream[0]['exhibition_id'] ?> + '/' + <?= $exhibition_users_id ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "active");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li7").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/notice/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "active");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li8").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/answer-survey/<?= $exhibitionStream[0]['exhibition_id'] ?>/<?= $exhibition_users_id ?>");
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "active");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "");   
            $("#vod").attr("class", "");
        });

        $("#li9").click(function () {
            $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream[0]['exhibition_id'] ?> + "/" + now + "/" + <?=$exhibition_users_id?>);
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "active"); 
            $("#li10").attr("class", "");                 
            $("#vod").attr("class", "");
        });

        $("#li10").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/tmp-chapter-tab/298/<?=$exhibition_users_id?>/<?=$cert?>");
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");
            $("#li10").attr("class", "active");               
            $("#vod").attr("class", "");
        });

        $("#vod").click(function () {
            clearInterval(chatInterval);
            $(".webinar-tab-body").load("/exhibition-stream/vod-chapter-tab/<?= $exhibitionStream[0]['exhibition_id'] ?>/<?=$exhibition_users_id?>");
            $("#li0").attr("class", "");
            $("#li1").attr("class", "");
            $("#li2").attr("class", "");
            $("#li3").attr("class", "");
            $("#li4").attr("class", "");
            $("#li5").attr("class", "");
            $("#li6").attr("class", "");
            $("#li7").attr("class", "");
            $("#li8").attr("class", "");
            $("#li9").attr("class", "");      
            $("#li10").attr("class", "");         
            $("#vod").attr("class", "active");
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

    // function updateLiveDurationTime () {
    //     jQuery.ajax({
    //         url: "/exhibition-stream/get-live-duration-time/" + <?= $exhibitionStream[0]['id'] ?>, 
    //         method: 'POST',
    //         type: 'json',
    //     }).done(function(data) {
    //         var time = new Date(data.time * 1000).toISOString().substr(11, 8);
    //         $("#live_duration_time").html(time);
    //     });
    // }

    function liveEndCheck () {
        jQuery.ajax({
            url: "/exhibition-stream/live-end-check/" + <?= $exhibitionStream[0]['id'] ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            if (data.end == 1) {
                setTimeout(function() {
                    window.location.replace("/exhibition-stream/stream-not-exist");
                }, 30000);
            }
        });
    }
    
</script>
