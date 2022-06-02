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
                <li>
                    <a href="/exhibition/exhibition-statistics-stream/<?=$id?>">스트리밍</a>
                </li>
                <li class="active">
                    <a href="">기타</a>
                    <ul class="s-sub s-sub3" style="width:900px; border:none; padding:0px;">
                        <li class=""><a href="/exhibition/exhibition-statistics-extra/<?=$id?>">전체</a></li>
                        <?php foreach ($exhibitionGroup as $exGroup) : ?>
                        <li id="<?=$exGroup->id?>"><a href="/exhibition/exhibition-statistics-extra-by-group/<?=$id?>/<?=$exGroup->id?>"><?=$exGroup->name?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="pr5-graph mgtS2">
            <h3 class="sr-only">기타</h3>
            <div class="pr-graph2">
                <div class="graph-bx">
                    <h3 class="s-hty2">설문 별 응답률</h3>
                    <div>
                        <canvas id="chart1" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto"></canvas>
                    </div>
                </div>
                <div class="graph-bx">
                    <h3 class="s-hty2">참가자 수</h3>
                    <div>
                        <canvas id="chart2" style="width:315.59px; height:300px; margin-left:auto; margin-right:auto"></canvas>
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
    var target = document.getElementById('<?=$group?>');
    $(target).attr("class", "active");

    var ctx = document.getElementById('chart1');
    var myChart = new Chart(ctx, {
        // plugins: [{
        //     afterDraw: chart => {
        //         var ctx = chart.chart.ctx;
        //         ctx.save();
        //         ctx.textAlign = 'left';
        //         ctx.textBaseline = 'middle';
        //         ctx.font = "12px Arial";
        //         let sum =  chart.config.data.datasets[0].data.reduce((v, s) => v + s, 0);
        //         var xAxis = chart.scales['x-axis-0'];
        //         var yAxis = chart.scales["y-axis-0"];
        //         yAxis.ticks.forEach((v, i) => {
        //             var label = chart.data.labels[i];
        //             var value = chart.data.datasets[0].data[i];
        //             var x = xAxis.getPixelForValue(value) + 5;
        //             var y = yAxis.getPixelForTick(i);             
        //             let percent = (value * 100 / sum).toFixed(2);
        //             ctx.fillText(' (' + percent + '%)', x, y);
        //             ctx.fillStyle = "rgba(63,103,126,1)";
        //         });
        //     }
        // }],
        type: 'horizontalBar',
        data: {
            labels: [
                <?php foreach ($answerRates as $answerRate) : ?>
                    '<?=$answerRate->text?>',
                <?php endforeach; ?>
                ],
            datasets: [{
                label: '응답자 수',
                data: [
                    <?php foreach ($answerRates as $answerRate) : ?>
                        '<?=$answerRate->count?>',
                    <?php endforeach; ?>
                    ],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: false,
                text: '설문 별 응답률'
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
            tooltips: {
                titleFontSize: 8,
                bodyFontSize: 8
            },
            responsive: false, 
            scales: {
                xAxes: [{
                    ticks: {
                        beginAtZero: true,
                        max: <?=$applyRates[0]->count?>,
                        stepSize: 1,
                    }
                }],
                yAxes: [{
                    ticks: {
                        display: false,
                    }
                }],
            },
        }
    });

    var ctx = document.getElementById('chart2');
    var myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['재방문 참가자 수', '첫 방문 참가자 수'],
            datasets: [{
                data: [<?=$participatedData['participated']?>, <?=$participatedData['total'] - $participatedData['participated']?>],
                borderWidth: 1,
            }]
        },
        options: {
            title: {
                display: true,
                text: '참가자 수 : <?=$participatedData['total']?>'
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