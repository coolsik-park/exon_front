<!-- <div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <table class="table table-bordered" id="dynamic_field"> 
            <?php 
                foreach($exhibitionQuestions as $exhibitionQuestion) { 
            ?>
            <tr>  
                <td><?php echo $exhibitionQuestion['exhibition_user']['users_name'] ?></td>
                <td>-></td>
                <?php
                    if ($exhibitionQuestion['target_users_name'] == null) {
                ?>
                        <td><?php echo '전체'; ?></td>
                <?php
                    } else {
                ?>
                        <td><?php echo $exhibitionQuestion['target_users_name'] ?></td>
                <?php
                    }
                ?>
                <td><?php echo $exhibitionQuestion['contents'] ?></td>
            </tr>
            <?php } ?> 
        </table>
    </div>
</div> -->

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
                    > <?php echo '전체'; ?>
                <?php
                     } else {
                ?>
                    > <?php echo $exhibitionQuestion['target_users_name'] ?>
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