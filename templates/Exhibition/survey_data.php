<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>

<?php    
    echo "<br><br>사전 설문 데이터<br><br>";
    if ($beforeParentData[0] == null) {
        echo "<br><br>등록된 설문이 없습니다.<br><br>";
    } else {
        foreach ($beforeParentData as $parentData) {
?>
            <input type ="checkbox" name = "checked" value = <?= $parentData['id'] ?>>
            <table class="table table-bordered" id = <?= $parentData['id'] ?>>
            <tr>
                <td><?php echo $parentData['text']; ?></td>
            </tr>
<?php
            if ($parentData['is_multiple'] == 'Y') {
                foreach ($beforeChildData[$parentData['id']] as $childData) {
?>
                <tr>
                    <td><?php echo $childData['text']; ?></td>
                    <td><?php echo $childData['count']; ?></td>
                </tr>
<?php
                }
            } else {
                foreach ($parentData['exhibition_survey_users_answer'] as $answer) {
?>
                <tr>
                    <td><?php echo $answer['text'] ?></td>
                </tr>
<?php
                }
            }
?>
            </table>
            <br>
<?php              
        } 
    }
?>

<?php    
    echo "<br><br>설문 데이터<br><br>";
    if ($normalParentData[0] == null) {
        echo "<br><br>등록된 설문이 없습니다.<br><br>";
    } else {
        foreach ($normalParentData as $parentData) {
?>
            <input type ="checkbox" name = "checked" value = <?= $parentData['id'] ?>>
            <table class="table table-bordered" id = <?= $parentData['id'] ?>>
                <tr>
                    <td><?php echo $parentData['text']; ?></td>
                </tr>
<?php
            if ($parentData['is_multiple'] == 'Y') {
                foreach ($normalChildData[$parentData['id']] as $childData) {
?>
                <tr>
                    <td><?php echo $childData['text']; ?></td>
                    <td><?php echo $childData['count']; ?></td>
                </tr>
<?php
                }
            } else {
                foreach ($parentData['exhibition_survey_users_answer'] as $answer) {          
?>
                <tr>
                    <td><?php echo $answer['text'] ?></td>
                </tr>
<?php
                }
            }
?>
            </table>
            <br>
<?php              
        } 
    }
?>