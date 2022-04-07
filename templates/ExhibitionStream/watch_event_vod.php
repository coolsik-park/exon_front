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
        .wb-cont2 .w-desc p {
            width: 70%;
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
</script>