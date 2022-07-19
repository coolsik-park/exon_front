<style>
    #container {
        position: relative;
    }
    .chapter {
        font-size: 25px;
    }
    .vod-ul {
        margin:2% 0 2% 3%;
        font-size: 1.5rem;
    }
    .vod-li {
        margin-top: 5%;
        padding: 0px 0px 15px 0px;
        position: relative;
        padding-left: 25px;
        padding-right: 80px;
        line-height: 35px;
    }
    .vod-time {
        float: right;
        font-size: 20px;
    }
    .section-webinar4 .webinar-tab.close .webinar-tab-tg {
        top: 78px;
    }
     .arrow--vod2 {
        width: 20px;
    }
    .table-type .tr-row2 {
        border-bottom: 0px;
    }
    .table-type .tr-row {
        padding: 15px 0;
    }
    .chapter--menu__div {
        font-size: 1rem;
        position: absolute;
        right: 0%;
        top: 60px;
        z-index: 10;
    }
    .section-my {
        position: relative;
    }
    .vod--li__title {
        word-break: keep-all;
    }
    .chapter--menu__img {
        width: 20px;
    }
    .chapter--title__char {
        font-size: 16px;
        top: 0px;
        left: 0px;
        position: absolute;
    }
    .vod-time {
        position: absolute;
        right: 0;
        bottom: 15px;
    }
    .s-hty1 {
        line-height: 0;
    }
    @media screen and (max-width: 768px) {
        .section-my {
            padding: 12px;
            margin-bottom: 100px;
        }
        .section-my .s-hty1 {
            margin-bottom: 65px;
            /* padding-right: 90px; */
            word-break: keep-all;
            line-height: 40px;
        }
        .chapter--menu__div {
            right: 4%;
            top: 60px;
        }
        .vod-time {
            padding-right: 12px;
        }
        .table-type .tr-row {
            padding: 0;
        }
        .vod-ul {
            margin:2% 0 2% 3%;
            font-size: 0.9rem;
        }
        .vod-time {
            font-size: 0.9rem;
        }
        .chapter--title__char {
            font-size: 0.9rem;
            top: 0px;
            left: 0px;
            position: absolute;
        }
        .vod-li {
            margin-top: 5%;
            padding: 0px 0px 15px 0px;
            position: relative;
            padding-left: 25px;
            padding-right: 80px;
            line-height: 24px;
        }
      
    }
</style>

<div id="container">      
    <div class="contents">      
        <div class="section-webinar4">
            <div class="webinar-cont vods--div">
                <div class="section-my">
                    <div class="chapter--menu__div">
                        <a class="chapter--menu__a" href="/exhibition-stream/vod-chapter/<?=$exhibition->id?>/<?=$exhibition_users_id?>">
                            <img class="chapter--menu__img" src="/img/menu-button-of-three-horizontal-lines.png" /> <span>목록 보기</span>
                        </a>
                    </div> 
                    <h3 class="s-hty1"><?=$chapter['title']?></h3>
                    <div class="table-type table-type2">                  
                        <div class="tr-row2">
                            <ul class="vod-ul">
                            <?php foreach ($vods as $vod) : ?>
                                <a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibition->id?>/<?=$vod['id']?>/<?=$exhibition_users_id?>" style="width: 100%;   border-bottom: 1px solid black;">
                                <li class="vod-li">
                                <span class="chapter--title__char">○</span><span class="vod--li__title"><?=$vod['title']?></span><span class="vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span>
                                </li>
                                </a>
                                <br>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <br>
                    </div>
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
                                <li id="li11" class=""><button type="button" id="tab11" name="목록">목록</button></li>
                                <?php if ($exhibition->is_vod == 2) : ?>
                                <li id="li10" class=""><button type="button" id="tab10" name="라이브 시청">라이브 시청</button></li>
                                <?php endif; ?>
                                <li id="li8" class="" style="display:none;"><button type="button" id="tab8" name="설문">설문</button></li>
                                <li id="li7" class="" style="display:none;"><button type="button" id="tab7" name="공지사항">공지사항</button></li>
                                <li id="li6" class="" style="display:none;"><button type="button" id="tab6" name="질의 응답">질의 응답</button></li>
                                <li id="li4" class="" style="display:none;"><button type="button" id="tab4" name="프로그램">프로그램</button></li>
                                <li id="li3" class="" style="display:none;"><button type="button" id="tab3" name="담당자 정보">담당자 정보</button></li>
                                <li id="li2" class="" style="display:none;"><button type="button" id="tab2" name="개설자 정보">개설자 정보</button></li>
                                <li id="li1" class="" style="display:none;"><button type="button" id="tab1" name="행사 정보">행사 정보</button></li>
                                <li id="li0" class="" style="display:none;"><button type="button" id="tab0" name="자료">자료</button></li>
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

    //탭 컨트롤 
    var dec = "<?=$exhibition->vod_tab?>";
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
    var chatInterval

    $("#li0").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/exhibition-files/" +<?=$exhibition->id?>);
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

    $("#li1").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/exhibition-info/" + <?=$exhibition->id?>);
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

    $("#li2").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/founder/" + <?=$exhibition->id?>);
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

    $("#li3").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/person-in-charge/" + <?=$exhibition->id?>);
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

    $("#li4").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/program/" + <?=$exhibition->id?>);
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

    $("#li5").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load('/exhibition-stream/set-attendance/' + <?=$exhibition->id?>);
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

    $("#li6").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/vod-set-question/<?=$exhibition->id?>/<?=$exhibition_users_id?>");
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

    $("#li7").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/notice/" + <?=$exhibition->id?>);
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

    $("#li8").click(function () {
        clearInterval(chatInterval);
        $(".webinar-tab-body").load("/exhibition-stream/answer-survey/<?=$exhibition->id?>/<?= $exhibition_users_id ?>");
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

    $("#li9").click(function () {
        $(".webinar-tab-body").load("/exhibition-stream-chat-log/chat/" + <?=$exhibition->id?> + "/" + now);
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

    $("#li10").click(function () {
        location.replace("/exhibition-stream/watch-exhibition-stream/<?=$exhibition->id?>/<?=$exhibition_users_id?>");
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

    $("#li11").click(function () {
        $(".webinar-tab-body").load("/exhibition-stream/vod-chapter-tab/<?= $exhibition->id ?>/<?=$exhibition_users_id?>");
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