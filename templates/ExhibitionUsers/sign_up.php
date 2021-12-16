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
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">
    <div class="contents static">
        <div class="section-my">
            <h3 class="s-hty1">신청 내역 관리</h3>
            <ul class="s-tabs">
                <?php if ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/application') { ?>
                        <li class="active"><a href="/exhibition-users/sign-up/application">신청 행사</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/close">종료 행사</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/cancel">취소/환불</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/close') { ?>
                        <li class=""><a href="/exhibition-users/sign-up/application">신청 행사</a></li>
                        <li class="active"><a href="/exhibition-users/sign-up/close">종료 행사</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/cancel">취소/환불</a></li>
                <?php } elseif ($_SERVER['REQUEST_URI'] == '/exhibition-users/sign-up/cancel') { ?>
                        <li class=""><a href="/exhibition-users/sign-up/application">신청 행사</a></li>
                        <li class=""><a href="/exhibition-users/sign-up/close">종료 행사</a></li>
                        <li class="active"><a href="/exhibition-users/sign-up/cancel">취소/환불</a></li>
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
                <?php 
                    foreach ($exhibition_users as $key => $exhibition_user): 
                        $d_today = strtotime(date('Y-m-d H:i:s', time()));
                        $sdate = strtotime($exhibition_user->exhibition['sdate']);
                        $edate = strtotime($exhibition_user->exhibition['edate']);
                ?>
                    <div class="tr-row">
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
                                            echo "오후 " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        } else {
                                            echo "오전 " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        }

                                        if ($d_today > $edate) {
                                            if ($exhibition_user->status == 8) {
                                    ?>
                                                <div class="state">환불 완료</div>
                                    <?php   } else { ?>
                                                <div class="state">종료</div> 
                                    <?php   
                                            }
                                        } 
                                    ?>
                                </div>
                            </div>                            
                        </div>
                        <div class="td-col col2">
                            <div class="con ag-ty1">
                                <p class="tit fir tit-name"><?= $exhibition_user->exhibition['title'] ?></p>
                                <p class="photo">
                                    <?php if ($exhibition_user->exhibition['image_path'] == null) { ?>
                                        <img src="../../images/img-no3.png">
                                    <?php } else { ?>
                                        <img src="<?= DS . $exhibition_user->exhibition['image_path'] . DS . $exhibition_user->exhibition['image_name'] ?>">
                                    <?php } ?>
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
                                            echo $date . " 오후 " . sprintf("%02d", $hour) . ":" . sprintf("%02d ~ ", $min);
                                        } else {
                                            echo $date . " 오전 " . sprintf("%02d", $hour) . ":" . sprintf("%02d ~ ", $min);
                                        }
                                    ?>
                                    <br>
                                    <?php
                                        $date = date("Y.m.d", strtotime($exhibition_user->exhibition['edate']));
                                        $hour = date("H", strtotime($exhibition_user->exhibition['edate']));
                                        $min = date("i", strtotime($exhibition_user->exhibition['edate'])); 
                                        
                                        if ($hour > 12) {
                                            $hour = $hour-12;
                                            echo $date . " 오후 " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
                                        } else {
                                            echo $date . " 오전 " . sprintf("%02d", $hour) . ":" . sprintf("%02d", $min);
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
                                <?php
                                    if ($exhibition_user->exhibition_group != null) {
                                        echo number_format(intval($exhibition_user->exhibition_group['amount'])) . "원";
                                    } else {
                                        echo '-';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col5">
                            <div class="con">
                                <?php
                                    if ($exhibition_user->status == 1) {
                                        echo '신청 전';
                                    } elseif ($exhibition_user->status == 2) {
                                        echo '신청완료<br>(참가대기)';
                                    } elseif ($exhibition_user->status == 4) {
                                        echo '참가확정';
                                    } elseif ($exhibition_user->status == 8) {
                                        echo '취소<br>(환불)';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col6">
                            <div class="con">
                                <?php
                                    $today = new DateTime();

                                    if ($exhibition_user->attend == 1) {
                                        if ($d_today > $edate) {
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
                                <p><?= $exhibition_user->exhibition_group['name']; ?></p>
                            </div>
                        </div>
                        <div class="td-col col8">
                            <?php if ($exhibition_user->status != 8){ ?>
                                <div class="con">
                                    <p><a href="/exhibition-users/download-pdf/<?= $exhibition_user->exhibition['id'] ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor">증빙</a></p>
                                    <?php                                    
                                    if ($d_today > $edate):
                                    else:
                                        if ($d_today >= $sdate):
                                            echo '진행중인 행사입니다.';
                                            if ($exhibition_user->status == 4):
                                    ?>
                                                <p><a href="/exhibition-stream/watch-exhibition-stream/<?= $exhibition_user->exhibition_id ?>/<?= $exhibition_user->id ?>" class="btn-ty3 bor" id="exhibitionSee">웨비나 시청</a></p>
                                    <?php
                                            endif;
                                        else:
                                    ?>
                                            <button type="button" class="btn-ty3 red" style="cursor:pointer;" data-toggle="modal" data-target="#signUpCancelModal" data-backdrop="static" data-keyboard="false" onClick="signUpCancel(<?= $key ?>)">
                                                취소하기
                                            </button>
                                    <?php 
                                        endif;
                                    endif;
                                    ?>
                                </div>
                            <?php } ?>
                            <div id="popup"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
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
    function signUpCancel(key) {
        var html = '';
        html += '<div class="modal fade" id="signUpCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
        html += '   <div class="modal-dialog" role="document">';
        html += '        <div class="modal-content" style="background-color:transparent; border:none;">';
        html += '            <div class="popup-wrap popup-ty2">';
        html += '                <div class="popup-head">';
        html += '                    <h1>참가자 신청 취소</h1>';
        html += '                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>';
        html += '                </div>';
        html += '                <div class="popup-body">';
        html += '                    <div class="cert-sect4">';
        html += '                        <p>참가자의 신청을 취소할 경우 참가자가 결제한 금액은<br class="br-mo">모두 환불됩니다.<br>참가자 신청을 취소하시겠습니까?</p>';
        html += '                    </div>';
        html += '                    <div class="popup-btm">';
        html += '                        <button type="button" class="btn-ty2 red" data-dismiss="modal" aria-label="Close">취소</button>';
        html += '                        <button type="button" class="btn-ty2" onClick="signUpCancleOK(' + key + ')">확인</button>';
        html += '                    </div>';
        html += '               </div>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $("#popup").html(html);
    }

    function signUpCancleOK(index) {
        var exhibition_users = <?= json_encode($exhibition_users)  ?>;
        var id = exhibition_users[index]['id'];
        var exhibition_id = exhibition_users[index]['exhibition_id'];
        var users_name = exhibition_users[index]['users_name'];
        var users_email = exhibition_users[index]['users_email'];
        var pay_id = exhibition_users[index]['pay_id'];

        $.ajax({
            url: '/exhibition-users/exhibition-users-status',
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                exhibition_id: exhibition_id,
                users_name: users_name,
                email: users_email,
                pay_id: pay_id
            }
        }).done(function(data) {
            if (data.status == 'success') {
                window.location.reload();
            } else {
                alert('실패하였습니다. 다시 시도해주세요.');
            }
        });
    }
</script>