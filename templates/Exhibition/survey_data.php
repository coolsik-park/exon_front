<!-- <?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>

<?php
    echo $this->Form->create();
    echo $this->Form->submit('다운로드');    
    echo "<br><br>사전 설문 데이터<br><br>";
    if ($beforeParentData[0] == null) {
        echo "<br><br>등록된 설문이 없습니다.<br><br>";
    } else {
        foreach ($beforeParentData as $parentData) {
            echo $this->Form->checkbox('checked[]', ['value' => $parentData['id'], 'checked' => 'checked', 'hiddenField' => false]);
?>
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
            echo $this->Form->checkbox('checked[]', ['value' => $parentData['id'], 'checked' => 'checked', 'hiddenField' => false]);
?>
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
    echo $this->Form->end();
?> -->

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li class="active"><a href="">설문 데이터</a></li>
                <li><a href="/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>
    <?php
    echo $this->Form->create();
    ?>
    <div class="contents static">
        <h2 class="sr-only">설문 데이터</h2>
        <div class="section8 fir">
            <div class="sect-tit">
                <h3 class="s-hty1">사전 설문 데이터</h3>
                <div class="btn-wp">
                    <input type="submit" value="다운로드" class="btn-ty2 bor">
                </div>
            </div>
            <!-- item -->
            <?php
                if ($beforeParentData[0] != '') { 
                    foreach ($beforeParentData as $parentData) {
            ?>
            <div class="p-data-item-wp">
                <label class="chk-dsg2"><input type="checkbox" id="checked[]" name="checked[]"
                        value=<?=$parentData['id'] ?>><span>선택</span></label>
                <div class="p-data-item">
                    <h3 class="tit">
                        <?= $parentData['text'] ?>
                    </h3>
                    <?php
                            if ($parentData['is_multiple'] == 'Y') {
                                foreach ($beforeChildData[$parentData['id']] as $childData) {
                        ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:20%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?>
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                }
                            } else {
                        ?>
                    <div class="con">
                        <?php        
                                foreach ($parentData['exhibition_survey_users_answer'] as $answer) {
                        ?>
                        <ul>
                            <li>
                                <?= $answer['text'] ?>
                            </li>
                        </ul>
                        <?php
                                }
                        ?>
                    </div>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <?php
                        }
                    }
                ?>
        </div>

        <div class="section8">
            <div class="sect-tit">
                <h3 class="s-hty1">설문 데이터</h3>
            </div>

            <!-- item -->
            <?php 
                    if ($normalParentData[0] != '') {
                        foreach ($normalParentData as $parentData) {
                ?>
            <div class="p-data-item-wp">
                <label class="chk-dsg2"><input type="checkbox" id="checked[]" name="checked[]"
                        value=<?=$parentData['id'] ?>><span>선택</span></label>
                <div class="p-data-item">
                    <h3 class="tit">
                        <?= $parentData['text'] ?>
                    </h3>
                    <?php
                            if ($parentData['is_multiple'] == 'Y') {
                                foreach ($normalChildData[$parentData['id']] as $childData) {
                        ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:20%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?>
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                }
                            } else {
                        ?>
                    <div class="con">
                        <?php        
                                foreach ($parentData['exhibition_survey_users_answer'] as $answer) {
                        ?>
                        <ul>
                            <li>
                                <?= $answer['text'] ?>
                            </li>
                        </ul>
                        <?php
                                }
                        ?>
                    </div>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <?php
                        }
                    }
                ?>
        </div>
    </div>
    <?php
    echo $this->Form->end();
    ?>
</div>