<input type = "button" id = "speaker" value = "연사자">
<input type = "button" id = "question" value = "질문">
<input type = "button" id = "answered" value = "답변완료">

<div class="column-responsive column-80">
    <div class="exhibitionStream form content" id="test"> 
        <?= $this->Form->create() ?>
        <table class="table table-bordered" id="dynamic_field"> 
            <?php
                if (count($exhibitionQuestions) != 0) {
                    echo $this->Form->control('exhibition', ['type' => 'hidden', 'value' => $exhibitionQuestions[0]['exhibition_user']['exhibition_id']]);
                }  
            ?>
            <?php foreach($exhibitionQuestions as $exhibitionQuestion) { ?>
            <tr>  
                <td><?php echo $exhibitionQuestion['exhibition_user']['users_name'] ?></td>
                <td>-></td>
                <td><?php echo $exhibitionQuestion['target_users_name'] ?></td>
            </tr> 
            <tr>
                <td><?php echo $exhibitionQuestion['contents'] ?></td>
            </tr>
            <?php } ?> 
        </table>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>  
$(document).ready(function(){
    $("#speaker").click(function () {
        $("#tabContent").load("/exhibition-stream/set-speaker/" + <?= $id ?>);
    });

    $("#question").click(function () {
        $("#tabContent").load("/exhibition-stream/set-answered/" + <?= $id ?>);
    });

    $("#answered").click(function () {
        $("#tabContent").load("/exhibition-stream/answered/" + <?= $id ?>);
    });
});
</script>  