<style>
     .navbar {
        background-color: #F8F8F8;
        display: flex;
        justify-content: center;
        width: 100%;
    }
    .navbar__menu {
        display: flex;
    }
    .navbar__menu__item {
        padding: 8px 12px;
        margin: 0 4px;
    }
    .searchTool {
        position: relative;
        top: 16px;
        right: 210px;
    }
    select {
        width: 200px;
    }
    .clickTab {
        display: flex;
        justify-content: flex-end;
        margin-right: 100px;
    }
    .clickTab__item {
        padding: 8px 12px;
        cursor: pointer;
    }
    .searchBox {
        display: flex;
        padding: 20px 0px;
        cursor: pointer;
    }
    .tit-name {
        font-size: 24px;
    }
    .td-col {
        padding: 6px 12px;
    }
    .col5 {
        display: flex;
    }
    .col5 p {
        padding: 0px 12px 0px 0px;
    }
    .paginator {
        display:flex;
        justify-content: center;
    }
    .textdiv {
        padding-top:100px;
        text-align:center;
    }
    .apply-sect1-cont .photos{
        background-color: transparent;
    }
    .photos {
        position: relative;
    }
    .photos img {
        position: absolute;
    }
    .apply-sect3-cont p{
        word-wrap:break-word;
    }
    .product-title {
        text-align:center;
        display:table;
        width:280px;
        height:155px;
    }
    .product-img-div {
    display:table-cell;
    vertical-align:middle;
    }
    .product-img {
        max-width:320px;
        max-height:240px;
    }
    .searchBox {
            border-bottom: 1px solid #cecece;
    }
    .tit-con {
        font-size: 12px;
    } 
    .col2 {
        color: darkgray;
    }
    @media  screen and (max-width: 768px) {
        .photos img {
            position: absolute;
            margin-left: 0px;
            width: 100%;
        }  
        .apply-sect1-cont .photos {
            max-height: 40%;
        }
        .product-title {
            text-align:center;
            display:table;
            width:180px;
            height:180px;
        }
        .product-img {
            max-width:180px;
            max-height:180px;
            margin-left: 12px;
        }
        .noImg {
            max-width:180px;
            max-height:180px;
            margin-left: 12px;
        }
        .searchBox {
            display: block;
            border-bottom: 1px solid #cecece;
        }
        .tit-name {
            font-size: 30px;
        }
        .td-col {
            padding: 12px 12px;
        }
        .tit-con {
            font-size: 16px;
        } 
    }
    @media  screen and (min-width: 1024px) {
        .photos img {
            
        }
        .photos {
            margin-left: 115px;
            margin-top: 20px;
        }
        #photos{
            max-width: 38%;
        }
        .tr-row {
            margin-left: 20px;
        }
    }
</style>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<div id="container">
    <nav class="navbar">
        <ul class="navbar__menu">
            <li class="navbar__menu__item">
                <p class="searchTool">검색 도구</p>
            </li>
            <li class="navbar__menu__item">
                <select class="search-by" id="category">
                    <option value="all">전체분야</option>
                    <?php foreach ($commonCategory as $category) : ?>
                        <?php if ($category["types"] == "category") : ?>
                            <option value="<?=$category["id"]?>"><?=$category["title"]?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="navbar__menu__item">
                <select class="search-by" id="type">
                    <option value="all">전체유형</option>
                    <?php foreach ($commonCategory as $type) : ?>
                        <?php if ($type["types"] == "type") : ?>
                            <option value="<?=$type["id"]?>"><?=$type["title"]?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </li>
            <li class="navbar__menu__item">
                <select class="search-by" id="cost">
                    <option value="all">유.무료</option>
                    <option value="charged">유료</option>
                    <option value="free">무료</option>
                </select>
            </li>
        </ul>
    </nav>
    <div id="contents" class="contents static">
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
    </div>
</div>

