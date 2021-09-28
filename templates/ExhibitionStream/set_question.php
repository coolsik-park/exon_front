<!-- <div id = "questionContent">
    <div class="column-responsive column-80">
        <div class="exhibitionStream form content"> 
            <table class="table table-bordered"> 
                <tr>
                    <td id = "all" class ="imgs">전체</td>
                <?php
                    if (count($exhibitionSpeakers) != 0) {
                        foreach ($exhibitionSpeakers as $exhibitionSpeaker) { 
                ?> 
                    <td id = <?= $exhibitionSpeaker['id'] ?> class ="imgs">
                        <img style = "width:50px; height:50px;" src = <?= DS . $exhibitionSpeaker['image_path'] . DS . $exhibitionSpeaker['image_name'] ?>>
                        <br>
                        <?php echo $exhibitionSpeaker['name']; ?>
                    </td>
                <?php 
                        }
                    } 
                ?>
                </tr> 
            </table>
            
            <table class="table table-bordered"> 
                <?php 
                    foreach($exhibitionQuestions as $exhibitionQuestion) { 
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['id' => $exhibitionQuestion['exhibition_users_id']])->toArray();
                        $user_name = $exhibitionUser[0]['users_name'];
                ?>
                <tr>  
                    <td><?php echo $user_name ?></td>
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
                    <?php
                        
                        $user_id = $exhibitionUser[0]['users_id'];
                        if ($user_id == $current_user_id) {
                    ?>
                    <td><?php echo $this->Form->control('삭제', ['id' => $exhibitionQuestion['id'], 'class' => 'delete', 'type' => 'button', 'label' => '']) ?></td>
                </tr>
                <?php   
                        } 
                    } 
                ?> 
            </table>

            <?= $this->Form->create() ?>
            <?php
                echo $this->Form->control('target', ['type' => 'hidden']);
                echo $this->Form->control('question', ['type' => 'text']);     
            ?>
            <?= $this->Form->end() ?>
            <?= $this->Form->button('전송', ['id' => 'add']) ?>
        </div>
    </div>
</div> -->

<div class="webinar-cont1">
    <h3 class="sr-only">질의 응답</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty4-body">                                    
            <div class="sect-ovf1">
                <ul class="ph-items">
                    <li class="box" id="all">
                        <div class="ph-item">
                            <div class="photo"></div>
                            <div class="tx">전체</div>
                        </div>
                    </li>
                    <?php
                        if (count($exhibitionSpeakers) != 0) {
                            foreach ($exhibitionSpeakers as $exhibitionSpeaker) { 
                    ?> 
                    <li class="box" id=<?= $exhibitionSpeaker['id'] ?>>
                        <div class="ph-item">
                            <div class="photo"><img style = "width:100%; height:100%;" src = <?= DS . $exhibitionSpeaker['image_path'] . DS . $exhibitionSpeaker['image_name'] ?>></div>
                            <div class="tx"><?php echo $exhibitionSpeaker['name']; ?></div>
                        </div>
                    </li>
                    <?php 
                            }
                        } 
                    ?>
                </ul>
            </div>
            <div class="sect-ovf2">
                <ul class="ph2-items">
                <?php 
                    foreach($exhibitionQuestions as $exhibitionQuestion) { 
                        $exhibitionUser = $ExhibitionUsers->find('all')->where(['id' => $exhibitionQuestion['exhibition_users_id']])->toArray();
                        $user_name = $exhibitionUser[0]['users_name'];
                ?>
                    <li>
                        <div class="con1">
                            <p class="s-hty2"><?php echo $user_name ?> > 
                            <?php
                                if ($exhibitionQuestion['target_users_name'] == null) {
                                    echo '전체';
                                } else {
                                    echo $exhibitionQuestion['target_users_name'];
                                }
                            ?>
                            </p>
                            <p class="tx"><?php echo $exhibitionQuestion['contents'] ?></p>    
                        </div>
                        <?php
                            $user_id = $exhibitionUser[0]['users_id'];
                            if ($user_id == $current_user_id) {
                        ?>
                        <div class="con2">
                            <button type="button" id="<?= $exhibitionQuestion['id'] ?>" class="btn-ty3">삭제</button>
                        </div>
                    </li>
                <?php   
                        } 
                    } 
                ?> 
                </ul>
            </div>
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">
                <input type="text" id="question" style="width:70%">                                        
                <button id="add" class="btn-ty4 redbg">제출</button>
                <input type="hidden" id="target">
            </div>
        </div>
    </div>                               
</div>

<script>
    $(".box").click(function () {
        $(".box").css("border", "none");
        $(this).css("border", "1px solid red");
        $("#target").val($(this).attr('id'));
    });

    $("button#add").click(function () {
        jQuery.ajax({
            url: "/exhibition-stream/set-question/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                action: 'add',
                target: $("#target").val(),
                question: $("#question").val()
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
                $(".webinar-tab-body").load("/exhibition-stream/set_question/" + <?= $id ?>);
            }
        });
    });

    $(".btn-ty3").click(function () {
        var id = $(this).attr("id");
        jQuery.ajax({
            url: "/exhibition-stream/set-question/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                action: 'delete'
            }
        }).done(function(res) {
            if (res.status == 'success') {
                alert("삭제되었습니다.");
                $(".webinar-tab-body").load("/exhibition-stream/set_question/" + <?= $id ?>);
            }
        });
    }); 
</script>   