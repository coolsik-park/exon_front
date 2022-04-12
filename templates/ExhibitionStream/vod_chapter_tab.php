<div class="webinar-cont2">
    <div class="table-type table-type2" style="margin:20px;">      
    <?php foreach ($exhibitionVod as $list) : ?>              
        <div class="tr-row">
            <div class="chapter">
                <p><?=$list['title']?></p>
            </div>
            <ul class="vod-ul">
            <?php foreach ($list['child_exhibition_vod'] as $vod) : ?>
                <li class="vod-li"><a href="/exhibition-stream/watch-exhibition-vod/<?=$exhibitionStream[0]['exhibition_id']?>/<?=$vod['id']?>/<?=$exhibition_users_id?>"><?=$vod['title']?></a><span class="vod-time"><?=sprintf('%02d:%02d:%02d', (round($vod['duration'])/3600),(round($vod['duration'])/60%60), round($vod['duration'])%60)?></span></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <br>
    <?php endforeach; ?>
    </div>                   
</div>