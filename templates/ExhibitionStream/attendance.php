<div class="webinar-cont2">
    <h3 class="sr-only">출석체크</h3>
    <div class="webinar-cont-ty1">
        <ul class="attend-lists">
            <li class="th"><span class="wh1">이름</span><span class="wh2">인적사항</span><span class="wh3">출석여부</span></li>
            <?php foreach($exhibitionUsers as $exhibitionUser) { ?>
                <?php
                    $attend = null;
                    switch ($exhibitionUser['attend']) {
                        case 1 : $attend = '-'; break;
                        case 2 : $attend = '참석'; break;
                        case 4 : $attend = '시청완료'; break;
                    }
                ?>
                <li>
                    <span class="wd1"><?php echo $exhibitionUser['users_name'] ?></span>
                    <span class="wd2"><?php echo $exhibitionUser['users_email'] ?></span>
                    <span class="wd3"><?php echo $attend ?></span>
                </li>
            <?php } ?> 
        </ul>
    </div>                               
</div>