<style>
    #webinar-tab {
        width: 20%;
    }

    td {
        line-height: 25px;
    }
    
    #td_title {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #first_tr {
        border-bottom: 1.5px solid;
    }

    tr + tr {
        border-top: 1px solid;
    }
</style>

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                <li><a href="/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
                <li class="active"><a href="">행사 통계</a></li>
            </ul>
        </div>
    </div>
    <div class="contents static">
        <div class="pr-tabs">
            <ul class="s-tabs2">
                <li><a href="/exhibition/exhibition-statistics-apply/<?=$id?>">행사신청</a></li>
                <li>
                    <a href="/exhibition/exhibition-statistics-participant/<?=$id?>">행사참가</a>
                </li>
                <li class="active">
                    <a href="">스트리밍</a>
                    <ul class="s-sub s-sub2" style="width:900px; border:none; padding:0px;">
                        <?php if ($exhibition['is_vod'] == 0): ?>
                            <li class="active"><a href="/exhibition/exhibition-statistics-stream/<?=$id?>">라이브</a></li>
                        <?php elseif ($exhibition['is_vod'] == 1): ?>
                            <li class="active"><a href="/exhibition/exhibition-statistics-vod/<?=$id?>">VOD</a></li>
                        <?php else: ?>
                            <li class="active"><a href="/exhibition/exhibition-statistics-stream/<?=$id?>">라이브</a></li>
                            <li class="active"><a href="/exhibition/exhibition-statistics-vod/<?=$id?>">VOD</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li>
                    <a href="/exhibition/exhibition-statistics-extra/<?=$id?>">기타</a>
                </li>
            </ul>
        </div>
        <div class="pr5-graph">
            <div class="cate" style="height:30px;"></div>
            <div class="pr-graph2">
                <div class="graph-bx">
                    <h3 class="s-hty2">총 조회수<p style="color:gray; font-size:5px;">총 주회수 = 각 영상의 조회수의 합</p></h3>
                    <div style="text-align: center;">
                        <strong><?= $sum ?>회</strong>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">평균 조회수<p style="color:gray; font-size:5px;">평균 조회수 = 총 조회수/VOD개수</p></h3>
                    <div style="text-align: center;">
                        <strong><?= $sum/$vod_count ?>회</strong>
                    </div>
                </div>
            </div>
                <br><br>
                <h3 class="s-hty2">영상별 조회수</h3>
                <br>
                <div class="graph-bx">
                    <table>
                        <tr id="first_tr" style="text-align: center; font-weight: bold;">
                            <th style="width: 90%;">VOD 제목</th>
                            <th>조회수</th>
                        </tr>
                        <?php
                            foreach ($exhibitionVods as $exhibitionVod):
                                if ($exhibitionVod->parent_id != null):
                        ?>
                                    <tr>
                                        <td id="td_title"><?= $exhibitionVod->title ?></td>
                                        <td style="text-align: center;"><?= $exhibitionVod->viewer ?></td>
                                    </tr>
                        <?php  
                                endif;
                            endforeach;
                        ?>
                    </table>
                </div>
            <br>         
        </div>
    </div>
</div>

<script type="text/javascript" charset="utf-8" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>