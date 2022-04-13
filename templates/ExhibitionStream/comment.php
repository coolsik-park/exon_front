<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .replies {
      /* width: 400px; */
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      /* border: 1px solid #ddd; */
    }

    .replies__item {
      padding: 0 1em;
      font-size: 16px;
    }

    .replies__item+.replies__item {
      border-top: 1px solid #ddd;
    }

    .replies__item .head {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.9em;
      padding: 0.5em 0;
    }

    .replies__item .head span+span,
    .replies__item .head button+button {
      margin-left: 0.25em;
    }

    .replies__item .muted {
      color: #888;
    }

    .replies__item button {
      padding: 0.5em 1em;
      border-radius: 2px;
      background-color: #000;
      color: #fff;
      font-size: 0.8em;
      border: 0;
    }

    .replies__item .body {
      line-height: 1.5;
      padding: 0.5em 0;
    }

    .replies__item .foot {
      padding-bottom: 1em;
      font-size: 0.8em;
    }
  </style>
<div class="container">
    <div id="commentCount">
        <span>comment <?= count($exhibition_comments) ?>개</span>
    </div>
    <div class="col-dd col-cel">
        <div class="col-td">
            <input type="text" class="ipt" id="commentMessage">
        </div>
        <div style="float:right;">
            <button type="button" class="btn-ty3" id="commentButton">댓글</button>
        </div>
    </div>
    <br><br><br>
    <div class="replies">
        <?php
            foreach ($exhibition_comments as $exhibition_comment):
                if ($exhibition_comment->parent_id == null):

        ?>
                    <div class="replies__item">
                        <div class="head">
                            <div>
                                <span><?= $exhibition_comment->user_name ?></span>
                                <span class="muted">
                                    <?php echo date("Y.m.d", strtotime($exhibition_comment->modified)); ?>
                                </span>
                            </div>
                            <?php if ($user == $exhibition_comment->users_id): ?>
                                <div id="configbutton<?= $exhibition_comment->id ?>">
                                    <button type="button" id="commentEdit" onclick="commentEditButton(<?= $exhibition_comment->id ?>)">수정</button>
                                    <button type="button" id="commentDelete" onclick="commentDeleteButton(<?= $exhibition_comment->id ?>)">삭제</button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div id="commentText<?= $exhibition_comment->id ?>"><?= $exhibition_comment->message ?></div>
                        <br>
                        <?php 
                            // foreach ($exhibition_comments_unders as $exhibition_comments_under) {
                            //     if ($exhibition_comments_under->id == $exhibition_comment->id) {
                            //         $under_comment[] = $exhibition_comments_under;
                            //     }
                            // }
                            // if (count($under_comment) != 0):
                            if (array_key_exists($exhibition_comment->id, $commentUnder)):
                        ?>
                            <div class="foot">
                                <details>
                                    <summary>답글 <?= count($commentUnder[$exhibition_comment->id]) ?>개</summary>
                                    <?php foreach ($commentUnder[$exhibition_comment->id] as $commentUnder): ?>
                                        <div class="replies__item">
                                            <div class="head">
                                                <div>
                                                    <span><?= $commentUnder->user_name ?></span>
                                                    <span class="muted">
                                                        <?php echo date("Y.m.d", strtotime($commentUnder->modified)); ?>
                                                    </span>
                                                </div>
                                                <?php if ($user == $commentUnder->users_id): ?>
                                                    <div id="underConfigButton<?= $commentUnder->id ?>">
                                                        <button type="button" id="underCommentEdit" onclick="underCommentEditButton(<?= $commentUnder->id ?>)">수정</button>
                                                        <button type="button" id="underCommentDelete" onclick="underCommentDeleteButton(<?= $commentUnder->id ?>)">삭제</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div id="underCommentText<?= $commentUnder->id ?>"><?= $commentUnder->message ?></div>
                                        </div>
                                        <br>
                                    <?php endforeach; ?>
                                    <div id="underUnderCommentAddDiv<?= $exhibition_comment->id ?>">
                                        <button type="button" id="underUnderComment" onclick="underUnderCommentButton(<?= $exhibition_comment->id ?>)">답글달기</button>
                                    </div>
                                </details>
                            </div>
                        <?php else: ?>
                            <div id="underCommentAddDiv<?= $exhibition_comment->id ?>">
                                <button type="button" id="underComment" onclick="underCommentButton(<?= $exhibition_comment->id ?>)">답글달기</button>
                            </div>
                            <br>
                        <?php endif; ?>
                    </div>
        <?php
                endif;
            endforeach;
        ?>
    </div>
    <br><br><br><br>