<script>
        
    $(document).on("click", ".searchBox", function () {
        var id = $(this).attr("id");
        window.location.href = "/exhibition/view/" + id;
    });

    // $(document).ready(function () {
    //     $("#category").val("all").prop("selected", true);
    //     $("#type").val("all").prop("selected", true);
    //     $("#cost").val("all").prop("selected", true);
    // });

    $(document).on("change", ".search-by", function () {
        var key = "<?=$key?>";
        var category = [];
        var type = [];
        var cost = [];

        if ($("#category").val() == 'all') {
            var i = 0;
            <?php foreach ($commonCategory as $category) : ?>
            <?php if ($category['types'] == 'category') : ?>
            category[i] = "<?=$category['id'];?>"
            i++;
            <?php endif; ?>
            <?php endforeach; ?> 
        } else {
            category[0] = $("#category").val();
        }

        if ($("#type").val() == 'all') {
            var i = 0;
            <?php foreach ($commonCategory as $category) : ?>
            <?php if ($category['types'] == 'type') : ?>
            type[i] = "<?=$category['id'];?>"
            i++;
            <?php endif; ?>
            <?php endforeach; ?> 
        } else {
            type[0] = $("#type").val();
        }

        if ($("#cost").val() == 'all') {
            cost[0] = 'free';
            cost[1] = 'charged';
        } else {
            cost[0] = $("#cost").val();
        }

        jQuery.ajax({
            url: "/exhibition/search",
            method: 'PUT',
            type: 'json',
            data: {
                action: 'category',
                key: key,
                category: category,
                type: type,
                cost: cost,
            }
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibitions = data.data;

                $("#contents").children().remove();
                $("#contents").append(exhibitions);
            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    $(document).on("click", ".order", function () {
        var id = $(this).attr("id");
        var key = "<?=$key?>";
        var category = [];
        var type = [];
        var cost = [];
        var order = $(this).attr("id");

        if ($("#category").val() == 'all') {
            var i = 0;
            <?php foreach ($commonCategory as $category) : ?>
            <?php if ($category['types'] == 'category') : ?>
            category[i] = "<?=$category['id'];?>"
            i++;
            <?php endif; ?>
            <?php endforeach; ?> 
        } else {
            category[0] = $("#category").val();
        }

        if ($("#type").val() == 'all') {
            var i = 0;
            <?php foreach ($commonCategory as $category) : ?>
            <?php if ($category['types'] == 'type') : ?>
            type[i] = "<?=$category['id'];?>"
            i++;
            <?php endif; ?>
            <?php endforeach; ?> 
        } else {
            type[0] = $("#type").val();
        }

        if ($("#cost").val() == 'all') {
            cost[0] = 'free';
            cost[1] = 'charged';
        } else {
            cost[0] = $("#cost").val();
        }

        jQuery.ajax({
            url: "/exhibition/search",
            method: 'PUT',
            type: 'json',
            data: {
                action: 'sort',
                key: key,
                category: category,
                type: type,
                cost: cost,
                order: order
            }
        }).done(function (data) {
            if (data.status == 'success') {
                var exhibitions = data.data;

                $("#contents").children().remove();
                $("#contents").append(exhibitions);

                $(".order").css("color", "");
                $("#"+id).css("color", "#007bff");
            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }
        });
    });

    function dateFormat(date) {
        date.setHours(date.getHours() - 9);
        let month = date.getMonth() + 1;
        let day = date.getDate();
        let hour = date.getHours();
        let minute = date.getMinutes();
        let second = date.getSeconds();

        month = month >= 10 ? month : '0' + month;
        day = day >= 10 ? day : '0' + day;
        hour = hour >= 10 ? hour : '0' + hour;
        minute = minute >= 10 ? minute : '0' + minute;
        second = second >= 10 ? second : '0' + second;
        label = date.getDay();

        var week = new Array('일', '월', '화', '수', '목', '금', '토');

        label = week[label];

        return date.getFullYear() + '. ' + month + '. ' + day + ' ('+label+') ' + hour + ':' + minute;
    }
</script>