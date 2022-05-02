<?php
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
                <li><a href="/exhibition/exhibition-statistics-apply/<?=$id?>">행사신청</a></li>
                <li>
                <a href="/exhibition/exhibition-statistics-participant/<?=$id?>">행사참가</a>
                </li>
                <li class="active">
                    <a href="">스트리밍</a>
                    <ul class="s-sub s-sub2" style="width:900px; border:none; padding:0px;">
                        <li class=""><a href="/exhibition/exhibition-statistics-stream/<?=$id?>">전체</a></li>
                        <?php foreach ($exhibitionGroup as $exGroup) : ?>
                        <li id="<?=$exGroup->id?>"><a href="/exhibition/exhibition-statistics-stream-by-group/<?=$id?>/<?=$exGroup->id?>"><?=$exGroup->name?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>
                    <a href="/exhibition/exhibition-statistics-extra/<?=$id?>">기타</a>
                </li>
            </ul>
        </div>
        <div class="pr5-graph">
            <div class="cate" style="height:30px;">
                <!-- <select>
                    <option>1차 웨비나</option>
                    <option>2차 웨비나</option>
                </select> -->
            </div>
            <div class="pr-graph2">
                <div class="graph-bx">
                    <h3 class="s-hty2">참가자 수</h3>
                    <div>
                        <canvas id="chart1" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">받은 질문 수</h3>
                    <div>
                        <canvas id="chart2" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto;"></canvas>
                    </div>
                </div>
            </div>
            <br>
            <div class="pr-graph2">
                <div class="graph-bx">
                    <h3 class="s-hty2">시청자 나이 대<p style="color:gray; font-size:5px;">(비회원 및 생년월일 미기입자는 표시되지 않습니다.)</p></h3>
                    <div>
                        <canvas id="chart3" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto;"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">시청자 성비</h3>
                    <div>
                        <canvas id="chart4" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto;"></canvas>
                    </div>
                </div>
            </div>
            <!-- // -->                
        </div>
    </div>        
</div>

<script type="text/javascript" charset="utf-8" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script> 
<script src="https://cdn.jsdelivr.net/gh/emn178/chartjs-plugin-labels/src/chartjs-plugin-labels.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-colorschemes"></script>

<script>    
    var target = document.getElementById('<?=$group?>');
    $(target).attr("class", "active");

    var ctx = document.getElementById('chart1');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['출석자 수', '결석자 수'],
            datasets: [{
                data: [<?=$participantData['attended']?>, <?=$participantData['participant'] - $participantData['attended']?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: true,
                text: '참가자 수 : <?=$participantData['participant']?>'
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
            labels: ['응답 질문 수', '미 응답 질문 수'],
            datasets: [{
                data: [<?=$answeredData['answered']?>, <?=$answeredData['total'] - $answeredData['answered']?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: true,
                text: '받은 질문 수 : <?=$answeredData['total']?>'
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
            labels: ['10대', '20대', '30대', '40대', '50대', '60세 이상'],
            datasets: [{
                data: [<?=$ten?>, <?=$twenty?>, <?=$thirty?>, <?=$fourty?>, <?=$fifty?>, <?=$sixty?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: false,
                text: '시청자 나이 대'
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

    var ctx = document.getElementById('chart4');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['남', '여'],
            datasets: [{
                data: [<?=$mail?>, <?=$femail?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: false,
                text: '시청자 성별'
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