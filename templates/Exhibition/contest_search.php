<style>
    .header-search {
        position: relative;
        width: 350px;
        height: 42px;
        background-color: #F2F2F2;
        border-radius: 21px;
        margin-top: 2vh;
    }
    .header-search .ipt {
        position: absolute;
        top: 11px;
        left: 30px;
        width: 80%;
        height: auto;
        padding: 0;
        font-size: 0.875rem;
        border: 0;
        background: transparent;
    }
    .ico-sh {
        position: absolute;
        top: 11px;
        right: 20px;
    }
    .paginator {
        display: flex;
        justify-content: center;
        margin-bottom: 100px;
    }
    .clickTab {
        display: flex;
        position: absolute;
        right: 0;
        top: 2vh;
        cursor: pointer;
    }
    .order {
        margin-left: 1vh;
    }
    .vod--div__wrap {
        width: 100%;
        margin-right: auto;
        margin-left: auto;
        position: relative;
    }
    .vod--div__flex {
        display: flex;
        justify-content: flex-start;
        flex-wrap: wrap;
        word-break:break-all;
    }
    .vod--div {
        width: 31%;
        margin-top: 7vh;
        margin-bottom: 1vh;
        margin: 7vh 2.5vh 0 0;
    }
    .div--img {
        width: 100%;
        height: 180px;
    }
    .vod--div__title {
        font-size: 1.2rem;
        margin-top: 2vh;
    }
    .vod--div__info {
        display: flex;
        margin-top: 2vh;
    }
    .info--good {
        margin-left: 1vh;
    }
    .textdiv {
        padding-top:100px;
        text-align:center;
    }
    #live-img {
        position: absolute;
        width: 3%;
        margin-left: 310px;
    }
    @media  screen and (max-width: 768px) {
        .vod--div {
            width: 90%;
            margin-top: 7vh;
            margin-bottom: 1vh;
        }
        .header-search {
            margin: 2vh auto;
        }
        .clickTab {
            display: flex;
            position: absolute;
            right: 2vh;
            top: 8vh;
        }
        .vod--div__flex {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
        .vod--div {
            margin-top: 7vh;
            margin-bottom: 1vh;
            margin: 7vh 0 1vh 0;
        }
    }
    @media  screen and (min-width: 1200px) {
        .vod--div__wrap {
            max-width: 1200px;
        }
    }
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<div class="wrap">
    <div id="container">
        <div class="vod--div__wrap">
            <div class="header-search">
                <fieldset>
                    <legend>?????? ??????</legend>
                    <input id="contest-key" type="text" placeholder="????????? ??????????????????" class="ipt" onkeyup="enterkey()">
                    <button id="contest-search" type="button" class="ico-sh">??????</button>
                </fieldset>
            </div>
            <br>
            <div>
                <p>"<?php if ($key == null) : echo("??????"); else : echo($key); endif;?>" ???????????? <?=$count?>???</p>
            </div>
            <?php if ($count == 0) : ?>
                <div class="textdiv">
                    <p>"<?php if ($key == null) : echo("??????"); else : echo($key); endif;?>"??? ?????? ??????????????? ????????????.</p>
                    <br>
                    <p>?????? ????????? ????????? ????????? ????????? ?????????.</p>
                    <p>??????????????? ????????? ????????? ?????????.</p>
                    <p>???????????? ????????? ?????????.</p>
                </div>
            <?php else : ?>
            <ul class="clickTab searchBox">
                <li class="clickTab__item"><a class="order" id="new" style="color:#007bff;">?????????</a></li>
                <li class="clickTab__item"><a class="order" id="popular">?????????</a></li>
            </ul>
            <div class="vod--div__flex">
                <?php foreach ($exhibitions as $exhibition) : ?>
                <?php if ($exhibition['live_started'] != null) : ?>
                <div class="vod--div">
                    <a href="/exhibition/view/<?=$exhibition->_matchingData['Exhibition']['id']?>">
                        <div class="vod--div__img"><img id="live-img" src="/img/live.png"><img src="/<?=$exhibition->_matchingData['Exhibition']['image_path']?>/<?=$exhibition->_matchingData['Exhibition']['image_name']?>" class="div--img"></div>
                        <div class="vod--div__title h-ty3" style="font-size: 1.125rem;">
                            <?=$exhibition->_matchingData['Exhibition']['title']?>
                        </div>
                        <div class="vod--div__info tx-1" style="color: gray; font-size:0.875rem">
                            <div class="info--viewer">?????? ????????? <span class="info--viewr__num"> <?=$exhibition['watched']?></span></div>
                            <div class="info--good">?????? <span class="info--good__num"> <?=$exhibition['liked']?></span></div>
                        </div>
                    </a>
                </div>
                <?php else : ?>
                <div class="vod--div">
                    <a href="/exhibition-stream/watch-event-vod/<?=$exhibition->_matchingData['Exhibition']['id']?>">
                        <div class="vod--div__img"><img src="/<?=$exhibition->_matchingData['Exhibition']['image_path']?>/<?=$exhibition->_matchingData['Exhibition']['image_name']?>" class="div--img"></div>
                        <div class="vod--div__title h-ty3">
                            <?=$exhibition->_matchingData['Exhibition']['title']?>
                        </div>
                        <div class="vod--div__info" style="color: gray;">
                            <div class="info--viewer">?????? <span class="info--viewr__num"> <?=$exhibition['viewer']?></span></div>
                            <div class="info--good">?????? <span class="info--good__num"> <?=$exhibition['liked']?></span></div>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->prev("< ") ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(" >") ?>
            </ul>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#contest-search", function () {
        var key = $("#contest-key").val();
        if (key == '') {
            window.location.href = "/exhibition/contest-search";
        } else {
            window.location.href = "/exhibition/contest-search/" + key;
        }
    });

    function enterkey() {
        var key = $("#contest-key").val();
        if (window.event.keyCode == 13) {
            if (key == '') {
                window.location.href = "/exhibition/contest-search";
            } else {
                window.location.href = "/exhibition/contest-search/" + key;
            }
        }
    }

    $(document).on("click", ".order", function () {
        var id = $(this).attr("id");
        var key = "<?=$key?>";

        jQuery.ajax({
            url: "/exhibition/contest-search",
            method: 'PUT',
            type: 'json',
            data: {
                key: key,
                order: id
            }
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibitions = data.data;

                $("#container").children().remove();
                $("#container").append(exhibitions);

                $(".order").css("color", "");
                $("#"+id).css("color", "#007bff");
            } else {
                alert("????????? ?????????????????????. ?????? ??? ?????? ??????????????????.");
            }
        });
    });
</script>