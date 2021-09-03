<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <?= $this->Form->create() ?>
        <?php 
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
        ?>  

        <?= $this->Form->end() ?>
        <?= $this->Form->button('확인', ['id' => 'add']) ?>
    </div>
</div>

<script>
    $("#add").click(function () {
        var lists = [];
        $("input[name='checked']:checked").each(function(i){ 
            lists.push($(this).val());
        });

        jQuery.ajax({
            url: "/exhibition-stream/survey/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                display: lists
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
            }
        });
    });
</script>