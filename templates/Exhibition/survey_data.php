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
        <?php if ($beforeParentData[0] != '') : ?>
        <div class="section8 fir">
            <div class="sect-tit">
                <h3 class="s-hty1">사전 설문 데이터<p style="color:gray; font-size:5px;">(비회원 참가자의 데이터는 다운로드 되지 않습니다.)</p></h3>
                <div class="btn-wp">
                    <input type="submit" value="다운로드" class="btn-ty2 bor">
                </div>
            </div>
            <!-- item -->
            <?php 
            if ($beforeParentData[0] != '') {
                foreach ($beforeParentData as $parentData) {
                    $count = 0;
                    if ($parentData['is_multiple'] == 'Y') {
                        foreach ($beforeChildData[$parentData['id']] as $childData) {
                            $count += $childData['count'];
                        }
                    }
                    if ($count == 0 && $parentData['is_multiple'] == 'Y') {
            ?>
            <div class="p-data-item-wp">
                <label class="chk-dsg2"><input type="checkbox" id="checked[]" name="checked[]"
                        value=<?=$parentData['id'] ?> disabled="disabled"><span>선택</span></label>
                <div class="p-data-item">
                    <h3 class="tit">
                        <?= $parentData['text'] ?> <p style="font-size:10px;">(답변이 등록되지 않은 설문은 다운로드가 불가능합니다.)</p>
                    </h3>
                    <?php
                            if ($parentData['is_multiple'] == 'Y') {
                                $count = 0;
                                foreach ($beforeChildData[$parentData['id']] as $childData) {
                                    $count += $childData['count'];
                                }
                                
                                foreach ($beforeChildData[$parentData['id']] as $childData) {
                                    
                                    if ($count == 0) {
                                        $percentage = 0;
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    } else {

                                        $percentage = round($childData['count'] / $count * 100);
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    }
                                }
                            } else {
                        ?>
                    <div class="con">
                        <?php        
                                foreach ($parentData['exhibition_survey_users_answer'] as $answer) {
                                    if ($answer['text'] != null) {
                        ?>
                        <ul>
                            <li>
                                <?= $answer['text'] ?>
                            </li>
                        </ul>
                        <?php
                                    }
                                }
                        ?>
                    </div>
                    <?php
                            }
                        ?>
                </div>
            </div>
            <?php
                    }else {
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
                                $count = 0;
                                foreach ($beforeChildData[$parentData['id']] as $childData) {
                                    $count += $childData['count'];
                                }
                                
                                foreach ($beforeChildData[$parentData['id']] as $childData) {
                                    
                                    if ($count == 0) {
                                        $percentage = 0;
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    } else {

                                        $percentage = round($childData['count'] / $count * 100);
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    }
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
            }
            ?>
        </div>
        <?php endif; ?>

        <?php if ($normalParentData[0] != '') : ?>
        <div class="section8">
            <div class="sect-tit">
                <h3 class="s-hty1">설문 데이터<p style="color:gray; font-size:5px;">(비회원 참가자의 데이터는 다운로드 되지 않습니다.)</p></h3>
                <?php if ($beforeParentData[0] == '') : ?>
                <div class="btn-wp">
                    <input type="submit" value="다운로드" class="btn-ty2 bor">
                </div>
                <?php endif; ?>
            </div>

            <!-- item -->
            <?php 
            if ($normalParentData[0] != '') {
                foreach ($normalParentData as $parentData) {
                    $count = 0;
                    if ($parentData['is_multiple'] == 'Y') {
                        foreach ($normalChildData[$parentData['id']] as $childData) {
                            $count += $childData['count'];
                        }
                    }
                    if ($count == 0 && $parentData['is_multiple'] == 'Y') {
            ?>
            <div class="p-data-item-wp">
                <label class="chk-dsg2"><input type="checkbox" id="checked[]" name="checked[]"
                        value=<?=$parentData['id'] ?> disabled="disabled"><span>선택</span></label>
                <div class="p-data-item">
                    <h3 class="tit">
                        <?= $parentData['text'] ?>  <p style="font-size:10px;">(답변이 등록되지 않은 설문은 다운로드가 불가능합니다.)</p>
                    </h3>
                    <?php
                            if ($parentData['is_multiple'] == 'Y') {
                                $count = 0;
                                foreach ($normalChildData[$parentData['id']] as $childData) {
                                    $count += $childData['count'];
                                }
                                
                                foreach ($normalChildData[$parentData['id']] as $childData) {
                                    
                                    if ($count == 0) {
                                        $percentage = 0;
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    } else {

                                        $percentage = round($childData['count'] / $count * 100);
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    }
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
                    }else {
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
                                $count = 0;
                                foreach ($normalChildData[$parentData['id']] as $childData) {
                                    $count += $childData['count'];
                                }
                                
                                foreach ($normalChildData[$parentData['id']] as $childData) {
                                    
                                    if ($count == 0) {
                                        $percentage = 0;
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    } else {

                                        $percentage = round($childData['count'] / $count * 100);
                    ?>
                    <ul class="list">
                        <li>
                            <div class="p-data"><span class="tx">
                                    <?= $childData['text'] ?>
                                </span><span class="p-bar" style="width:<?=$percentage?>%"></span><span class="p-bar-tx">
                                    <?= $childData['count'] ?> (<?=$percentage?>%)
                                </span></div>
                        </li>
                    </ul>
                    <?php
                                    }
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
            }
            ?>
        </div>
    </div>
    <?php endif; ?>
    <?php echo $this->Form->end(); ?>

    <?php if ($beforeParentData[0] == '' && $normalParentData[0] == '') : ?>
    <div class="section8 fir" style="height:650px;">
        <div class="sect-tit">
            <h3 class="s-hty1">등록된 설문이 없습니다.</h3>
        </div>
    </div>
    <?php endif; ?>
</div>
