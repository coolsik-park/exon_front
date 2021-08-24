<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatistics', $exhibition->id, 'class' => 'side-nav-item']) ?>

<?php
    echo "<br><br>사전 설문 데이터<br><br>";
    foreach ($surveyData as $data) {
        if ($data['survey_type'] == 'B') {
            if ($data['is_multiple'] == 'Y') {
                if ($data['parent_id'] != null) {
                    echo $data['text'] . " " . $data['count'] .  "<br>";
                } else {
                    echo $data['text'] . "<br>";
                }
            } else {
                $count = count($data['exhibition_survey_users_answer']);
                $answers[] = '';
                for ($i = 0; $i < $count; $i++) {
                    $answers[$i] = $data['exhibition_survey_users_answer'][$i]['text'];
                }
                echo $data['text'] . "<br>";
                foreach ($answers as $answer) {
                    echo $answer . "<br>";
                }   
            }
        }
    }
    echo "<br><br>설문 데이터<br><br>";
    foreach ($surveyData as $data) {
        if ($data['survey_type'] == 'N') {
            if ($data['is_multiple'] == 'Y') {
                if ($data['parent_id'] != null) {
                    echo $data['text'] . " " . $data['count'] . "<br>";
                } else {
                    echo $data['text'] . "<br>";
                }
            } else {
                $count = count($data['exhibition_survey_users_answer']);
                $answers[] = '';
                for ($i = 0; $i < $count; $i++) {
                    $answers[$i] = $data['exhibition_survey_users_answer'][$i]['text'];
                }
                echo $data['text'] . "<br>";
                foreach ($answers as $answer) {
                    echo $answer . "<br>";
                }   
            }
        }
    }
    // 질문별 분리하기
?>