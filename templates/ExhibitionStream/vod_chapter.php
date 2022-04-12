<style>
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
</style>

<div id="container">       
    <div class="contents">      
        <div class="section-webinar4">
            <div class="webinar-cont">
                <div class="section-my">
                    <h3 class="s-hty1">VOD 목록</h3>
                    <div class="table-type table-type2">      
                    <?php foreach ($exhibitionVod as $list) : ?>              
                        <div class="tr-row">
                            <div class="chapter">
                                <p><?=$list['title']?></p>
                            </div>
                            <ul class="vod-ul">
                            <?php foreach ($list['child_exhibition_vod'] as $vod) : ?>
                                <li class="vod-li"><a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibition->id?>/<?=$vod['id']?>/<?=$exhibition_users_id?>"><?=$vod['title']?></a><span class="vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                        <br>
                    <?php endforeach; ?>
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
                                <!-- <li id="li9" class="" style="display:none;"><button type="button" id="tab9" name="실시간 채팅">실시간 채팅</button></li> -->
                                <li id="li8" class="" style="display:none;"><button type="button" id="tab8" name="설문">설문</button></li>
                                <li id="li7" class="" style="display:none;"><button type="button" id="tab7" name="공지사항">공지사항</button></li>
                                <li id="li6" class="" style="display:none;"><button type="button" id="tab6" name="질의 응답">질의 응답</button></li>
                                <!-- <li id="li5" class="" style="display:none;"><button type="button" id="tab5" name="출석체크">출석체크</button></li> -->
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
        $(".webinar-tab-body").load("/exhibition-stream/set-question/" + <?=$exhibition->id?>);
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
</script>