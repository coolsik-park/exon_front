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
            width: 3%;
        }
        #share-img {
            width: 3%;
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
        .w-dt {
            vertical-align:middle;
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

        @media  screen and (max-width: 768px) {
            .wd2 {
                width: 550px;
            }
            #thumb-img {
                width: 8%;
            }
            #share-img {
                width: 8%;
            }
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
                        <p class="wd1">
                            <span id="viewer" class="w-dt">?????????<?=$exhibitionStream[0]['viewer']?></span>&nbsp;&nbsp;&nbsp;
                            <span id="viewer" class="w-dt"><?=date('Y.m.d', strtotime($exhibitionStream[0]['live_ended']) + 32400)?></span>
                        </p>
                        <div class="wd2">
                            <span id="liked" class="w-dt">??????<?=$exhibitionStream[0]['liked']?></span>&nbsp;&nbsp;&nbsp;
                            &nbsp;<img id="thumb-img" src="/img/thumb1.png"><span id="like" class="w-dt">&nbsp;????????????</span>&nbsp;&nbsp;&nbsp;
                            &nbsp;<img id="share-img" src="/img/share.png"><span id="share" class="w-dt" data-toggle="modal" data-target="#shareModal" data-backdrop="static" data-keyboard="false">&nbsp;????????????</span>
                        </div>
                    </div>
                    <br>
                    <h3 class="w-tit"><?=$exhibition->event_member?></h3>
                </div>
                <br>  
                <div id="wb-cont3" class="wb-cont2">
                    <div id="commentCount">
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;<?= count($exhibition_comments) ?>?????? ??????</span>
                    </div>
                    <br>
                    <div class="col-dd col-cel">
                        <div class="col-td">
                            <textarea class="ipt" id="commentMessage" placeholder="????????? ????????? ?????????."></textarea>
                        </div>
                        <br>
                        <div style="float:right;">
                            <button type="button" class="btn-ty3" id="commentButton" style="font-size: 80%;">?????? ??????</button>
                        </div>
                    </div>
                    <br><br><br><br><br>
                    <div class="replies">
                        <?php
                            foreach ($exhibition_comments as $exhibition_comment):
                                if ($exhibition_comment->parent_id == null):
                        ?>
                                    <div class="replies__item">
                                        <div class="head">
                                            <div>
                                                <span style="font-size: 17px; font-weight: bold; vertical-align: sub;"><?= $exhibition_comment->user_name ?></span>
                                                <span class="muted" style="vertical-align: sub;">
                                                    <?php echo date("Y.m.d", strtotime($exhibition_comment->modified)); ?>
                                                </span>
                                            </div>
                                            <?php if ($login_user == $exhibition_comment->users_id): ?>
                                                <div id="configbutton<?= $exhibition_comment->id ?>">
                                                    <button type="button" id="commentEdit" onclick="commentEditButton(<?= $exhibition_comment->id ?>)">??????</button>
                                                    <button type="button" id="commentDelete" onclick="commentDeleteButton(<?= $exhibition_comment->id ?>)">??????</button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div id="commentText<?= $exhibition_comment->id ?>" style="line-height: 24px; font-size: 17px;"><?= $exhibition_comment->message ?></div>
                                        <br>
                                        <?php 
                                            $comment_under = [];
                                            for ($i=0; $i<count($exhibition_comments_unders); $i++) {
                                                if ($exhibition_comments_unders[$i]->parent_id == $exhibition_comment->id) {
                                                    array_push($comment_under, $i);
                                                }
                                            }

                                            if (count($comment_under) != 0):
                                        ?>
                                                <div class="foot">
                                                    <details>
                                                        <summary>?????? <?= count($comment_under) ?>???</summary><br>
                                                        <hr style="border-bottom:1px solid #ddd;">
                                                        <?php foreach ($comment_under as $commentUnder => $i): ?>
                                                            <div class="replies__item">
                                                                <div class="head">
                                                                    <div>
                                                                        <span style="font-size: 17px; font-weight: bold; vertical-align: sub;"><?= $exhibition_comments_unders[$i]->user_name ?></span>
                                                                        <span class="muted" style="vertical-align: sub;">
                                                                            <?php echo date("Y.m.d", strtotime($exhibition_comments_unders[$i]->modified)); ?>
                                                                        </span>
                                                                    </div>
                                                                    <?php if ($login_user == $exhibition_comments_unders[$i]->users_id): ?>
                                                                        <div id="underConfigButton<?= $exhibition_comments_unders[$i]->id ?>">
                                                                            <button type="button" id="underCommentEdit" onclick="underCommentEditButton(<?= $exhibition_comments_unders[$i]->id ?>)">??????</button>
                                                                            <button type="button" id="underCommentDelete" onclick="underCommentDeleteButton(<?= $exhibition_comments_unders[$i]->id ?>)">??????</button>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                                <div id="underCommentText<?= $exhibition_comments_unders[$i]->id ?>" style="line-height: 24px; font-size: 17px;"><?= $exhibition_comments_unders[$i]->message ?></div>
                                                                <br>
                                                            </div>
                                                        <?php endforeach; ?>
                                                        <div id="underUnderCommentAddDiv<?= $exhibition_comment->id ?>">
                                                            <button type="button" id="underUnderComment" onclick="underUnderCommentButton(<?= $exhibition_comment->id ?>)" style="position: relative; left: 18px;">????????????</button>
                                                        </div>
                                                    </details>
                                                </div>
                                        <?php else: ?>
                                            <div id="underCommentAddDiv<?= $exhibition_comment->id ?>">
                                                <button type="button" id="underComment" onclick="underCommentButton(<?= $exhibition_comment->id ?>)">????????????</button>
                                            </div>
                                            <br>
                                        <?php endif; ?>
                                    </div>
                        <?php
                                endif;
                            endforeach;
                        ?>
                    </div>
                    <hr style="border-bottom:1px solid #ddd;">
                    <br><br><br><br>
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
                    <h1>????????????</h1>
                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">????????????</button>
                </div>
                <br>
                <div class="popup-body">
                    <img id="blog" class="popup-img" src ="/img/blog.png" onclick="naverShare()">
                    <img id="kakao" class="popup-img" src ="/img/kakao.png" onclick="kakaoShare()">
                    <img id="inst" class="popup-img" src ="/img/inst.png" onclick="instShare()">
                    <img id="fb" class="popup-img" src ="/img/fb.png" onclick="fbShare()">
                    <div class="copy">
                        <input type="text" id="url" value="https://exon.live/exhibition-stream/watch-event-vod/<?=$exhibition_id?>" readonly><button type="button" id="url-copy" class="btn">??????</button>
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
                $("#viewer").html("????????? " + data.viewer);
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
                $("#liked").html("?????? " + data.liked);
                $("#thumb-img").attr("src", "/img/thumb2.png");
            } else if (data.status == 'exist') {
                alert('????????? ????????? ?????????????????????.');
                $("#thumb-img").attr("src", "/img/thumb2.png");
            } else {
                alert('????????? ?????????????????????. ?????? ??? ?????? ??????????????????.');
            }
        });
    });

    $(document).on("click", "#url-copy", function() {
        $("#url").select();
        document.execCommand("copy");
        alert('?????????????????????.');
    });

    //naver share
    function naverShare() {
        var url = encodeURI(encodeURIComponent($("#url").val()));
        var title = encodeURI('EXON ?????? ??????');
        var shareURL = "https://share.naver.com/web/shareView?url=" + url + "&title=" + title;
        window.open(shareURL);
    }

    //kakao share
    Kakao.init('e5bf93535a4cdd236912e1cfb2359173');
    function kakaoShare() {
        Kakao.Link.sendDefault({
            objectType: 'text',
            text:
                'EXON ?????? ??????',
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
        message = message.replace(/(?:\r\n|\r|\n)/g,'<br>');

        if (message.length == 0) {
            alert("????????? ????????? ????????????.");
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
                alert("?????? ?????????????????????.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
            } else if (data.status == 'not_user') {
                if (confirm("????????? ????????????.\n???????????? ???????????????????")) {
                    location.href="/users/login";
                } else {
                    alert("?????????????????????.");
                }
            } else {
                alert("?????? ????????? ?????????????????????.");
            }
        });
    });

    function commentEditButton(id) {
        var message = document.getElementById('commentText' + id).innerHTML;
        var message_span = message.replaceAll('<br>', '\n');
        var massage_fun = "'"+message+"'";
        
        var html_1 = '';
        html_1 += '<button type="button" id="commentDelete" onclick="commentDeleteButton(' + id  + ')">??????</button>';
        $("#configbutton"+id).html(html_1);

        var html_2 = '';
        html_2 += '<div class="col-dd col-cell">';
        html_2 += '   <div class="col-td">';
        html_2 += '     <textarea class="ipt" id="commentEditMessage'+id+'">' + message_span + '</textarea>';
        html_2 += '   </div>';
        html_2 += '   <div style="float:right;">';
        html_2 += '     <button type="button" class="btn-ty3" id="commentEidtButton" onclick="commentEidtButton(' + id  + ')">????????????</button>';
        html_2 += '     <button type="button" class="btn-ty3" id="commentCancelButton" onclick="commentCancelButton(' + id + ',' + massage_fun + ')">?????? ????????????</button>';
        html_2 += '   </div>';
        html_2 += '   <br><br>';
        html_2 += '</div>';
        $("#commentText"+id).html(html_2);
    }

    function commentCancelButton(id, message) {  
        var html_1 = '';
        html_1 += '<button type="button" id="commentEdit" onclick="commentEditButton(' + id  + ')">??????</button>';
        html_1 += '<button type="button" id="commentDelete" onclick="commentDeleteButton(' + id  + ')">??????</button>';
        $("#configbutton"+id).html(html_1);

        var html_2 = '';
        html_2 += message;
        $("#commentText"+id).html(html_2);
    }

    function commentEidtButton(id) {
        var message = document.getElementById('commentEditMessage'+id).value;
        message = message.replace(/(?:\r\n|\r|\n)/g,'<br>');
        
        if (message.length == 0) {
            alert("????????? ????????? ????????????.");
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
                alert("?????? ?????????????????????.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
            } else {
                alert("?????? ????????? ?????????????????????.");
            }
        });
    }

    function commentDeleteButton(id) {
        if (confirm("????????? ?????????????????????????") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("?????? ?????????????????????.");
                    $('#wb-cont3').load(document.URL + "  #wb-cont3");
                } else {
                    alert("?????? ????????? ?????????????????????.");
                }
            });
        }
    }

    function underCommentButton(id) {
        var html = '';
        html += '<div class="col-dd col-cell">';
        html += '   <div class="col-td">';
        html += '       <textarea class="ipt" id="underCommentAddMessage'+id+'" placeholder="????????? ????????? ?????????."></textarea>';
        html += '   </div>';
        html += '   <div style="float:right;">';
        html += '       <button type="button" class="btn-ty3" id="underCommentAdd" onclick="underCommentAddButton(' + id  + ')">??????</button>';
        html += '       <button type="button" class="btn-ty3" id="underCommentAddCancle" onclick="underCommentAddCancleButton(' + id  + ')">??????</button>';
        html += '   </div>';
        html += '   <br><br>'
        html += '</div>';
        $("#underCommentAddDiv"+id).html(html);
    }

    function underCommentAddCancleButton(id) {
        var html = '';
        html = '<button type="button" id="underComment" onclick="underCommentButton('+ id +')">????????????</button>';
        $("#underCommentAddDiv"+id).html(html);
    }

    function underCommentAddButton(id) {
        var message = document.getElementById('underCommentAddMessage'+id).value;
        message = message.replace(/(?:\r\n|\r|\n)/g,'<br>');

        if (message.length == 0) {
            alert("????????? ????????? ????????????.");
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
                alert("?????? ?????????????????????.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
                // ????????? ????????? ??????
                // var html = '';
                // html += ''
            } else if (data.status == 'not_user') {
                if (confirm("????????? ????????????.\n???????????? ???????????????????")) {
                    location.href="/users/login";
                } else {
                    alert("?????????????????????.");
                }
            } else {
                alert("?????? ????????? ?????????????????????.");
            }
        });
    }
    
    function underUnderCommentButton(id) {
        var html = '';
        html += '<div class="col-dd col-cell" style="position: relative; left: 18px;">';
        html += '   <div class="col-td">';
        html += '       <textarea class="ipt" id="underUnderCommentAddMessage'+id+'" placeholder="????????? ????????? ?????????."></textarea>';
        html += '   </div>';
        html += '   <div style="float:right;">';
        html += '       <button type="button" class="btn-ty3" id="underUnderCommentAdd" onclick="underUnderCommentAddButton(' + id  + ')">??????</button>';
        html += '       <button type="button" class="btn-ty3" id="underUnderCommentAddCancel" onclick="underUnderCommentAddCancelButton(' + id  + ')">??????</button>';
        html += '   </div>';
        html += '   <br><br>';
        html += '</div>';
        $("#underUnderCommentAddDiv"+id).html(html);
    }

    function underUnderCommentAddCancelButton(id) {
        var html = '';
        html += '<button type="button" id="underUnderComment" onclick="underUnderCommentButton(' + id + ')">????????????</button>';
        $("#underUnderCommentAddDiv"+id).html(html);
    }

    function underUnderCommentAddButton(id) {
        var message = document.getElementById('underUnderCommentAddMessage'+id).value;
        message = message.replace(/(?:\r\n|\r|\n)/g,'<br>');

        if (message.length == 0) {
            alert("????????? ????????? ????????????.");
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
                alert("?????? ?????????????????????.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
                // ????????? ????????? ??????
                // var html = '';
                // html += ''
            } else if (data.status == 'not_user') {
                if (confirm("????????? ????????????.\n???????????? ???????????????????")) {
                    location.href="/users/login";
                } else {
                    alert("?????????????????????.");
                }
            } else {
                alert("?????? ????????? ?????????????????????.");
            }
        });
    }

    function underCommentEditButton(id) {
        var message = document.getElementById('underCommentText'+id).innerHTML;
        var message_span = message.replaceAll('<br>', '\n');
        var message_fun = "'" + message + "'";

        var html_1 = '';
        html_1 += '<button type="button" id="underCommentDelete" onclick="underCommentDeleteButton('+ id + ')">??????</button>';
        $('#underConfigButton'+id).html(html_1);

        var html_2 = '';
        html_2 += '<div class="col-dd col-cell">';
        html_2 += '   <div class="col-td">';
        html_2 += '     <textarea class="ipt" id="underCommentEditMessage'+id+'">' + message_span + '</textarea>';
        html_2 += '   </div>';
        html_2 += '   <div style="float:right;">';
        html_2 += '     <button type="button" class="btn-ty3" id="underCommentEidt" onclick="underCommentEidtButton(' + id  + ')">????????????</button>';
        html_2 += '     <button type="button" class="btn-ty3" id="underCommentEidtCancle" onclick="underCommentEidtCancleButton(' + id  + ', ' + message_fun + ')">?????? ????????????</button>';
        html_2 += '   </div>';
        html_2 += '   <br><br>';
        html_2 += '</div>';
        $("#underCommentText"+id).html(html_2);
    }

    function underCommentEidtCancleButton(id, message) {
        var html_1 = '';
        html_1 += '<button type="button" id="underCommentEdit" onclick="underCommentEditButton('+ id + ')">??????</button>';
        html_1 += '<button type="button" id="underCommentDelete" onclick="underCommentDeleteButton('+ id + ')">??????</button>';
        $('#underConfigButton'+id).html(html_1);

        var html_2 = '';
        html_2 = message;
        $("#underCommentText"+id).html(html_2);
    }

    function underCommentEidtButton(id) {
        var message = document.getElementById('underCommentEditMessage'+id).value;
        message = message.replace(/(?:\r\n|\r|\n)/g,'<br>');

        if (message.length == 0) {
            alert("????????? ????????? ????????????.");
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
                alert("?????? ?????????????????????.");
                $('#wb-cont3').load(document.URL + "  #wb-cont3");
            } else {
                alert("?????? ????????? ?????????????????????.");
            }
        });
    }

    function underCommentDeleteButton(id) {
        if (confirm("????????? ?????????????????????????") == true) {
            $.ajax({
                url: '/exhibition-stream/comment-delete/' + id,
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("?????? ?????????????????????.");
                    $('#wb-cont3').load(document.URL + "  #wb-cont3");
                } else {
                    alert("?????? ????????? ?????????????????????.");
                }
            });
        }
    }
</script>