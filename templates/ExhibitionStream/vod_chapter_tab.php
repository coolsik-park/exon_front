<style>
    .tab-chapter {
        position: relative;
    }
    .arrow--vod__1 {
        position: absolute;
        right: 0px;
        top: 0px;
    }
    .table-type .tr-row {
        height: 40px;
    }
    .vod-li {
        margin-top: 2%;
    }
    .tab--ul {
        display: none;
    }
    .arrow--vod2 {
        transform: rotate( 90deg );
    }
</style>


<div class="webinar-cont2">
    <div class="table-type table-type2" style="margin:20px;">      
    <?php foreach ($exhibitionVod as $list) : ?>              
        <div class="tr-row">
            <div class="tab-chapter">
                <p><?=$list['title']?></p> 
                <a style="" class="c arrow--vod__1" name="<?=$list['id']?>">
                    <img id="arrow--vod" class="chapter-icon arrow--vod2" src="/img/arrow-down-sign-to-navigate.png">
                </a>
            </div>
            <ul class="vod-ul tab--ul">
            <?php foreach ($list['child_exhibition_vod'] as $vod) : ?>
                <li class="vod-li"><a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibition->id?>/<?=$vod['id']?>/<?=$exhibition_users_id?>"><?=$vod['title']?></a><span class="vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <br>
    <?php endforeach; ?>
    </div>                   
</div>

<script>
     $(document).on("click", ".arrow--vod2", function(){
        if($(this).parent().parent().next().is(":visible")){
            $(this).parent().parent().next().slideUp();
            $(this).css("transform","rotate(90deg)");
        }
        else {
            $(this).parent().parent().next().slideDown();
            $(this).css("transform","rotate(0deg)");
        }
    });
</script>