<?php
    $total = 0;
    $canceled = 0;
    foreach ($applyRates as $applyRate) {
        $total += (int)$applyRate->count;

        if ($applyRate->status == '8') {
            $canceled += (int)$applyRate->count;
        }
    }

    $zero = 0;
    $ten = 0;
    $twenty = 0;
    $thirty = 0;
    $fourty = 0;
    $fifty = 0;
    $sixty = 0;

    foreach ($ages as $age) {
        switch ((int)substr($age, 0, 1)) {
            case 0 : $zero++; break; 
            case 1 : $ten++; break;
            case 2 : $twenty++; break;
            case 3 : $thirty++; break;
            case 4 : $fourty++; break;
            case 5 : $fifty++; break;
            default : $sixty++; break;
        }
    }

    $femail = 0;
    $mail = 0;

    foreach ($genderRates as $genderRate) {
        if ($genderRate->users_sex == 'F') {
            $femail += $genderRate->count;
        }else {
            $mail += $genderRate->count;
        }
    }
?>

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                <li><a href="/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                <?php if ($exhibition->is_vod == 0) : ?> 
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                <?php elseif ($exhibition->is_vod == 1) : ?>
                <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php else : ?>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php endif; ?>
                <li class="active"><a href="">행사 통계</a></li>
            </ul>
        </div>
    </div>        
    <div class="contents static">
        <div class="pr-tabs">
            <ul class="s-tabs2">
                <li class="active"><a href="">행사신청</a></li>
                <li>
                    <a href="/exhibition/exhibition-statistics-participant/<?=$id?>">행사참가</a>
                </li>
                <li>
                    <?php if ($exhibition->is_vod == 1) : ?>
                        <a href="/exhibition/exhibition-statistics-vod/<?=$id?>">스트리밍</a>
                    <?php else : ?>
                        <a href="/exhibition/exhibition-statistics-stream/<?=$id?>">스트리밍</a>
                    <?php endif; ?>
                </li>
                <li>
                    <a href="/exhibition/exhibition-statistics-extra/<?=$id?>">기타</a>
                </li>
            </ul>
        </div>
        <div class="pr5-graph">
            <h2 class="sr-only">행사신청</h2>
            <div class="pr-graph3">
                <div class="graph-bx">
                    <h3 class="s-hty2">전체 신청자 수</h3>
                    <div>
                        <canvas id="chart1" style="width:315.59px; height:300px;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">현재 신청자 나이 대<p style="color:gray; font-size:5px;">(비회원 및 생년월일 미기입자는 표시되지 않습니다.)</p></h3>
                    <div>
                        <canvas id="chart2" style="width:315.59px; height:300px;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">현재 신청자 성비</h3>
                    <div>
                        <canvas id="chart3" style="width:315.59px; height:300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>        
</div>

<script type="text/javascript" charset="utf-8" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>

<script>
    var ctx = document.getElementById('chart1');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['현재 신청자 수', '신청 취소자 수'],
            datasets: [{
                data: [<?=$total - $canceled?>, <?=$canceled?>],
                // backgroundColor: [
                //     'rgba(255, 99, 132, 0.2)',
                //     'rgba(54, 162, 235, 0.2)',
                // ],
                // borderColor: [
                //     'rgba(255, 99, 132, 1)',
                //     'rgba(54, 162, 235, 1)',
                // ],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: true,
                text: '전체 신청자 수 : <?=$total?>'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    precision: 1,
                    position: 'default',
                },
                colorschemes: {
                    scheme: 'brewer.PastelOne6',
                },
            },
            responsive: false, 
        }
    });

    var ctx = document.getElementById('chart2');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['10대', '20대', '30대', '40대', '50대', '60세 이상'],
            datasets: [{
                data: [<?=$ten?>, <?=$twenty?>, <?=$thirty?>, <?=$fourty?>, <?=$fifty?>, <?=$sixty?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: false,
                text: '현재 신청자 나이 대'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    precision: 1,
                    position: 'default',
                },
                colorschemes: {
                    scheme: 'brewer.PastelOne6',
                },
            },
            responsive: false, 
        }
    });

    var ctx = document.getElementById('chart3');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['남', '여'],
            datasets: [{
                data: [<?=$mail?>, <?=$femail?>,],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: false,
                text: '현재 신청자 성비'
            },
            plugins: {
                labels: {
                    render: 'percentage',
                    precision: 1,
                    position: 'default',
                },
                colorschemes: {
                    scheme: 'brewer.PastelOne6',
                },
            },
            responsive: false, 
        }
    });
</script>