<div>
    방송화면
<div>
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
