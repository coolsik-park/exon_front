<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video-js.min.css" rel="stylesheet"> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/video.js/7.8.1/video.min.js"></script>
    <script src="./videojs-http-streaming.min.js"></script>
</head>
<body>
    <video-js id=vid1 width=600 height=300 class="vjs-default-skin vjs-big-play-centered" controls>
        <source
           src="http://121.126.223.225:80/live/abcd/index.m3u8",
           type= "application/x-mpegURL">
      </video-js>
      <script>
      var player = videojs('vid1');
      player.play();
      </script>

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
<div id = "tabContent"></div>
</body>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script>
    $("button#tab0").click(function () {
        $("div#tabContent").load("/exhibition-stream/exhibition-files/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab1").click(function () {
        $("div#tabContent").load("/exhibition-stream/exhibition-info/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab2").click(function () {
        $("div#tabContent").load("/exhibition-stream/founder/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab3").click(function () {
        $("div#tabContent").load("/exhibition-stream/person-in-charge/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab4").click(function () {
        $("div#tabContent").load("/exhibition-stream/program/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab5").click(function () {
        window.open('/exhibition-stream/set-attendance/' + <?= $exhibitionStream[0]['exhibition_id'] ?>, '출석체크', 'width=460px,height=140px');
    });

    $("button#tab6").click(function () {
        $("div#tabContent").load("/exhibition-stream/set-question/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab7").click(function () {
        $("div#tabContent").load("/exhibition-stream/notice/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab8").click(function () {
        $("div#tabContent").load("/exhibition-stream/answer-survey/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });

    $("button#tab9").click(function () {
        $("div#tabContent").load("/exhibition-stream-chat-log/chat/" + <?= $exhibitionStream[0]['exhibition_id'] ?>);
    });
</script>
