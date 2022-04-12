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
      border: 1px solid #ddd;
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
            <button type="button" class="btn-ty3" id="commentButton">답글</button>
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
                                    <?php
                                        if ($exhibition_comment->created != $exhibition_comment->modified) {
                                            echo date("Y.m.d", strtotime($exhibition_comment->modified)). "(수정)";
                                        } else {
                                            echo date("Y.m.d", strtotime($exhibition_comment->created));
                                        }
                                    ?>
                                </span>
                            </div>
                            <?php if ($user == $exhibition_comment->users_id): ?>
                                <div>
                                    <button type="button" id="commentEdit" name="<?= $exhibition_comment->id ?>">수정</button>
                                    <button type="button" id="commentDelte" name="<?= $exhibition_comment->id ?>">삭제</button>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div id="commentText"><?= $exhibition_comment->message ?></div>
                        <br>
                        <?php 
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
                                                        <?php
                                                            if ($commentUnder->created != $commentUnder->modified) {
                                                                echo date("Y.m.d", strtotime($commentUnder->modified)). "(수정)";
                                                            } else {
                                                                echo date("Y.m.d", strtotime($commentUnder->created));
                                                            }
                                                        ?>
                                                    </span>
                                                </div>
                                                <?php if ($user == $commentUnder->users_id): ?>
                                                    <div>
                                                        <button type="button" id="underCommentEdit" name="<?= $commentUnder->id ?>">수정</button>
                                                        <button type="button" id="underCommentDelte" name="<?= $commentUnder->id ?>">삭제</button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div id="underCommentText"><?= $commentUnder->message ?></div>
                                        </div>
                                        <br>
                                    <?php endforeach; ?>
                                    <div id="underUnderCommentAddDiv">
                                        <button type="button" id="underUnderCommentAdd" name="<?= $exhibition_comment->id ?>">답글달기</button>
                                    </div>
                                </details>
                            </div>
                        <?php else: ?>
                            <div id="underCommentAddDiv">
                                <button type="button" id="underCommentAdd" name="<?= $exhibition_comment->id ?>">답글달기</button>
                            </div>
                            <br>
                        <?php endif; ?>
                    </div>
        <?php
                endif;
            endforeach;
        ?>
    </div>
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
                alert("답글 추가되었습니다.");
                // 새로 고침 부분 수정
                // $("#container").load(document.URL + " #container");
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
    });

    $(document).on('click', 'button[id=commentEdit]', function() {
        var id = $('#commentEdit').attr('name');
        var message = document.getElementById('commentText').innerHTML;
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="commentEditMessage" value="' + message + '">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="commentEidtButton" name="' + id  + '" style="float:right;">수정하기</button>';
        html += '   <br><br>'
        html += '</div>';
        $("#commentText").html(html);
    });

    $(document).on('click', 'button[id=commentEidtButton]', function() {
        var id = $('#commentEidtButton').attr('name');
        var message = document.getElementById('commentEditMessage').value;

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
    });

    $(document).on('click', 'button[id=commentDelte]', function() {
        var id = $('#commentDelte').attr('name');

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
    });

    $(document).on('click', 'button[id=underCommentAdd]', function() {
        var id = $('#underCommentAdd').attr('name');
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underCommentAddMessage">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="underCommentAddButton" name="' + id  + '" style="float:right;">답글</button>';
        html += '   <br><br>'
        html += '</div>';
        $("#underCommentAddDiv").html(html);
    });

    $(document).on('click', 'button[id=underCommentAddButton]', function() {
        var id = $("#underCommentAddButton").attr('name');
        var message = document.getElementById('underCommentAddMessage').value;

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
    });

    $(document).on('click', 'button[id=underUnderCommentAdd]', function() {
        var id= $('#underUnderCommentAdd').attr('name');
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underUnderCommentAddMessage">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="underUnderCommentAddButton" name="' + id  + '" style="float:right;">답글</button>';
        html += '   <br><br>'
        html += '</div>';
        $("#underUnderCommentAddDiv").html(html);
    });

    $(document).on('click', 'button[id=underUnderCommentAddButton]', function() {
        var id = $('#underUnderCommentAddButton').attr('name');
        var message = document.getElementById('underUnderCommentAddMessage').value;

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
                users_id: null,
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
    });

    $(document).on('click', 'button[id=underCommentEdit]', function() {
        var id = $('#underCommentEdit').attr('name');
        var message = document.getElementById('underCommentText').innerHTML;
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <input type="text" class="ipt" id="underCommentEditMessage" value="' + message + '">';
        html += '   </div>';
        html += '   <button type="button" class="btn-ty3" id="underCommentEidtButton" name="' + id  + '" style="float:right;">수정하기</button>';
        html += '   <br><br>'
        html += '</div>';
        $("#underCommentText").html(html);
    });

    $(document).on('click', 'button[id=underCommentEidtButton]', function() {
        var id = $('#underCommentEidtButton').attr('name');
        var message = document.getElementById('underCommentEditMessage').value;

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
    });

    $(document).on('click', 'button[id=underCommentDelte]', function() {
        var id = $('#underCommentDelte').attr('name');

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
    });
</script>