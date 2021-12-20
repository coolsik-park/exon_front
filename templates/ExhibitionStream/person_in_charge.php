<div class="webinar-cont2">
    <h3 class="sr-only">담당자 정보</h3>
    <div class="webinar-cont-ty2">
        <div class="manager-info">
            <h4 class="s-hty3"><?php echo $exhibition[0]['name'] ?></h4>
            <div class="ment">
                <!-- <p>오르카티비 PD입니다</p> -->
            </div>
            <div class="info">
                <p>이메일 : <?php echo $exhibition[0]['email'] ?></p>
                <p>연락처 : 
                    <?= 
                        substr($exhibition[0]['tel'], 0, 3) . '-' . substr($exhibition[0]['tel'], 3, 4) . '-' . substr($exhibition[0]['tel'], 7, 4)  
                    ?>
                </p>
            </div>
        </div>
        <!-- // -->
        
    </div>                               
</div>