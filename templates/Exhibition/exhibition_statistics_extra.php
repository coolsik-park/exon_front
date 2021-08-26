<?= $this->Html->link(__('행사 신청'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 참가'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipant', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('스트리밍'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('기타'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsExtra', $id, 'class' => 'side-nav-item']) ?> 
<br><br>
<?php
    echo '설문 별 응답률<br><br>';
    if ($answerRates != null) {
        foreach ($answerRates as $answerRate) {
            foreach ($applyRates as $applyRate) {
                echo $answerRate->text . ' : ' . $answerRate->count . '/' . $applyRate->count . '<br>';
            }
        }
    } else {
        echo '응답한 설문이 없습니다.<br>';
    }
    
    echo '<br>';
    echo '참가자 수 : ' . $totalParticipant . '<br>';
    echo '재방문 참가자 수 : ' . $participatedCount . '<br>';
    echo '첫방문 참가자 수 : ' . ($totalParticipant - $participatedCount);
?>