</div>
<script>
    var user_id = <?= $user ?>;

    $(document).on('click', 'button[id=commentButton]', function() {
        var message = document.getElementById('commentMessage').value;

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }

        $.ajax({
            url: '/exhibition-stream/comment-add',
            method: 'POST',
            type: 'json',
            data: {
                exhibition_stream_id: 59,
                users_id: user_id,
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("댓글 추가되었습니다.");
                // 새로 고침 부분 수정
                // $("#container").load(document.URL + " #container");
            } else if (data.status == 'not_user') {
                if (confirm("회원이 아닙니다.\n로그인을 하시겠습니까?")) {
                    location.href="/users/login";
                } else {
                    alert("취소되었습니다.");
                }
            } else {
                alert("댓글 추가에 실패하였습니다.");
            }
        });
    });

    function commentEditButton(id) {
        var message = document.getElementById('commentText' + id).innerHTML;
        var massage_fun = "'"+message+"'";
        
        var html_1 = '';
        html_1 += '<button type="button" id="commentDelete" onclick="commentDeleteButton(' + id  + ')">삭제</button>';
        $("#configbutton"+id).html(html_1);

        var html_2 = '';
        html_2 += '<div class="col-dd col-cell">';
        html_2 += '   <div class="col-td">';
        html_2 += '       <input type="text" class="ipt" id="commentEditMessage'+ id + '" value="' + message + '">';
        html_2 += '   </div>';
        html_2 += '   <div style="float:right;">';
        html_2 += '     <button type="button" class="btn-ty3" id="commentEidtButton" onclick="commentEidtButton(' + id  + ')">수정하기</button>';
        html_2 += '     <button type="button" class="btn-ty3" id="commentCancelButton" onclick="commentCancelButton(' + id + ',' + massage_fun + ')">수정 취소하기</button>';
        html_2 += '   </div>';
        html_2 += '   <br><br>';
        html_2 += '</div>';
        $("#commentText"+id).html(html_2);
    }

    function commentCancelButton(id, message) {  
        var html_1 = '';
        html_1 += '<button type="button" id="commentEdit" onclick="commentEditButton(' + id  + ')">수정</button>';
        html_1 += '<button type="button" id="commentDelete" onclick="commentDeleteButton(' + id  + ')">삭제</button>';
        $("#configbutton"+id).html(html_1);

        var html_2 = '';
        html_2 += message;
        $("#commentText"+id).html(html_2);
    }

    function commentEidtButton(id) {
        var message = document.getElementById('commentEditMessage'+id).value;

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }
        
        $.ajax({
            url: '/exhibition-stream/comment-edit/' + id,
            method: 'PATCH',
            type: 'json',
            data: {
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("댓글 수정되었습니다.");
                // 새로 고침 부분 수정
                // $("#container").load(document.URL + "#container");
            } else {
                alert("댓글 수정에 실패하였습니다.");
            }
        });
    }

    function commentDeleteButton(id) {
        if (confirm("댓글을 삭제사히겠습니까?") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("댓글 삭제에 되었습니다.");
                    // 새로 고침 부분 수정
                    // $("#container").load(document.URL + "#container");
                } else {
                    alert("댓글 삭제에 실패하였습니다.");
                }
            });
        }
    }

    function underCommentButton(id) {
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underCommentAddMessage'+id+'">';
        html += '   </div>';
        html += '   <div style="float:right;">';
        html += '       <button type="button" class="btn-ty3" id="underCommentAdd" onclick="underCommentAddButton(' + id  + ')">답글</button>';
        html += '       <button type="button" class="btn-ty3" id="underCommentAddCancle" onclick="underCommentAddCancleButton(' + id  + ')">취소</button>';
        html += '   </div>';
        html += '   <br><br>'
        html += '</div>';
        $("#underCommentAddDiv"+id).html(html);
    }

    function underCommentAddCancleButton(id) {
        var html = '';
        html = '<button type="button" id="underComment" onclick="underCommentButton('+ id +')">답글달기</button>';
        $("#underCommentAddDiv"+id).html(html);
    }

    function underCommentAddButton(id) {
        console.log('aaaa');
        var message = document.getElementById('underCommentAddMessage'+id).value;

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }

        $.ajax({
            url: '/exhibition-stream/comment-add',
            method: 'POST',
            type: 'json',
            data: {
                exhibition_stream_id: 59,
                users_id: user_id,
                parent_id: id,
                message : message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 추가되었습니다.");
                // 대댓글 보이게 수정
                // var html = '';
                // html += ''
            } else if (data.status == 'not_user') {
                if (confirm("회원이 아닙니다.\n로그인을 하시겠습니까?")) {
                    location.href="/users/login";
                } else {
                    alert("취소되었습니다.");
                }
            } else {
                alert("답글 추가에 실패하였습니다.");
            }
        });
    }

    function underUnderCommentButton(id) {
    // $(document).on('click', 'button[id=underUnderCommentAdd]', function() {
    //     var id= $('#underUnderCommentAdd').attr('name');
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underUnderCommentAddMessage' + id +'">';
        html += '   </div>';
        html += '   <div style="float:right;">';
        html += '       <button type="button" class="btn-ty3" id="underUnderCommentAdd" onclick="underUnderCommentAddButton(' + id  + ')">답글</button>';
        html += '       <button type="button" class="btn-ty3" id="underUnderCommentAddCancel" onclick="underUnderCommentAddCancelButton(' + id  + ')">취소</button>';
        html += '   </div>';
        html += '   <br><br>';
        html += '</div>';
        $("#underUnderCommentAddDiv"+id).html(html);
    }

    function underUnderCommentAddCancelButton(id) {
        var html = '';
        html += '<button type="button" id="underUnderComment" onclick="underUnderCommentButton(' + id + ')">답글달기</button>';
        $("#underUnderCommentAddDiv"+id).html(html);
    }

    // $(document).on('click', 'button[id=underUnderCommentAddButton]', function() {
    //     var id = $('#underUnderCommentAddButton').attr('name');
    function underUnderCommentAddButton(id) {
        var message = document.getElementById('underUnderCommentAddMessage'+id).value;

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }

        $.ajax({
            url: '/exhibition-stream/comment-add',
            method: 'POST',
            type: 'json',
            data: {
                exhibition_stream_id: 59,
                users_id: user_id,
                parent_id: id,
                message : message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("답글 추가되었습니다.");
                // 대댓글 보이게 수정
                // var html = '';
                // html += ''
            } else if (data.status == 'not_user') {
                if (confirm("회원이 아닙니다.\n로그인을 하시겠습니까?")) {
                    location.href="/users/login";
                } else {
                    alert("취소되었습니다.");
                }
            } else {
                alert("답글 추가에 실패하였습니다.");
            }
        });
    }

    // $(document).on('click', 'button[id=underCommentEdit]', function() {
    //     var id = $('#underCommentEdit').attr('name');
    function underCommentEditButton(id) {
        var message = document.getElementById('underCommentText'+id).innerHTML;
        var message_fun = "'" + message + "'";

        var html_1 = '';
        html_1 += '<button type="button" id="underCommentDelete" onclick="underCommentDeleteButton('+ id + ')">삭제</button>';
        $('#underConfigButton'+id).html(html_1);

        var html_2 = '';
        html_2 += '<div class="col-dd col-cell">';
        html_2 += '   <div class="col-td">';
        html_2 += '       <input type="text" class="ipt" id="underCommentEditMessage' + id + '" value="' + message + '">';
        html_2 += '   </div>';
        html_2 += '   <div style="float:right;">';
        html_2 += '     <button type="button" class="btn-ty3" id="underCommentEidt" onclick="underCommentEidtButton(' + id  + ')">수정하기</button>';
        html_2 += '     <button type="button" class="btn-ty3" id="underCommentEidtCancle" onclick="underCommentEidtCancleButton(' + id  + ', ' + message_fun + ')">수정 취소하기</button>';
        html_2 += '   </div>';
        html_2 += '   <br><br>';
        html_2 += '</div>';
        $("#underCommentText"+id).html(html_2);
    }

    function underCommentEidtCancleButton(id, message) {
        var html_1 = '';
        html_1 += '<button type="button" id="underCommentEdit" onclick="underCommentEditButton('+ id + ')">수정</button>';
        html_1 += '<button type="button" id="underCommentDelete" onclick="underCommentDeleteButton('+ id + ')">삭제</button>';
        $('#underConfigButton'+id).html(html_1);

<<<<<<< HEAD
    $(document).on('click', 'button[id=underCommentEidtButton]', function() {
        var id = $('#underCommentEidtButton').attr('name');
        var message = document.getElementById('underCommentEditMessage').value;
=======
        var html_2 = '';
        html_2 = message;
        $("#underCommentText"+id).html(html_2);
    }

    // $(document).on('click', 'button[id=underCommentEidtButton]', function() {
    //     var id = $('#underCommentEidtButton').attr('name');
    function underCommentEidtButton(id) {
        var message = document.getElementById('underCommentEditMessage'+id).value;
>>>>>>> bomi

        if (message.length == 0) {
            alert("입력된 내용이 없습니다.");
            return false;
        }
        
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
                // 새로 고침 부분 수정
                // $("#container").load(document.URL + "#container");
            } else {
                alert("답글 수정에 실패하였습니다.");
            }
        });
    }

    // $(document).on('click', 'button[id=underCommentDelte]', function() {
    //     var id = $('#underCommentDelte').attr('name');
    function underCommentDeleteButton(id) {
        if (confirm("답글을 삭제사히겠습니까?") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("답글 삭제에 되었습니다.");
                    // 새로 고침 부분 수정
                    // $("#container").load(document.URL + "#container");
                } else {
                    alert("답글 삭제에 실패하였습니다.");
                }
            });
        }
    }
</script>