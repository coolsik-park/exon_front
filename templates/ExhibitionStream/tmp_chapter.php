<style>
    #container {
        position: relative;
    }

    .chapter {
        font-size: 25px;
    }

    .vod-ul {
        margin: 2% 0 2% 3%;
        font-size: 1.5rem;
      
        height: 80px;
    }

    .vod-li {
        margin-top: 5%;
        padding: 0px 0px 20px 0px;
        position: relative;
       
    }

    .vod-time {
        float: right;
        margin-bottom:10px;
    }

    .section-webinar4 .webinar-tab.close .webinar-tab-tg {
        top: 78px;
    }

    .arrow--vod2 {
        width: 20px;
    }

    .table-type .tr-row {
        border-bottom: 0px;
        margin-bottom: 70px;
    }

    .chapter--menu__div {
        font-size: 1rem;
        position: absolute;
        right: 0%;
        top: 20%;
    }

    .section-my {
        position: relative;
    }

    .chapter--menu__img {
        width: 20px;
    }

    .vod--li__title {
        margin-left: 25px;
        top: 0px;
        height: 50px;
        cursor: default;
        position: absolute;
        font-size: 24px;
        font-weight: 500;
    }

    .chapter--title__char {
        font-size: 16px;
        position: absolute;
        top: 5px;
    }
    .vod--li__date {
        line-height: 25px;
    }
    .vod--li__description {
        position: relative;
        /* margin-left: 25px; */
    }
    .vod--info__div {
        margin-top: 80px;
    }
    a {
        cursor: pointer;
    }
    button {
        cursor: pointer;
    }
    #copy_stream_key {
        cursor: pointer;
        position: absolute;
        left: 1045px;
    }
    .table-type2 {
        padding-bottom: 100px;
    }
    .vod--row__div {
        margin-bottom: 50px;
    }
    .tr-row__vod {
        border-bottom: 1px solid black;
        display: flex;
        width: 100%;
        position: relative;
        padding-bottom: 40px;
        font-size: 18px;
    }
    .vod--img__div {
        width: 30%;
        height: 200px;
    }
    .vod--date__div {
        width: 30%;
        height: 200px;
        padding: 0px 50px;
        display: flex;
        flex-direction: column;
    }
    .vod--dec__div {
        width: 40%;
        height: 200px;
        padding: 0px 20px;
        display: flex;
        flex-direction: column;
        word-break:keep-all;
    }   
    .vod--img {
        width: 100%;
        height: 200px;
    }
    .vod--dec__char {
        /* position: absolute; */
    }
    .vod--title__span {
        margin-bottom: 10px;
        font-weight: 500;
    }
</style>


    <div class="contents">
        <div class="section-webinar3">
            <div class="webinar-cont">
                <div class="section-my">
                    <h3 class="s-hty1"><?= $exhibition->title ?></h3>
                    <div class="table-type table-type2">
                        
                            <?php $i = 0; ?>
                            <?php foreach ($tmp_exhibitions as $tmp_exhibition) : ?>
                                <div class="vod--row__div">
                                    <div class="tr-row__vod">
                                        <span class="chapter--title__char">○</span>
                                        <span class="vod--li__title"><?= $tmp_exhibition['title'] ?></span>
                                        <?php if ($tmp_exhibition_streams[$i]['live_started'] == null) : ?>
                                            <button type="button" id="copy_stream_key" class="btn-ty2 bor vod-time">라이브 시청</button>
                                        <?php else : ?>
                                            <a class="vod--a" href="/exhibition-stream/watch-exhibition-stream/<?= $tmp_exhibition['id'] ?>/<?= $exhibitionUsers[$i]['id'] ?>/<?= $cert ?>" style="">
                                                <button type="button" id="copy_stream_key" class="btn-ty2 red vod-time"> 라이브 시청 </button>
                                            </a>
                                        <?php endif; ?>

                                            <div class="vod-li vod--img__div">
                                                <img src="/<?=$tmp_exhibition['image_path']?>/<?=$tmp_exhibition['image_name']?>" class="vod--img" />
                                            </div>
                                            <div class="vod-li vod--date__div">
                                                <span class="vod--title__span">일시</span>
                                                <span class="vod--li__date"><?=date("Y.m.d A h:i", strtotime($tmp_exhibition['sdate']))?> ~ <br> <?=date("Y.m.d A h:i", strtotime($tmp_exhibition['edate']))?></span><br><br>
                                            </div>
                                            <div class="vod-li vod--dec__div">
                                                <span class="vod--title__span">- 행사 내용</span>
                                                <span class="vod--li__description"><?=$tmp_exhibition['description']?></span>
                                            </div>
                                    </div>
                                </div>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    // $(document).on("click", ".vod--li__title", function(){
    //     if( $(this).parent().next().hasClass('visible')){
    //         // $(this).parent().next().slideUp();
    //         $(this).parent().next().css("display", "none");
    //         $(this).parent().parent().css("height", "80px");
    //         $(this).parent().next().removeClass('visible');
    //         $(this).css("border", "none");
    //     }
    //     else {
    //         // $(this).parent().next().slideDown();
    //         $(this).parent().next().css("display", "block");
    //         $(this).parent().parent().css("height", "240px");
    //         $(this).parent().next().addClass('visible');
    //         $(this).css("border-bottom", "1px solid lightgrey");
    //     }
    // });

</script>