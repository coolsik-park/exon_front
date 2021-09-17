<div class="column-responsive column-80">
    <div class="exhibitionStream form content"> 
        <?= $this->Form->create() ?>
        <table class="table table-bordered" id="dynamic_field"> 
            <?php
                if (count($exhibitionQuestions) != 0) {
                    echo $this->Form->control('exhibition', ['type' => 'hidden', 'value' => $exhibitionQuestions[0]['exhibition_user']['exhibition_id']]);
                }  
            ?>
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
                <td><?php echo $this->Form->control('답변완료', ['id' => $exhibitionQuestion['id'], 'name' => $exhibitionQuestion['exhibition_users_id'], 'class' => 'answered', 'type' => 'button', 'label' => '']) ?></td>
                <td><?php echo $this->Form->control('삭제', ['id' => $exhibitionQuestion['id'], 'class' => 'delete', 'type' => 'button', 'label' => '']) ?></td>
            </tr>
            <?php } ?> 
        </table>
        <?= $this->Form->end() ?>
    </div>
</div>

<script>
$(document).ready(function(){    
    $(".answered").click(function () {
        var parent_id = $(this).attr("id");
        var users_id = $(this).attr("name");
        jQuery.ajax({
            url: "/exhibition-stream/set-answered/" + $("#exhibition").val(), 
            method: 'POST',
            type: 'json',
            data: {
                parent_id: parent_id,
                users_id: users_id,
                action: 'answered'
            }
        }).done(function() {
            alert("답변 완료 처리되었습니다.");
            $("#questionContent").load("/exhibition-stream/set-answered/" + <?= $id ?>);
        });
    });

    $(".delete").click(function () {
        var id = $(this).attr("id");
        jQuery.ajax({
            url: "/exhibition-stream/set-answered/" + $("#exhibition").val(), 
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                action: 'delete'
            }
        }).done(function() {
            alert("삭제되었습니다.");
            $("#questionContent").load("/exhibition-stream/set-answered/" + <?= $id ?>);
        });
    });    
});
