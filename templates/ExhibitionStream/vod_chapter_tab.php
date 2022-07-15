<style>
    .tab-chapter {
        position: relative;
        padding: 12px;
    }
    .arrow--vod__2 {
        position: absolute;
        right: 0px;
        top: 0px;
    }
    /* .table-type .tr-row {
        height: 40px;
    } */
    .vod--tab__ul .vod-li {
        margin-top: 2%;
    }
    .vod-li {
        margin-top: 5%;
    }
    .tab--ul {
        display: none;
    }
    .arrow--vod2 {
        transform: rotate( 90deg );
    }
    .chapterTab--li__title {
        font-size: 1rem;
    }
    .tab-vod-time {
        font-size: 1rem;
        float: right;
    }

    @media screen and (max-width: 768px) {
        .chapterTab--li__title {
            font-size: 0.9rem;
        }
        .tab-vod-time {
            font-size: 0.9rem;
            float: right;
        }
    }
</style>


<div class="webinar-cont2">
    <div class="table-type table-type2" style="margin:0px 20px;">      
    <?php foreach ($exhibitionVod as $list) : ?>              
        <div class="tr-row">
            <div class="tab-chapter">
                <p><?=$list['title']?></p> 
                <a style="" class="c arrow--vod__2" name="<?=$list['id']?>">
                    <img id="" class="chapter-icon arrow--vod2" src="/img/arrow-down-sign-to-navigate.png">
                </a>
            </div>
            <ul class="vod-ul tab--ul vod--tab__ul">
            <?php foreach ($list['child_exhibition_vod'] as $vod) : ?>
                <?php if ($exhibition_users_id == 0) : ?>
                    <li class="vod-li chapterTab--li__title"><a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibition->id?>/<?=$vod['id']?>"><?=$vod['title']?></a><span class="tab-vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span></li>
                <?php else : ?>
                    <li class="vod-li chapterTab--li__title"><a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibition->id?>/<?=$vod['id']?>/<?=$exhibition_users_id?>"><?=$vod['title']?></a><span class="tab-vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span></li>
                <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
        <br>
    <?php endforeach; ?>
    </div>                   
</div>

<script>
    // $(document).on("click", ".arrow--vod__2", function(){
    //     if($(this).parent().parent().next().hasClass('visible')){
    //         $(this).parent().parent().next().css("display", "none");
    //         $(this).css("transform","rotate(0deg)");
    //         $(this).parent().parent().next().removeClass('visible');
    //         // $(this).parent().parent().next().next().css("height", "50px");
    //         // $(this).parent().parent().next().next().children('.tab-chapter').children( 'p' ).css("margin-top", "15px");
    //     }
    //     else {
    //         $(this).parent().parent().next().css("display", "block");
    //         $(this).css("transform","rotate(0deg)");
    //         $(this).parent().parent().next().addClass('visible')
    //         // $(this).parent().parent().next().next().css("height", "37px");
    //     }
    // });
    // $(document).on("click", ".tr-row", function(){
    //     if($(this).children('.tab-chapter').next().is(":visible")){
    //         $(this).children('.tab-chapter').next().slideUp();
    //         $(this).children('.tab-chapter').children('.arrow--vod__2').children('.arrow--vod2').css("transform","rotate(90deg)");
           
    //     }
    //     else {
    //         $(this).children('.tab-chapter').next().slideDown();
    //         $(this).children('.tab-chapter').children('.arrow--vod__2').children('.arrow--vod2').css("transform","rotate(0deg)");
    //         // $(this).prop("disabled", true);
    //     }
    // });
    
</script>