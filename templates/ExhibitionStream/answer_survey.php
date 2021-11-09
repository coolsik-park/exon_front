<style>
  .poll-item-wrap::-webkit-scrollbar {
    width: 10px;
  }
  .poll-item-wrap::-webkit-scrollbar-thumb {
    background-color: #2f3542;
    border-radius: 10px;
    background-clip: padding-box;
    border: 2px solid transparent;
  }
  .poll-item-wrap::-webkit-scrollbar-track {
    background-color: grey;
    border-radius: 10px;
    box-shadow: inset 0px 0px 5px white;
  }
</style>

<div class="webinar-cont1">
    <h3 class="sr-only">설문</h3>
    <div class="webinar-cont-ty1">
        <form id="surveyForm">
            <div class="webinar-cont-ty1-body">                                    
                <div class="poll-item-wrap" style="overflow: auto; height:659px;">
                    <?php if (!empty($exhibitionSurveys)) : ?>
                        <?php $i=0; ?>
                        <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
                            <?php if ($exhibitionSurvey->is_multiple == 'N') : ?>
                                <div class="poll-item">
                                    <p class="poll-q"><?=$exhibitionSurvey->text?></p>
                                    <div class="poll-a">
                                        <textarea name="exhibition_survey_users_answer.<?=$i?>.text" cols="30" rows="5"></textarea>
                                        <?php $i++; ?>
                                    </div>
                                </div>
                            <?php else : ?>
                                <div class="poll-item">
                                    <p class="poll-q"><?=$exhibitionSurvey->text?></p>
                                    <input type="hidden" name="exhibition_survey_users_answer.<?=$i?>.text" value="question">
                                    <?php $i++; ?>
                                    <div class="poll-a">
                                        <?php if ($exhibitionSurvey->is_duplicate == 'N') : ?>
                                            <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
                                            <div class="ln-rdo">
                                                <span class="chk-dsg"><input type="radio" id="<?=$child->id?>" name="<?=$child->parent_id?>"><label for="<?=$child->id?>"><?=$child->text?></label></span>
                                                <input type="hidden" id="<?=$child->id?>" name="exhibition_survey_users_answer.<?=$i?>.text" class="<?=$child->parent_id?>" value="">
                                                <?php $i++; ?>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
                                            <div class="ln-rdo">
                                                <span class="chk-dsg"><input type="checkbox" id="<?=$child->id?>" name="<?=$child->parent_id?>"><label for="<?=$child->id?>"><?=$child->text?></label></span>
                                                <input type="hidden" id="<?=$child->id?>" name="exhibition_survey_users_answer.<?=$i?>.text" class="<?=$child->parent_id?>" value="">
                                                <?php $i++; ?>
                                            </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </form>
        <div class="webinar-cont-ty1-btm">
            <div class="poll-submit">                                        
                <button id="send" class="btn-ty4 redbg">확인</button>
            </div>
        </div>
    </div>                            
</div>


<script>
    $(":input:radio").change(function () {
        var id = $(this).attr("id");
        var name = $(this).attr("name")
        $(":input:hidden[class=" + name + "]").val('');
        $(":input:hidden[id=" + id + "]").val("Y"); 
    });

    $(":input:checkbox").change(function () {
        var id = $(this).attr("id");
        if ($(":input:hidden[id=" + id + "]").val() == 'Y' ) {
            $(":input:hidden[id=" + id + "]").val(""); 
        } else {
            $(":input:hidden[id=" + id + "]").val("Y"); 
        }
    });

    $("#send").click(function () {
        $(":input:radio").removeAttr("name");
        var formData = $("#surveyForm").serialize();
        jQuery.ajax({
            url: "/exhibition-stream/answer-survey/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: formData,
        }).done(function(data) {
            if (data.status == 'success') {
                alert("전송되었습니다.");
                $(".webinar-tab-body").load("/exhibition-stream/answer-survey/" + <?= $id ?>);
            } else {
                alert("전송에 실패하였습니다. 잠시후 다시 시도해주세요.");
            }
        });
    });
</script>