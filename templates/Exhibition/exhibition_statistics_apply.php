<!-- <?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>
<br>
<?= $this->Html->link(__('행사 신청'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 참가'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipant', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('스트리밍'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('기타'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsExtra', $id, 'class' => 'side-nav-item']) ?> 
<br><br> -->
<?php
    $total = 0;
    $canceled = 0;
    foreach ($applyRates as $applyRate) {
        $total += (int)$applyRate->count;

        if ($applyRate->status == '8') {
            $canceled += (int)$applyRate->count;
        }
    }

    $unknown = 0;
    $zero = 0;
    $ten = 0;
    $twenty = 0;
    $thirty = 0;
    $fourty = 0;
    $fifty = 0;
    $sixty = 0;

    foreach ($ages as $age) {
        switch ((int)substr($age, 0, 1)) {
            case 0 : $unknown++; break;
            case 1 : $ten++; break;
            case 2 : $twenty++; break;
            case 3 : $thirty++; break;
            case 4 : $fourty++; break;
            case 5 : $fifty++; break;
            case (int)substr($age, 0, 1) >= 6 : $sixty++; break;
            default : $zero++; break; 
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
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
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
                    <a href="/exhibition/exhibition-statistics-stream/<?=$id?>">스트리밍</a>
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
                    <h3 class="s-hty2">현재 신청자 나이 대</h3>
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
            labels: ['10대', '20대', '30대', '40대', '50대', '60세 이상', '미기입'],
            datasets: [{
                data: [<?=$ten?>, <?=$twenty?>, <?=$thirty?>, <?=$fourty?>, <?=$fifty?>, <?=$sixty?>, <?=$unknown?>],
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