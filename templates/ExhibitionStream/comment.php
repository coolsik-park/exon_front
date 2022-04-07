<div id="container">
    <div id="commentCount">
        <span class="t2">comments <?= count($exhibition_comments) ?>개</span>
    </div>
    <div class="col-dd col-cell">
        <div class="col-td">
            <input type="text" class="ipt" id="commentMessage">
        </div>
        <button type="button" class="btn-ty3" id="commentButton">답글</button>
    </div>
    <div id="comment">
        <?php 
            foreach ($exhibition_comments as $exhibition_comment): 
                if ($exhibition_comment->parent_id == null):
        ?>
                    <div class="td-col col1 conts">
                        <?php 
                            echo $exhibition_comment->user_name;
                            if ($exhibition_comment->created != $exhibition_comment->modified) {
                                echo date("Y.m.d", strtotime($exhibition_comment->modified)) . "(수정)";
                            } else {
                                echo date("Y.m.d", strtotime($exhibition_comment->created));
                            }
                        ?>
                    </div>
                    <!-- <div class="td-col col2">:</div> -->
                    <div id="editButton">
                        <button type="button" id="commentEdit" name="<?= $exhibition_comment->id ?>">수정</button>
                    </div>
                    <button type="button" id="commentDelte" name="<?= $exhibition_comment->id ?>">삭제</button>
                    <div><?= $exhibition_comment->message ?></div>
                    <?php if (array_key_exists($exhibition_comment->id, $commentUnder)): ?>
                        <details>
                            <summary>댓글 <?= count($commentUnder[$exhibition_comment->id]) ?>개</summary>
                            <?php foreach ($commentUnder[$exhibition_comment->id] as $commentUnder): ?>
                                <div class="td-col col1 conts" id="commentUnder">
                                    <?php
                                        echo $commentUnder->user_name;
                                        if ($commentUnder->created != $commentUnder->modified) {
                                            echo date("Y.m.d", strtotime($commentUnder->modified)) . "(수정)";
                                        } else {
                                            echo date("Y.m.d", strtotime($commentUnder->created));
                                        }
                                    ?>
                                </div>
                                <div id="underEditButton">
                                    <button type="button" id="underCommentEdit" name="<?= $commentUnder->id ?>">수정</button>
                                </div>
                                <button type="button" id="underCommentDelte" name="<?= $commentUnder->id ?>">삭제</button>
                                <div><?= $commentUnder->message ?></div>
                            <?php endforeach; ?>
                            <div class="col-td">
                                <input type="text" class="ipt" id="underCommentMessage">
                            </div>
                            <button type="button" class="btn-ty3" id="underCommentButton" name="<?= $exhibition_comment->id ?>">답글</button>
                        </details>
                    <?php endif; ?>
        <?php 
                endif;
            endforeach; 
        ?>
    </div>
</div>

<script>
    var user_id = <?= $user ?>;

    $('#commentButton').on('click', function() {
        var message = document.getElementById('commentMessage').value;

        $.ajax({
            url: '/exhibition-stream/comment-add',
            method: 'POST',
            type: 'json',
            data: {
                exhibition_stream_id: 59,
                users_id: user_id,
                message : message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 추가되었습니다.");
                $("#container").load(document.URL + "#container");
            } else {
                alert("답글 추가에 실패하였습니다.");
            }
        });
    });

    $('#underCommentButton').on('click', function() {
        var id = $('#underCommentButton').attr('name');
        var message = document.getElementById('underCommentMessage').value;

        $.ajax({
            url: '/exhibition-stream/comment-add',
            method: 'POST',
            type: 'json',
            data: {
                exhibition_stream_id: 59,
                users_id: user_id,
                parent_id: id,
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 추가되었습니다.");
                // 대댓글 추가 부분 새로 고침 수정
                $("#container").load(document.URL + "#container");
            } else {
                alert("답글 추가에 실패하였습니다.");
            }
        });
    });

    $(document).on('click', 'button[id=commentEdit]', function () {
        var id = $('#commentEdit').attr('name');

        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="commentEditMessage">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="commentEidtButton" name="' + id  + '">수정</button>';
        html += '</div>';
        $("#editButton").html(html);
    });

    $(document).on('click', 'button[id=commentEidtButton]', function () {
        var id = $('#commentEidtButton').attr('name');
        var message = document.getElementById('commentEditMessage').value;
        
        $.ajax({
            url: '/exhibition-stream/comment-edit/' + id,
            method: 'PATCH',
            type: 'json',
            data: {
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 수정되었습니다.");
                $("#container").load(document.URL + "#container");
            } else {
                alert("답글 수정에 실패하였습니다.");
            }
        });
    });

    $(document).on('click', 'button[id=underCommentEdit]', function () {
        var id = $('#underCommentEdit').attr('name');

        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underCommentEditMessage">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="underCommentEidtButton" name="' + id  + '">수정</button>';
        html += '</div>';
        $("#underEditButton").html(html);
    });

    $(document).on('click', 'button[id=underCommentEidtButton]', function () {
        var id = $('#underCommentEidtButton').attr('name');
        var message = document.getElementById('underCommentEditMessage').value;
        
        $.ajax({
            url: '/exhibition-stream/comment-edit/' + id,
            method: 'PATCH',
            type: 'json',
            data: {
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 수정되었습니다.");
                $("#container").load(document.URL + "#container");
            } else {
                alert("답글 수정에 실패하였습니다.");
            }
        });
    });

    // $('#commentDelte').on('click', function (){
    $(document).on('click', 'button[id=commentDelte]', function (){
        var id = $('#commentDelte').attr('name');

        if (confirm("댓글을 삭제사히겠습니까?") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("댓글 삭제에 되었습니다.");
                    $("#container").load(document.URL + "#container");
                } else {
                    alert("댓글 삭제에 실패하였습니다.");
                }
            });
        }
    });

    // $('#underCommentDelte').on('click', function (){
    $(document).on('click', 'button[id=underCommentDelte]', function (){
        var id = $('#underCommentDelte').attr('name');

        if (confirm("댓글을 삭제사히겠습니까?") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("댓글 삭제에 되었습니다.");
                    $("#container").load(document.URL + "#container");
                } else {
                    alert("댓글 삭제에 실패하였습니다.");
                }
            });
        }
    });
</script>