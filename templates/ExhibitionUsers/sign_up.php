<style>
    .pagination li {
        display: inline;
    }
</style>

<div id="container">
    <div class="contents static">
        <div class="section-my">
            <h3 class="s-hty1">신청 내역 관리</h3>
            <ul class="s-tabs">
                <?php if ($_SERVER['REQUEST_URI'] == '/exhibitionUsers/signUp/' . $id) { ?>
                        <li class="active"><a href="/exhibitionUsers/signUp/<?= $id ?>">신청 행사</a></li>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>/1">종료 행사</a></li>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>/2">취소/환불</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibitionUsers/signUp/' . $id . '/1') { ?>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>">신청 행사</a></li>
                        <li class="active"><a href="/exhibitionUsers/signUp/<?= $id ?>/1">종료 행사</a></li>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>/2">취소/환불</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibitionUsers/signUp/' . $id . '/2') { ?>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>">신청 행사</a></li>
                        <li class=""><a href="/exhibitionUsers/signUp/<?= $id ?>/1">종료 행사</a></li>
                        <li class="active"><a href="/exhibitionUsers/signUp/<?= $id ?>/2">취소/환불</a></li>
                <?php } ?>
            </ul>
            <div class="table-type table-type1">
                <div class="th-row">
                    <div class="th-col col1">신청 일시</div>
                    <div class="th-col col2">신청 행사</div>
                    <div class="th-col col3">행사 내용</div>
                    <div class="th-col col4">결제 내역</div>
                    <div class="th-col col5">승인 상태</div>
                    <div class="th-col col6">출석 여부</div>
                    <div class="th-col col7">신청 그룹</div>
                    <div class="th-col col8"></div>
                </div>
                <?php foreach ($exhibition_users as $exhibition_user): ?>
                    <div class="tr-row" id="tr-row">
                        <div class="td-col col1">
                            <div class="con">
                                <div class="date">
                                    <?= date("Y.m.d", strtotime($exhibition_user->created)) ?><br>
                                    <?php 
                                        $hour = date("A", strtotime($exhibition_user->created));
                                        $hour = date("H", strtotime($exhibition_user->created));
                                        $min = date("i", strtotime($exhibition_user->created));
                                        $today = new DateTime();
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo "오후 " . $hour . ":" . $min;
                                        } else {
                                            echo "오전 " . $hour . ":" . $min;
                                        }

                                        if ($today > $exhibition_user->exhibition['edate']) {
                                    ?>
                                            <br>
                                            <div class="state">종료</div>
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>                            
                        </div>
                        <div class="td-col col2">
                            <div class="con ag-ty1">
                                <p class="tit fir tit-name"><?= $exhibition_user->exhibition['title'] ?></p>
                                <p class="photo">
                                    <img src="<?= DS . $exhibition_user->exhibition['image_path'] . DS . $exhibition_user->exhibition['image_name'] ?>" alt="이미지없음">
                                </p>
                            </div>
                        </div>
                        <div class="td-col col3">
                            <div class="con ag-ty1">
                                <p class="tit fir">일시</p>
                                <p class="tit-con">
                                    <?php
                                        $date = date("Y.m.d", strtotime($exhibition_user->exhibition['sdate']));
                                        $hour = date("H", strtotime($exhibition_user->exhibition['sdate']));
                                        $min = date("i", strtotime($exhibition_user->exhibition['sdate'])); 
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo $date . " 오후 " . $hour . ":" . $min . " ~";
                                        } else {
                                            echo $date . " 오전 " . $hour . ":" . $min . " ~";
                                        }
                                    ?>
                                    <br>
                                    <?php
                                        $date = date("Y.m.d", strtotime($exhibition_user->exhibition['edate']));
                                        $hour = date("A", strtotime($exhibition_user->exhibition['edate']));
                                        $hour = date("H", strtotime($exhibition_user->exhibition['edate']));
                                        $min = date("i", strtotime($exhibition_user->exhibition['edate'])); 
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo $date . " 오후 " . $hour . ":" . $min;
                                        } else {
                                            echo $date . " 오전 " . $hour . ":" . $min;
                                        }
                                    ?>
                                </p>
                                <p class="tit">
                                    <span class="t1">주최자</span>
                                    <span class="t2"><?= $exhibition_user->exhibition['name'] ?></span>
                                </p>    
                            </div>
                        </div>
                        <div class="td-col col4">
                            <div class="con">
                                <?= number_format(intval($exhibition_user->exhibition_group['amount'])) ?>원
                            </div>
                        </div>
                        <div class="td-col col5">
                            <div class="con">
                                <?php
                                    if ($exhibition_user->attend == 1) {
                                        echo '신청 전';
                                    } elseif ($exhibition_user->attend == 2) {
                                        echo '신청완료<br>(참가대기)';
                                    } elseif ($exhibition_user->attend == 4) {
                                        echo '참가확정';
                                    } elseif ($exhibition_user->attend == 8) {
                                        echo '취소(환불)';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col6">
                            <div class="con">
                                <?php
                                    $today = new DateTime();

                                    if ($exhibition_user->attend == 1) {
                                        if ($today > $exhibition_user->exhibition['edate']) {
                                            echo '불참';
                                        } else {
                                            echo '-';
                                        }
                                    } elseif ($exhibition_user->attend == 2) {
                                        echo '참석';
                                    } elseif ($exhibition_user->attend == 4) {
                                        echo '시청완료';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col7">
                            <div class="con">
                                <p>그룹명</p>
                                <p><?= $exhibition_user->exhibition_group['name'] ?></p>
                            </div>
                        </div>
                        <div class="td-col col8">
                            <div class="mo-only"></div>
                            <div class="con">
                                <p><a href="#" class="btn-ty3 bor" id="pdfCreate">증빙</a></p>
                                <p>
                                    <?php
                                        $today = new DateTime();

                                        if ($today < $exhibition_user->exhibition['sdate']) {
                                    ?>
                                            <a href="#" class="btn-ty3 red" id="cancelButton">취소하기</a>
                                    <?php
                                        } elseif ($today > $exhibition_user->exhibition['edate']) {
                                    ?>
                                            <p><a href="#" class="btn-ty3 gray">취소하기</a></p>
                                    <?php
                                        } else {
                                            echo '진행중인 행사입니다.';
                                        }
                                    ?>
                                </p>
                                <?php
                                    $today = new DateTime();
                                    
                                    if ($exhibition_user->attend == 1) {
                                        if ($today <= $exhibition_user->exhibition['edate']) {
                                ?>
                                            <p><a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition_user->exhibition_stream_id ?>" class="btn-ty3 bor" id="exhibitionSee">웨비나 시청</a></p>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="paginatorAll">
                <div class="paginator" >
                    <ul class="pagination">
                        <?= $this->Paginator->prev('< ' . __('이전')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('다음') . ' >') ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>        
</div>
<footer id="footer"></footer>