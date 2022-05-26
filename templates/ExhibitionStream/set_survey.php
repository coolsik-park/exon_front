<style>
    .webinar-cont-ty1-body::-webkit-scrollbar {
    width: 10px;
    }
    .webinar-cont-ty1-body::-webkit-scrollbar-thumb {
        background-color: #2f3542;
        border-radius: 10px;
        background-clip: padding-box;
        border: 2px solid transparent;
    }
    .webinar-cont-ty1-body::-webkit-scrollbar-track {
        background-color: grey;
        border-radius: 10px;
        box-shadow: inset 0px 0px 5px white;
    }
    input[type="checkbox"] {
        display: none;
    }
    input[type="radio"] {
        display: none;
    }
</style>

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
                    <?php for ($j = 0; $j < $count; $j++) : ?>
                        <p><?=$j+1?>. <?=$groupedSurvey['child_exhibition_survey'][$j]['text']?></p>
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