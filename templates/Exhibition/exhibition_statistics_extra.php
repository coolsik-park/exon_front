<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>
<br>
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
    echo '참가자 수 : ' . $participatedData['total'] . '<br>';
    echo '재방문 참가자 수 : ' . $participatedData['participated'] . '<br>';
    echo '첫방문 참가자 수 : ' . ($participatedData['total'] - $participatedData['participated']);
?>