<style>
    .vod-ul {
        margin: 2% 0 2% 3%;
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

    .chapter {
        font-size: 2rem;
    }

    .arrow--vod2 {
        width: 20px;
    }

    .table-type2 {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .table-type2 a:nth-child(2n) .chapter--div {
        background-color: #ffbbcc;
    }

    .table-type2 a:nth-child(3n) .chapter--div {
        background-color: #ffeecc;
    }

    .table-type2 a:nth-child(4n) .chapter--div {
        background-color: #ccddff;
    }

    /* .table-type2 a:nth-child(odd) {
        background-color: lightgrey;
    } */
    .table-type .tr-row {
        padding: 15px 0px 15px 0px;
    }

    .chapter--title {
        /* margin-left: 20px; */
        font-size: 1.6rem;
        margin-top: 30px;
    }

    .chapter--title__char {
        font-size: 12px;
        top: 28px;
        position: absolute;
    }

    .chapter--div {
        width: 90%;
        height: 360px;
        margin-bottom: 30px;
        margin-right: 15px;
        background-color: #F2D6B8;
        border-radius: 10%;
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .table-type2 a.vod--chapter {
        width: 25%;
    }

    .chapter--title {
        font-size:17px;
    }

    .tr {
        text-align:center;
    }
    .vod-time {
        position: absolute;
        right: 0;
        bottom: 15px;
    }
    .vod-li {
        margin-top: 5%;
        padding: 0px 0px 15px 0px;
        position: relative;
        padding-left: 25px;
        padding-right: 80px;
        line-height: 24px;
    }
    .vod--li__title {
        word-break: keep-all;
    }
    @media screen and (max-width: 768px) {
        .table-type2 a.vod--chapter {
            width: 50%;
        }
        .table-type2 a.vod--chapter {
            width: 100%;
        }
        .chapter--div {
            height: 130px;
            border-radius: 0;
            width: 100%;
        }
        .section-my .table-type {
            position: static;
            padding: 12px;
        }
        .section-my .s-hty1 {
            margin-left: 12px;
        }
    }
</style>

<div id="container">
    <div class="contents">
        <div class="section-webinar4">
            <div class="webinar-cont">
                <div class="section-my">
                    <h3 class="s-hty1">??????</h3>
                    <div class="table-type table-type2">
                        <?php foreach ($exhibitionVod as $list) : ?>

                            <a class="vod--chapter" href="/exhibition-stream/vods/<?= $exhibition->id ?>/<?= $exhibition_users_id ?>/<?= $list['id'] ?>">
                                <div class="chapter--div">
                                    <div class="tr">
                                        <div class="chapter" style="display: flex;">
                                            <!-- <span class="chapter--title__char">???</span> -->
                                            <p class="chapter--title"><?= $list['title'] ?></p>
                                        </div>
                                        <br><br>
                                        <!-- <ul class="vod-ul">
                                    <?php foreach ($list['child_exhibition_vod'] as $vod) : ?>
                                        <li class="vod-li"><a href="/exhibition-stream/watch-exhibition-vod/<?= $exhibition->id ?>/<?= $vod['id'] ?>/<?= $exhibition_users_id ?>"><?= $vod['title'] ?></a><span class="vod-time"><?= sprintf('%02d:%02d:%02d', (round($vod['duration']) / 3600), (round($vod['duration']) / 60 % 60), round($vod['duration']) % 60) ?></span></li>
                                    <?php endforeach; ?>
                                    </ul> -->
                                    </div>
                                </div>
                            </a>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- webinar-tab -->
            <div id="webinar-tab" class="webinar-tab">
                <div class="webinar-tab-top">
                    <div class="webinar-toggle">
                        <button type="button" class="webinar-tab-tg">????????????</button>
                    </div>
                    <div class="w-tab-wrap">
                        <div class="w-tab-wrap-inner">
                            <ul class="w-tab">
                                <li id="li11" class=""><button type="button" id="tab11" name="??????">??????</button></li>
                                <?php if ($exhibition->is_vod == 2) : ?>
                                    <li id="li10" class=""><button type="button" id="tab10" name="????????? ??????">????????? ??????</button></li>
                                <?php endif; ?>
                                <li id="li8" class="" style="display:none;"><button type="button" id="tab8" name="??????">??????</button></li>
                                <li id="li7" class="" style="display:none;"><button type="button" id="tab7" name="????????????">????????????</button></li>
                                <li id="li6" class="" style="display:none;"><button type="button" id="tab6" name="?????? ??????">?????? ??????</button></li>
                                <li id="li4" class="" style="display:none;"><button type="button" id="tab4" name="????????????">????????????</button></li>
                                <li id="li3" class="" style="display:none;"><button type="button" id="tab3" name="????????? ??????">????????? ??????</button></li>
                                <li id="li2" class="" style="display:none;"><button type="button" id="tab2" name="????????? ??????">????????? ??????</button></li>
                                <li id="li1" class="" style="display:none;"><button type="button" id="tab1" name="?????? ??????">?????? ??????</button></li>
                                <li id="li0" class="" style="display:none;"><button type="button" id="tab0" name="??????">??????</button></li>
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

<script>
    $(document).ready(function () {
        $("#li11").click();
    });

    //go top when open tab
    $(document).on("click", ".webinar-tab-tg", function() {
        if (!$("#toggle").hasClass("close")) {
            window.scrollTo(0, 0);
        }
    });

    //??? ????????? 
    var dec = "<?= $exhibition->vod_tab ?>";
    dec = parseInt(dec);
    var bin = dec.toString(2);
    if (bin.length < 10) {
        var zero = '';
        for (i = 0; i < 10 - bin.length; i++) {
            zero += '0';
        }
        bin = zero + bin;
    }
    for (i = 0; i < bin.length; i++) {
        var result = bin.substring(i, i + 1);
        if (parseInt(result) == 1) {
            $("#li" + i).attr("style", "display:true");
        }
    }

    var now = new Date();
    now = now.toISOString();
    var chatInterval

    $("#li0").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/exhibition-files/" + <?= $exhibition->id ?>);
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
        $("#li10").attr("class", "");
        $("#li11").attr("class", "");
    });

    $("#li1").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");
    });

    $("#li2").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");

    });

    $("#li3").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");

    });

    $("#li4").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/program/" + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");

    });

    $("#li5").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load('/exhibition-stream/set-attendance/' + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");

    });

    $("#li6").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/vod-set-question/<?= $exhibition->id ?>/<?= $exhibition_users_id ?>");
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
        $("#li11").attr("class", "");

    });

    $("#li7").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/notice/" + <?= $exhibition->id ?>);
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
        $("#li11").attr("class", "");

    });

    $("#li8").click(function() {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/answer-survey/<?= $exhibition->id ?>/<?= $exhibition_users_id ?>");
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
        $("#li11").attr("class", "");

    });

    $("#li9").click(function() {
        $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?= $exhibition->id ?> + "/" + now);
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
        $("#li11").attr("class", "");

    });

    $("#li10").click(function() {
        location.replace("/exhibition-stream/watch-exhibition-stream/<?= $exhibition->id ?>/<?= $exhibition_users_id ?>");
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
        $("#li11").attr("class", "");

    });

    $("#li11").click(function() {
        $(".webinar-tab-body").load("/exhibition-stream/vod-chapter-tab/<?= $exhibition->id ?>/<?= $exhibition_users_id ?>");
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
        $("#li11").attr("class", "active");

    });

    $(document).on("click", ".tr-row", function(){
        if($(this).children('.tab-chapter').next().is(":visible")){
            $(this).children('.tab-chapter').next().slideUp();
            $(this).children('.tab-chapter').children('.arrow--vod__2').children('.arrow--vod2').css("transform","rotate(90deg)");
           
        }
        else {
            $(this).children('.tab-chapter').next().slideDown();
            $(this).children('.tab-chapter').children('.arrow--vod__2').children('.arrow--vod2').css("transform","rotate(0deg)");
            // $(this).prop("disabled", true);
        }
    });
</script>