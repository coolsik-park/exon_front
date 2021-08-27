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
<br>
<?php
    echo $this->Html->link(__('전체 '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipant', $id, 'class' => 'side-nav-item']);
    foreach ($exhibitionGroup as $group) {
        echo $this->Html->link(__($group->name.' '), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsParticipantByGroup', $id, $group->id, 'class' => 'side-nav-item']);
    }
?>
<br><br>
<?php
    $total = 0;
    $participants = 0;
    foreach ($applyRates as $applyRate) {
        $total += (int)$applyRate->count;

        if ($applyRate->status == '4') {
            $participants += (int)$applyRate->count;
        }
    }

    echo "현재 신청자 수 : " . $total . "<br>";
    echo "행사 참가자 수 : " . $participants . "<br>";
    echo "대기자 수 : " . ($total - $participants) . "<br>";
    echo "<br>";

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

    echo "참가자 나이 대<br>";
    echo "10세 미만 : " . $zero . "<br>";
    echo "10대 : " . $ten . "<br>"; 
    echo "20대 : " . $twenty . "<br>";
    echo "30대 : " . $thirty . "<br>";
    echo "40대 : " . $fourty . "<br>";
    echo "50대 : " . $fifty . "<br>";
    echo "60대 이상 : " . $sixty . "<br>";
    echo "<br>";
    
    $femail = 0;
    $mail = 0;

    foreach ($genderRates as $genderRate) {
        if ($genderRate->users_sex == 'F') {
            $femail += $genderRate->count;
        }else {
            $mail += $genderRate->count;
        }
    }
    
    echo "참가자 성비<br>";
    echo "남 : " . $mail . "<br>";
    echo "여 : " . $femail . "<br>";
?>