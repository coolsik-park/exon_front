<style>
    #container {
        position: relative;
    }

    .chapter {
        font-size: 25px;
    }

    .vod-ul {
        margin: 2% 0 2% 3%;
        font-size: 1.5rem;
        border-bottom: 1px solid lightgrey;
    }

    .vod-li {
        margin-top: 5%;
        padding: 0px 0px 20px 0px;
        position: relative;
    }

    .vod-time {
        float: right;
        font-size: 20px;
    }

    .section-webinar4 .webinar-tab.close .webinar-tab-tg {
        top: 78px;
    }

    .arrow--vod2 {
        width: 20px;
    }

    .table-type .tr-row {
        border-bottom: 0px;
    }

    .chapter--menu__div {
        font-size: 1rem;
        position: absolute;
        right: 0%;
        top: 20%;
    }

    .section-my {
        position: relative;
    }

    .chapter--menu__img {
        width: 20px;
    }

    .chapter--title__char {
        font-size: 16px;
        top: 8px;
        left: 0px;
        position: absolute;
    }
    .vod--li__title {
        font-size: 20px;
    }
</style>

    <?php foreach ($tmp_exhibitions as $tmp_exhibition) : ?>
        <ul class="vod-ul">
            <a href="/exhibition-stream/watch-exhibition-stream/<?= $tmp_exhibition['id'] ?>/<?= $exhibition_users_id ?>/<?= $cert ?>">
                <li class="vod-li vod--title__div">
                    <span class="vod--li__title"><?= $tmp_exhibition['title'] ?></span>
                </li>
            </a>
        </ul>
    <?php endforeach; ?>
