<style>
    *{
        font-size:1.06rem;
    }
</style>
<div id="wbCon3">
    <h4 class="sr-only">답변완료</h4>
    <ul class="ph2-items">
    <?php 
        foreach($exhibitionQuestions as $exhibitionQuestion) { 
    ?>
        <li>
            <div class="con1">
                <p class="s-hty2"><?php echo $exhibitionQuestion['exhibition_user']['users_name'] ?>
                <?php
                    if ($exhibitionQuestion['target_users_name'] == null) {
                ?> 
                    → <?php echo '전체'; ?>
                <?php
                     } else {
                ?>
                    → <?php echo $exhibitionQuestion['target_users_name'] ?>
                <?php
                     }
                ?>
                </p>
                <p class="tx"><?php echo $exhibitionQuestion['contents'] ?></p>    
            </div>
        </li>
    <?php
        }
    ?>
    </ul>
</div>