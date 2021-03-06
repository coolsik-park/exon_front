<div class="section-my">
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
    <ul class="clickTab">
        <li class="clickTab__item"><a class="order" id="new" style="color:#007bff;">최신순</a></li>
        <li class="clickTab__item"><a class="order" id="accuracy">정확도순</a></li>
    </ul>
    <br>
    <?php foreach ($exhibitions as $exhibition) : ?>
    <div class="searchBox" id="<?=$exhibition["id"]?>">
        <div class="product-title">
            <div class="product-img-div photo">
                    <?php if ($exhibition["image_path"] != '') : ?>
                    <img  style="width: 100%; height: 155px; visibility: visible; margin-top: 0px;" class="product-img" src="/<?=$exhibition["image_path"]?>/<?=$exhibition["image_name"]?>">
                    <?php else : ?>
                    <img class="noImg"src="../../images/img-no.png"style="visibility: visible; height:100%; width: 155px; margin-top: 0px;" >
                    <?php endif; ?>
            </div>
        </div>
        <div class="tr-row">
            <div class="td-col col1">
                <p class="tit-name"><?=$exhibition["title"]?></p>
            </div>
            <div class="td-col col2">
                <p><?=$exhibition["description"]?></p>
            </div>
            <div class="td-col col3">
                <?php $week = ["일", "월", "화", "수", "목", "금", "토"]; ?>
                <p class="tit-con"><?php echo date('Y. m. d', strtotime($exhibition["sdate"]))?> (<?php echo $week[date('w', strtotime($exhibition["sdate"]))] ?>) <?php echo date('H:i', strtotime($exhibition["sdate"]))?> ~ <?php echo date('Y. m. d', strtotime($exhibition["edate"]))?> (<?php echo $week[date('w', strtotime($exhibition["edate"]))] ?>) <?php echo date('H:i', strtotime($exhibition["edate"]))?></p>
            </div>
            <div class="td-col col4">
                <p class="tit">
                    <span class="t2"><?=$exhibition["name"]?></span>
                </p>
            </div>
            <div class="td-col col5">
                <p><?=$commonCategory[$exhibition["category"]-1]["title"]?></p>
                <p><?=$commonCategory[$exhibition["type"]-1]["title"]?></p>
                <?php if ($exhibition["cost"] == "free") : ?>
                <p>무료</p>
                <?php else : ?>
                <p>유료</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev("< ") ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(" >") ?>
        </ul>
    </div>
    <?php endif; ?>
</div>