<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <script src="./videojs-http-streaming.min.js"></script>
</head>
<body>
    <!-- <video-js id=vid1 width=600 height=300 class="vjs-default-skin vjs-big-play-centered" controls>
        <source src = <?= "http://121.126.223.225:80/live/" . $exhibitionStream[0]['stream_key'] . "/index.m3u8" ?> type = "application/x-mpegURL", id = "source">
    </video-js>

<br><br>
<div>
    <p> 제목 : <?= $exhibitionStream[0]['title'] ?></p>
    <p> 설명 : <?= $exhibitionStream[0]['description'] ?></p>
</div>

<div class="column-responsive column-80">
    <div class="exhibitionStream form content">
    <fieldset>
        <legend><?= __('Set Exhibition Stream Tab') ?></legend>
            <?php
                $i = 9;
                foreach ($tabs as $tab) {
                    echo $this->Form->button($tab->title, ['id' => 'tab' . $i, 'name' => $tab->title, 'type' => 'button']). ' ';
                    $i--;
                }
            ?>
        </fieldset>
    </div>
</div>
<div id = "tabContent"></div> -->


<div id="container">       
        
        <div class="contents">            
            <div class="section-webinar4">
                <div class="webinar-cont">
                    <div class="wb-cont1">
                        <video-js id=vid1 width=600 height=300 class="vjs-default-skin vjs-big-play-centered" controls>
                            <source src = <?= "http://121.126.223.225:80/live/" . $exhibitionStream[0]['stream_key'] . "/index.m3u8" ?> type = "application/x-mpegURL", id = "source">
                        </video-js>
                    </div>
                    <div class="wb-cont2">
                        <h3 class="w-tit"><?= $exhibitionStream[0]['title'] ?></h3>
                        <div class="w-desc">
                            <p class="wd1"><span class="w-dt">스트리밍 시간 :</span><span class="w-dd">1:21:08</span></p>
                            <p class="wd2"><span class="w-dt">시청자 :</span><span class="w-dd">50명</span></p>
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

</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>    
    videojs('vid1').play();
</script>
<script>
    $("button#tab0").click(function () {
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
    });

    $("button#tab1").click(function () {
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
    });

    $("button#tab2").click(function () {
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
    });

    $("button#tab3").click(function () {
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
    });

    $("button#tab4").click(function () {
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
    });

    $("button#tab5").click(function () {
        $(".webinar-tab-body").load('/exhibition-stream/set-attendance/' + <?= $exhibitionStream[0]['exhibition_id'] ?>);
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
        
    });

    $("button#tab6").click(function () {
        $(".webinar-tab-body").load("/exhibition-stream/set-question/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
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
    });

    $("button#tab7").click(function () {
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
    });

    $("button#tab8").click(function () {
        $(".webinar-tab-body").load("/exhibition-stream/answer-survey/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
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
    });

    $("button#tab9").click(function () {
        $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
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
    });
</script>
