<div class="webinar-cont2">
    <h3 class="sr-only">담당자 정보</h3>
    <div class="webinar-cont-ty2">                                
        <div class="manager-info">
            <div class="manager-profile">
                <div class="photo">
                    <?php echo $this->Html->image(DS . $user['image_path'] . DS . $user['image_name'], ['width' => '100%', 'height' => '100%']); ?>
                </div>
                <div class="desc">
                    <h4 class="s-hty3"><?php echo $user['name'] ?></h4>
                    <div class="ment">
                        <p>오르카티비 PD입니다 </p>
                    </div>
                </div>
            </div>
            
            <div class="info">
                <p>이메일 : <?php echo $user['email'] ?></p>
                <p>연락처 : 
                    <?= 
                        substr($user['hp'], 0, 3) . '-' . substr($user['hp'], 3, 4) . '-' . substr($user['hp'], 7, 4)  
                    ?>
                </p>
            </div>
        </div>
        <!-- // -->
    </div>                               
</div>