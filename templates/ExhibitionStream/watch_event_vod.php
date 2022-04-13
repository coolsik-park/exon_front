<head>
    <link href="https://vjs.zencdn.net/7.17.0/video-js.css" rel="stylesheet" />
    <script src="https://vjs.zencdn.net/7.17.0/video.min.js"></script>
    <script src="https://developers.kakao.com/sdk/js/kakao.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        #like {
            cursor: pointer;
        }
        #share {
            cursor: pointer;
        }
        #thumb-img {
            width: 4%;
        }
        #share-img {
            width: 4%;
        }
        .popup-img {
            width: 10%;
            margin: 10px;
            cursor: pointer;
        }
        .popup-body {
            text-align: center;
        }
        .copy {
            margin-top: 50px;
        }
        #url {
            width: 80%;
        }
        #url-copy {
            margin-left: 5px;
        }
        
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
</head>

<div id="container">       
    <div class="contents">      
        <div class="section-webinar3">
            <div class="webinar-cont">
                <div class="wb-cont1">
                    <video id="vid1" class="video-js vjs-big-play-centered" poster="https://orcaexon.co.kr/videos/<?=$exhibitionStream[0]['stream_key']?>/thumbnail.png">
                        <source src="https://orcaexon.co.kr/videos/<?=$exhibitionStream[0]['stream_key']?>/EXON_VOD.mp4" type="video/mp4" />
                    </video>
                </div>   
                <div class="wb-cont2">
                    <h3 class="w-tit"><?=$exhibitionStream[0]['title']?></h3>
                    <div class="w-desc">
                        <p class="wd1"><span id="viewer" class="w-dt">조회수 <?=$exhibitionStream[0]['viewer']?></span></p>
                        <div class="wd2">
                            <span id="liked" class="w-dt">추천 <?=$exhibitionStream[0]['liked']?></span>&nbsp;&nbsp;&nbsp;
                            <span id="like" class="w-dt">&nbsp;<img id="thumb-img" src="/img/thumb1.png">&nbsp;추천하기</span>&nbsp;&nbsp;&nbsp;
                            <span id="share" class="w-dt" data-toggle="modal" data-target="#shareModal" data-backdrop="static" data-keyboard="false">&nbsp;<img id="share-img" src="/img/share.png">&nbsp;공유하기</span>
                        </div>
                    </div>
                    <h3 class="w-tit"><?=$user->name?></h3>
                </div>  
                <div id="wb-cont3">
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
                            // $commentUnder_key = array_keys($commentUnder);
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
                                            <?php if ($login_user == $exhibition_comment->users_id): ?>
                                                <div id="configbutton<?= $exhibition_comment->id ?>">
                                                    <button type="button" id="commentEdit" onclick="commentEditButton(<?= $exhibition_comment->id ?>)">수정</button>
                                                    <button type="button" id="commentDelete" onclick="commentDeleteButton(<?= $exhibition_comment->id ?>)">삭제</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div id="commentText<?= $exhibition_comment->id ?>"><?= $exhibition_comment->message ?></div>
                                        <br>
                                        <!-- <?php if (array_key_exists($exhibition_comment->id, $commentUnder)): ?>
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
                                                                <?php if ($login_user == $commentUnder->users_id): ?>
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
                                        <?php else: ?> -->
                                            <!-- <div id="underCommentAddDiv">
                                                <button type="button" id="underCommentAdd" name="<?= $exhibition_comment->id ?>">답글달기</button>
                                            </div>
                                            <br> -->
                                        <!-- <?php endif; ?> -->
                                    </div>
                        <?php
                                endif;
                            endforeach;
                        ?>
                    </div>
                    <br>
                </div>       
                <br>        
            </div>
        </div>
    </div>    
</div>
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color:transparent; border:none;">
            <div class="popup-wrap popup-ty2">
                <div class="popup-head">
                    <h1>공유하기</h1>
                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                </div>
                <br>
                <div class="popup-body">
                    <img id="blog" class="popup-img" src ="/img/blog.png" onclick="naverShare()">
                    <img id="kakao" class="popup-img" src ="/img/kakao.png" onclick="kakaoShare()">
                    <img id="inst" class="popup-img" src ="/img/inst.png" onclick="instShare()">
                    <img id="fb" class="popup-img" src ="/img/fb.png" onclick="fbShare()">
                    <div class="copy">
                        <input type="text" id="url" value="https://exon.live/exhibition-stream/watch-event-vod/<?=$exhibition_id?>" readonly><button type="button" id="url-copy" class="btn">복사</button>
                    </div>
                </div>
                <div class="popup-btm">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    //video.js
    var player = videojs('vid1', {
        controls: true,
        preload: 'auto',
        fluid: true,
    });

    $(document).ready(function () {
        jQuery.ajax({
            url: "/exhibition-stream/add-viewer/" + <?= $exhibitionStream[0]['id'] ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            if (data.status == 'success') {
                $("#viewer").html("조회수 " + data.viewer);
            } 
        });
    });

    $(document).on('click', '#like', function () {
        jQuery.ajax({
            url: "/exhibition-stream/add-like/" + <?= $exhibitionStream[0]['id'] ?>, 
            method: 'POST',
            type: 'json',
        }).done(function(data) {
            if (data.status == 'success') {
                $("#liked").html("추천 " + data.liked);
                $("#thumb-img").attr("src", "/img/thumb2.png");
            } else if (data.status == 'exist') {
                alert('오늘의 추천을 완료하였습니다.');
                $("#thumb-img").attr("src", "/img/thumb2.png");
            } else {
                alert('오류가 발생하였습니다. 잠시 후 다시 시도해주세요.');
            }
        });
    });

    $(document).on("click", "#url-copy", function() {
        $("#url").select();
        document.execCommand("copy");
        alert('복사되었습니다.');
    });

    //naver share
    function naverShare() {
        var url = encodeURI(encodeURIComponent($("#url").val()));
        var title = encodeURI('EXON 행사 공유');
        var shareURL = "https://share.naver.com/web/shareView?url=" + url + "&title=" + title;
        window.open(shareURL);
    }

    //kakao share
    Kakao.init('e5bf93535a4cdd236912e1cfb2359173');
    function kakaoShare() {
        Kakao.Link.sendDefault({
            objectType: 'text',
            text:
                'EXON 행사 공유',
            link: {
                mobileWebUrl: $("#url").val(),
                webUrl: $("#url").val(),
            },
        })
    }

    //inst share
    function instShare() {
        window.open('https://www.instagram.com/?hl=ko');
    }

    //fb share
    function fbShare() {
        window.open('https://ko-kr.facebook.com/');
    }

    var user_id = <?= $login_user ?>;
    var stream_id = <?= $exhibitionStream[0]->id ?>;

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
                exhibition_stream_id: stream_id,
                users_id: user_id,
                message: message,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("댓글 추가되었습니다.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
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
        html_2 += '       <input type="text" class="ipt" id="commentEditMessage" value="' + message + '">';
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
                alert("댓글 수정되었습니다.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
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
                    $('#wb-cont3').load(document.URL + "  #wb-cont3");
                } else {
                    alert("댓글 삭제에 실패하였습니다.");
                }
            });
        }
    }

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
                exhibition_stream_id: stream_id,
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
                exhibition_stream_id: stream_id,
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
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
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
                    $('#wb-cont3').load(document.URL + "  #wb-cont3");
                } else {
                    alert("답글 삭제에 실패하였습니다.");
                }
            });
        }
    });
</script>