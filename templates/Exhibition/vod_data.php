<style>
    .paginator {
        text-align: center;
    }

    .pagination {
        display: inline-block;
        width: 100%;
    }

    .pagination li {
        display: inline;
    }

    .board-sh {
        margin: 0 auto;
    } 
    @media  screen and (min-width: 1100px) {
        .modal-dialog {
            margin: 25px auto;
        }
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                <li class="active"><a href="">참가자 관리</a></li>
                <?php if ($exhibition->is_vod == 0) : ?> 
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                <?php elseif ($exhibition->is_vod == 1) : ?>
                <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php else : ?>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정(라이브)</a></li>
                <li><a href="/exhibition-stream/set-exhibition-vod/<?= $id ?>">웨비나 송출 설정(VOD)</a></li>
                <?php endif; ?>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>        
    <div class="contents static">
        <h2 class="sr-only">참가자 관리</h2>
        <div class="pr3-title">                            
            <ul class="s-tabs2">
                <li><a href="/exhibition/manager-person/<?=$id?>">참가자</a></li>
                <li><a href="/exhibition/send-sms-to-participant/<?=$id?>">문자</a></li>
                <li><a href="/exhibition/send-email-to-participant/<?=$id?>">이메일</a></li>
                <li class="active"><a href="/exhibition/vod-data/<?=$id?>">VOD</a></li>
            </ul>
            <h3 class="s-hty1">참가자</h3>    
        </div>
        <div class="pr3-section1" id="pr3-section1">
            <div class="table-type table-type3">
                <div class="th-row">
                    <div class="th-col col1">인적 사항</div>
                    <div class="th-col col2">총 조회수</div>
                    <div class="th-col col3">시청 시간</div>
                    <div class="th-col col4">상세 보기</div>
                </div>
                <?php 
                    $index = $this->Paginator->current('ExhibitionUsers') * 10 - 9;
                    foreach ($exhibition_users as $key => $exhibition_user):
                        $method = '';
                        $same_day = 0;
                        if (!empty($exhibition_user->pay)) {
                            $method = $exhibition_user->pay['pay_method'];
                            $pay_date = date("Ymd", strtotime($exhibition_user->pay['created']));
                            $now_date = date("Ymd", strtotime(date('Y-m-d H:i:s', time()) . "+9 hours"));
                            if ($pay_date == $now_date) {
                                $same_day = 1;
                            }
                        }
                        if ($exhibition_user->status != 8):
                ?>
                            <div class="tr-row">
                                <div class="td-col col1">
                                    <div class="con ag-ty1">
                                        <p class="tit fir"><?=$index?>.</p>
                                        <?php $index++; ?>
                                        <p class="tit fir"><?= $exhibition_user->company ?></p>
                                        <p class="tit fir"><?= $exhibition_user->title ?></p>
                                        <div class="u-name">
                                            <p class="name"><?= $exhibition_user->users_name ?></p>
                                            <p class="age">
                                                <?php
                                                    if ($exhibition_user->users_sex == 'M') {
                                                        echo '남자 / ';
                                                    } else if ($exhibition_user->users_sex == 'F') {
                                                        echo '여자 / ';
                                                    } else {
                                                        echo '성별 미상 / ';
                                                    }
                                                ?>
                                                <?php 
                                                    if ($exhibition_user->users_id != null):
                                                        for ($i=0; $i<count($users); $i++) {
                                                            if ($exhibition_user->users_id == $users[$i]['id']) {
                                                                echo $users[$i]['age'];
                                                                break;
                                                            }
                                                        }
                                                    endif;
                                                ?>
                                            </p>
                                        </div>
                                        <p><?= $exhibition_user->users_email ?></p>
                                        <p><?= substr($exhibition_user->users_hp, 0, 3) ?>-<?= substr($exhibition_user->users_hp, 3, 4) ?>-<?= substr($exhibition_user->users_hp, 7, 4) ?></p>
                                    </div>                            
                                </div>
                                <div class="td-col col2">
                                    <?php echo count($exhibition_user->exhibition_vod_viewer); ?>
                                </div>
                                <div class="td-col col3">
                                    <?php
                                        $watched_duration = 0;
                                        foreach ($exhibition_user->exhibition_vod_viewer as $viewer) {
                                            $watched_duration = $watched_duration + $viewer['watching_duration'];
                                        }
                                        echo $watched_duration . '/' . $total_duration;
                                    ?>
                                </div>
                                <div class="td-col col4">
                                    <div class="con">
                                        <button type="button" class="btn-ty3 bor" style="cursor:pointer;" data-toggle="modal" data-target="#surveyCheckModal" data-backdrop="static" data-keyboard="false" onClick="surveyCheck(<?= $exhibition_user->id ?>, <?= count($users) ?>)">
                                            상세 보기
                                        </button>
                                    </div>
                                    <div class="modal fade" id="surveyCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="background-color:transparent; border:none;">
                                                <div class="popup-wrap">
                                                    <div class="popup-head">
                                                        <h1>상세 보기</h1>
                                                        <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                                    </div>
                                                    <div class="popup-body">  
                                                        <div class="pop-poll-items-wrap">
                                                            <div class="tr-row">
                                                                <div class="th-col col1">인적 사항</div>          
                                                                <div class="th-col col2">총 조회수</div>
                                                                <div class="th-col col3">시청 시간</div>
                                                            </div>
                                                              
                                                            <div class="tr-row">
                                                                <div class="th-col col1">
                                                                    <div class="con ag-ty1">
                                                                        <p class="tit fir"><?= $exhibition_user->company ?></p>
                                                                        <p class="tit fir"><?= $exhibition_user->title ?></p>
                                                                        <div class="u-name">
                                                                            <p class="name"><?= $exhibition_user->users_name ?></p>
                                                                            <p class="age">
                                                                                <?php
                                                                                    if ($exhibition_user->users_sex == 'M') {
                                                                                        echo '남자 / ';
                                                                                    } else if ($exhibition_user->users_sex == 'F') {
                                                                                        echo '여자 / ';
                                                                                    } else {
                                                                                        echo '성별 미상 / ';
                                                                                    }
                                                                                ?>
                                                                                <?php 
                                                                                    if ($exhibition_user->users_id != null):
                                                                                        for ($i=0; $i<count($users); $i++) {
                                                                                            if ($exhibition_user->users_id == $users[$i]['id']) {
                                                                                                echo $users[$i]['age'];
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    endif;
                                                                                ?>
                                                                            </p>
                                                                        </div>
                                                                        <p><?= $exhibition_user->users_email ?></p>
                                                                        <p><?= substr($exhibition_user->users_hp, 0, 3) ?>-<?= substr($exhibition_user->users_hp, 3, 4) ?>-<?= substr($exhibition_user->users_hp, 7, 4) ?></p>
                                                                    </div> 
                                                                </div>          
                                                                <div class="th-col col2">
                                                                    <?php echo count($exhibition_user->exhibition_vod_viewer); ?>
                                                                </div>
                                                                <div class="th-col col3">
                                                                    <?php
                                                                        $watched_duration = 0;
                                                                        foreach ($exhibition_user->exhibition_vod_viewer as $viewer) {
                                                                            $watched_duration = $watched_duration + $viewer['watching_duration'];
                                                                        }
                                                                        echo $watched_duration . '/' . $total_duration;
                                                                    ?>
                                                                </div>
                                                            </div>
                                                            <div class="tr-row">
                                                                <div class="th-col col1">VOD 제목</div>
                                                                <div class="th-col col2">시청 여부</div>
                                                                <div class="th-col col3">시청 시간</div>
                                                            </div>
                                                            <?php foreach ($exhibitionVods as $vod) : ?>
                                                                <div class="tr-row">
                                                                    <div class="th-col col1">
                                                                        <?=$vod['title']?>
                                                                    </div>
                                                                    <div class="th-col col2">
                                                                        <?php
                                                                            $watched = 0;
                                                                            foreach ($vod->exhibition_vod_viewer as $viewer) {
                                                                                if ($viewer['exhibition_users_id'] == $exhibition_user['id']) {
                                                                                    $watched = 1;
                                                                                }
                                                                            }
                                                                            if ($watched == 0) {
                                                                                echo '-';
                                                                            } else {
                                                                                echo '시청함';
                                                                            }
                                                                        ?>
                                                                    </div>
                                                                    <div class="th-col col3">
                                                                        <?php
                                                                            $watching_duration = 0;
                                                                            if ($vod->exhibition_vod_viewer != null) {
                                                                                foreach ($vod->exhibition_vod_viewer as $viewer) {
                                                                                    if ($viewer['exhibition_users_id'] == $exhibition_user['id']) {
                                                                                        $watching_duration = $viewer['watching_duration'];
                                                                                    }
                                                                                }
                                                                            }
                                                                            echo $watching_duration . '/' . $total_duration;
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>        
                                                        <div class="popup-btm alone">     
                                                            <button type="button" class="btn-ty2" data-dismiss="modal" aria-label="Close">확인</button>
                                                        </div>        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                <?php 
                        endif;
                    endforeach;
                ?>
            </div>
            <div class="paginator">
                <ul class="pagination">
                    <?= $this->Paginator->prev('< ' . __('이전')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('다음') . ' >') ?>
                </ul>
            </div>
        </div>    
    </div>        
</div>
<footer id="footer"></footer>

<script>
    
</script>