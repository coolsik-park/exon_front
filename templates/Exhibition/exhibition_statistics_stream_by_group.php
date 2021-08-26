<?= $this->Html->link(__('행사 신청'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 참가'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipant', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('스트리밍'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('기타'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsExtra', $id, 'class' => 'side-nav-item']) ?> 
<br>
<?php
    echo $this->Html->link(__('전체 '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsStream', $id, 'class' => 'side-nav-item']);
    foreach ($exhibitionGroup as $group) {
        echo $this->Html->link(__($group->name.' '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsStreamByGroup', $id, $group->id, 'class' => 'side-nav-item']);
    }
?>

<?php
    echo '<br><br>';
    echo '참가자 수 : ' . $participantData['participant'] . '<br>';
    echo '출석자 수 : ' . $participantData['attended'] . '<br>';
    echo '결석자 수 : ' . ($participantData['participant'] - $participantData['attended']);
    echo '<br><br>';
    echo '받은 질문 수 : ' . $answeredData['total'] . '<br>';
    echo '응답 질문 수 : ' . $answeredData['answered'] . '<br>';
    echo '미 응답 질문 수 : ' . ($answeredData['total'] - $answeredData['answered']);
?>