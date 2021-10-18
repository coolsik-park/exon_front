<!-- <div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <?= $this->Form->create() ?>
        <?php
            if ($groupedSurveys[0] != '') {
                foreach ($groupedSurveys as $groupedSurvey) { 
        ?>
        <input type ="checkbox" name = "checked" value = <?= $groupedSurvey['id'] ?>>
        <table class="table table-bordered">  
            <tr>  
                <td><?php echo $groupedSurvey['text']; ?></td>
            </tr>
            <?php 
                    $count = count($groupedSurvey['child_exhibition_survey']);
                    if ($count != 0) {
                        for ($i = 0; $i < $count; $i++) {
            ?>
            <tr>
                <td><?php echo $groupedSurvey['child_exhibition_survey'][$i]['text']; ?></td>
            </tr>
            <?php 
                        }
                    }
            ?>
        </table>
        <br>
        <?php 
                }
            } else {
                echo "등록된 설문이 없습니다.";
            }
        ?>  

        <?= $this->Form->end() ?>
        <?= $this->Form->button('확인', ['id' => 'add']) ?>
    </div>
</div> -->

<div class="webinar-cont1">
    <h3 class="sr-only">설문</h3>
    <div class="webinar-cont-ty1">
        <div class="webinar-cont-ty1-body">                                    
            <div class="poll-item-wrap">
                <p class="poll-item-b-tit">노출시킬 설문을 선택해 주세요</p>
                <?php if ($groupedSurveys[0] != '') : ?>
                <?php $i = 0; ?>
                <?php foreach ($groupedSurveys as $groupedSurvey) : ?>
                <div class="poll-item-b">
                    <?php if ($groupedSurvey->is_display == 'Y') : ?>
                    <span class="chk-dsg"><input type="checkbox" id="chk<?=$i?>" name="checked" value="<?=$groupedSurvey->id?>" checked="checked"><label for="chk<?=$i?>"><?=$groupedSurvey->text?></label></span>
                    <?php else : ?>
                    <span class="chk-dsg"><input type="checkbox" id="chk<?=$i?>" name="checked" value="<?=$groupedSurvey->id?>"><label for="chk<?=$i?>"><?=$groupedSurvey->text?></label></span>
                    <?php endif; ?>
                    <div class="b-list">
                    <?php $count = count($groupedSurvey['child_exhibition_survey']); ?>
                    <?php if ($count != 0) : ?>      
                    <?php for ($i = 0; $i < $count; $i++) : ?>
                        <p><?=$i+1?>. <?=$groupedSurvey['child_exhibition_survey'][$i]['text']?></p>
                    <?php endfor; ?>
                    <?php endif; ?> 
                    </div>
                </div>
                <?php $i++; ?>
                <?php endforeach; ?>
                <?php endif; ?>                             
            </div>
        </div>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button type="button" id="surveySave" class="btn-ty4 redbg">확인</button>
            </div>
        </div>
    </div>                            
</div>

<script>
    $("#surveySave").click(function () {
        var checkedLists = [];
        var uncheckedLists = [];
        
        $("input[name='checked']").each(function () { 
            if ($(this).prop("checked") == true) {
                checkedLists.push($(this).val());
            } else {
                uncheckedLists.push($(this).val());
            }
        });
        
        jQuery.ajax({
            url: "/exhibition-stream/set-survey/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                checkedLists: checkedLists,
                uncheckedLists: uncheckedLists
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });
</script>