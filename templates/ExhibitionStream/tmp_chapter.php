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
        border-bottom: 1px solid black;
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
        position: absolute;
        top: 20px;
        width: 85%;
        height: 50px;
        cursor: default;
    }

    .chapter--title__char {
        font-size: 16px;
        top: 25px;
        left: 0px;
        position: absolute;
    }
    .vod--li__date {
        margin-left: 25px;
    }
    .vod--li__description {
        margin-left: 25px;
    }
    .vod--info__div {
        margin-top: 80px;
        display: none;
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
</style>

<div id="container">
    <div class="contents">
        <div class="section-webinar3">
            <div class="webinar-cont">
                <div class="section-my">
                    <h3 class="s-hty1"><?= $exhibition->title ?></h3>
                    <div class="table-type table-type2">
                        <div class="tr-row">
                          
                                <?php $i = 0; ?>
                                <?php foreach ($tmp_exhibitions as $tmp_exhibition) : ?>
                                    <ul class="vod-ul">
                                        <li class="vod-li vod--title__div">
                                            <span class="chapter--title__char">○</span>
                                            <span class="vod--li__title"><?= $tmp_exhibition['title'] ?></span>
                                            <?php if ($tmp_exhibition_streams[$i]['live_started'] == null) : ?>
                                                <button type="button" id="copy_stream_key" class="btn-ty2 bor vod-time">라이브 시청</button>
                                            <?php else : ?>
                                                <a class="vod--a" href="/exhibition-stream/watch-exhibition-stream/<?= $tmp_exhibition['id'] ?>/<?= $exhibition_users_id ?>/<?= $cert ?>" style="">
                                                    <button type="button" id="copy_stream_key" class="btn-ty2 red vod-time"> 라이브 시청 </button>
                                                </a>
                                            <?php endif; ?>
                                        </li>
                                    <li class="vod-li vod--info__div">
                                            <span class="vod--li__date"><?=$tmp_exhibition['sdate']?> ~ <?=$tmp_exhibition['edate']?></span><br><br>
                                            <span class="vod--li__description"><?=$tmp_exhibition['description']?></span>
                                    </li>
                                    <br>
                                    </ul>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                           
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".vod--li__title", function(){
        if( $(this).parent().next().hasClass('visible')){
            // $(this).parent().next().slideUp();
            $(this).parent().next().css("display", "none");
            $(this).parent().parent().css("height", "80px");
            $(this).parent().next().removeClass('visible');
            $(this).css("border", "none");
        }
        else {
            // $(this).parent().next().slideDown();
            $(this).parent().next().css("display", "block");
            $(this).parent().parent().css("height", "240px");
            $(this).parent().next().addClass('visible');
            $(this).css("border-bottom", "1px solid lightgrey");
        }
    });

</script>