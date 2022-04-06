<div class="vod--div__wrap">
    <div class="header-search">
        <fieldset>
            <legend>행사 검색</legend>
            <input id="contest-key" type="text" placeholder="콘테스트 출품 행사를 검색해주세요" class="ipt" onkeyup="enterkey()">
            <button id="contest-search" type="button" class="ico-sh">검색</button>
        </fieldset>
    </div>
    <br>
    <div>
        <p>"<?php if ($key == null) : echo("전체"); else : echo($key); endif;?>" 검색결과 <?=$count?>개</p>
    </div>
    <?php if ($count == 0) : ?>
        <div class="textdiv">
            <p>"<?php if ($key == null) : echo("전체"); else : echo($key); endif;?>"에 대한 검색결과가 없습니다.</p>
            <br>
            <p>모든 단어의 철자가 맞는지 확인해 보세요.</p>
            <p>검색도구를 다르게 설정해 보세요.</p>
            <p>검색어를 변경해 보세요.</p>
        </div>
    <?php else : ?>
    <ul class="clickTab searchBox">
        <li class="clickTab__item"><a class="order" id="new" style="color:#007bff;">최신순</a></li>
        <li class="clickTab__item"><a class="order" id="popular">인기순</a></li>
    </ul>
    <div class="vod--div__flex">
        <?php foreach ($exhibitions as $exhibition) : ?>
        <?php if ($exhibition['live_started'] != null) : ?>
        <div class="vod--div">
            <a href="/exhibition/view/<?=$exhibition->_matchingData['Exhibition']['id']?>">
                <div class="vod--div__img"><img id="live-img" src="/img/live.png"><img src="/<?=$exhibition->_matchingData['Exhibition']['image_path']?>/<?=$exhibition->_matchingData['Exhibition']['image_name']?>" class="div--img"></div>
                <div class="vod--div__title">
                    <?=$exhibition->_matchingData['Exhibition']['title']?>
                </div>
                <div class="vod--div__info" style="color: gray;">
                    <div class="info--viewer">누적 시청자 <span class="info--viewr__num"> <?=$exhibition['watched']?></span></div>
                    <div class="info--good">추천 <span class="info--good__num"> <?=$exhibition['liked']?></span></div>
                </div>
            </a>
        </div>
        <?php else : ?>
        <div class="vod--div">
            <a href="/exhibition-stream/watch-event-vod/<?=$exhibition->_matchingData['Exhibition']['id']?>">
                <div class="vod--div__img"><img src="/<?=$exhibition->_matchingData['Exhibition']['image_path']?>/<?=$exhibition->_matchingData['Exhibition']['image_name']?>" class="div--img"></div>
                <div class="vod--div__title">
                    <?=$exhibition->_matchingData['Exhibition']['title']?>
                </div>
                <div class="vod--div__info" style="color: gray;">
                    <div class="info--viewer">조회 <span class="info--viewr__num"> <?=$exhibition['viewer']?></span></div>
                    <div class="info--good">추천 <span class="info--good__num"> <?=$exhibition['liked']?></span></div>
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