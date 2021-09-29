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
<br>
<?php
    echo $this->Html->link(__('전체 '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipant', $id, 'class' => 'side-nav-item']);
    foreach ($exhibitionGroup as $group) {
        echo $this->Html->link(__($group->name.' '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipantByGroup', $id, $group->id, 'class' => 'side-nav-item']);
    }
?>
<br><br> -->
<?php
    $total = 0;
    $participants = 0;
    foreach ($applyRates as $applyRate) {
        $total += (int)$applyRate->count;

        if ($applyRate->status == '4') {
            $participants += (int)$applyRate->count;
        }
    }

    // echo "현재 신청자 수 : " . $total . "<br>";
    // echo "행사 참가자 수 : " . $participants . "<br>";
    // echo "대기자 수 : " . ($total - $participants) . "<br>";
    // echo "<br>";

    $zero = 0;
    $ten = 0;
    $twenty = 0;
    $thirty = 0;
    $fourty = 0;
    $fifty = 0;
    $sixty = 0;

    foreach ($ages as $age) {
        switch ((int)substr($age, 0, 1)) {
            case 0 : break;
            case 1 : $ten++; break;
            case 2 : $twenty++; break;
            case 3 : $thirty++; break;
            case 4 : $fourty++; break;
            case 5 : $fifty++; break;
            case (int)substr($age, 0, 1) >= 6 : $sixty++; break;
            default : $zero++; break; 
        }
    }

    // echo "참가자 나이 대<br>";
    // echo "10세 미만 : " . $zero . "<br>";
    // echo "10대 : " . $ten . "<br>"; 
    // echo "20대 : " . $twenty . "<br>";
    // echo "30대 : " . $thirty . "<br>";
    // echo "40대 : " . $fourty . "<br>";
    // echo "50대 : " . $fifty . "<br>";
    // echo "60대 이상 : " . $sixty . "<br>";
    // echo "<br>";
    
    $femail = 0;
    $mail = 0;

    foreach ($genderRates as $genderRate) {
        if ($genderRate->users_sex == 'F') {
            $femail += $genderRate->count;
        }else {
            $mail += $genderRate->count;
        }
    }
    
    // echo "참가자 성비<br>";
    // echo "남 : " . $mail . "<br>";
    // echo "여 : " . $femail . "<br>";
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
                <li><a href="/exhibition/exhibition-statistics-apply/<?=$id?>">행사신청</a></li>
                <li class="active">
                    <a href="">행사참가</a>
                    <ul class="s-sub s-sub1">
                        <li class="active"><a href="">전체</a></li>
                        <?php foreach ($exhibitionGroup as $group) : ?>
                        <li><a href="/exhibition/exhibition-statistics-participant-by-group/<?=$id?>/<?=$group->id?>"><?=$group->name?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>
                    <a href="/exhibition/exhibition-statistics-stream/<?=$id?>">스트리밍</a>
                </li>
                <li>
                    <a href="/exhibition/exhibition-statistics-extra/<?=$id?>">기타</a>
                </li>
            </ul>
        </div>
        <div class="pr5-graph mgtS2">
            <h2 class="sr-only">행사참가</h2>
            <div class="pr-graph3">
                <div class="graph-bx">
                    <h3 class="s-hty2">현재 신청자 수</h3>
                    <div>
                        <canvas id="chart1" style="width:315.59px; height:300px;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">참가자 나이 대</h3>
                    <div>
                        <canvas id="chart2" style="width:315.59px; height:300px;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">참가자 성비</h3>
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
            labels: ['행사 참가자 수', '대기자 수'],
            datasets: [{
                data: [<?=$participants?>, <?=$total-$participants?>],
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
                text: '현재 신청자 수 : <?=$total?>'
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
                text: '참가자 나이 대'
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
                text: '참가자 성비'
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