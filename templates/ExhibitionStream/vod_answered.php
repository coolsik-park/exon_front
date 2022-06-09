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
                <p class="tx">
                    <?php echo $exhibitionQuestion['contents'] ?>
                </p>
                <br>  
                <p class="s-hty2">
                    연사자 답변
                </p>
                <p class="tx">
                    <?php foreach($answeredQuestions as $answer): ?>
                        <?php if($answer['parent_id'] == $exhibitionQuestion['id']) : ?>
                            <?=$answer['contents']?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </p>  
            </div>
            <div class="con2">
                <button type="button" id="<?= $exhibitionQuestion['id'] ?>" name="<?= $exhibitionQuestion['exhibition_users_id'] ?>" class="btn1 click">수정하기</button>
                <button type="button" id="<?= $exhibitionQuestion['id'] ?>" class="btn2">삭제</button>
            </div>
        </li>
    <?php
        }
    ?>
    </ul>
</div>

<script>
$(".click").on("click", function () {
    $(this).parent().children().hide();
    $(this).parent().append('<textarea id="contents"></textarea><button type="button" id="'+$(this).attr('id')+'" name="'+$(this).attr('name')+'" class="btn1 edit">수정</button>')
});

$(document).on("click", ".edit", function () {
    if ($('#contents').val() === null) {
        alert('답변을 입력해주세요.');
        return false;
    }
    let parent_id = $(this).attr("id");
    let users_id = $(this).attr("name");
    let contents = $(this).prev().val();
    $(this).remove();
    jQuery.ajax({
        url: "/exhibition-stream/vod-set-answered/" + <?= $id ?>, 
        method: 'POST',
        type: 'json',
        data: {
            parent_id: parent_id,
            contents: contents,
            action: 'edit'
        }
    }).done(function() {
        alert("수정되었습니다.");
        $("#questionContent").load("/exhibition-stream/vod-answered/" + <?= $id ?>);
    });
});

$(".btn2").click(function () {
    if (confirm('질문 삭제 시 더 이상 이 질문을 볼 수 없으며, 참가자들에게도 나타나지 않습니다.\n정말 삭제하시겠습니까?')) {
        let id = $(this).attr("id");
        jQuery.ajax({
            url: "/exhibition-stream/set-answered/" + <?= $id ?>, 
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                action: 'delete'
            }
        }).done(function() {
            alert("삭제되었습니다.");
            $("#questionContent").load("/exhibition-stream/vod-answered/" + <?= $id ?>);
        });
    }
});   
</script>