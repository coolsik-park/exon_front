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
    <div class="sub-menu">
        <div class="sub-menu-inner">
            <ul class="tab">
                <li><a href="/exhibition/edit/<?= $id ?>">행사 설정 수정</a></li>
                <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                <li class="active"><a href="">참가자 관리</a></li>
                <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
                <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
            </ul>
        </div>
    </div>        
    <div class="contents static">
        <h2 class="sr-only">참가자 관리</h2>
        <div class="pr3-title">                            
            <ul class="s-tabs2">
                <li class="active"><a href="07_cs1.html">참가자</a></li>
                <li><a href="/exhibition/send-sms-to-participant/<?=$id?>">문자</a></li>
                <li><a href="/exhibition/send-email-to-participant/<?=$id?>">이메일</a></li>
            </ul>
            <h3 class="s-hty1">참가자</h3>    
        </div>
        <div class="pr3-section1" id="pr3-section1">
            <div class="table-type table-type3">
                <div class="th-row">
                    <div class="th-col col1">인적사항</div>
                    <div class="th-col col2">설문 확인</div>
                    <div class="th-col col3">신청 그룹</div>
                    <div class="th-col col4">결제 내역</div>
                    <div class="th-col col5">출석 여부</div>
                    <div class="th-col col6">승인 상태</div>
                    <div class="th-col col7"></div>
                </div>
                <?php foreach ($exhibition_users as $exhibition_user): ?>
                    <div class="tr-row">
                        <div class="td-col col1">
                            <div class="con ag-ty1">
                                <p class="tit fir">라이브몰로</p>
                                <div class="u-name">
                                    <p class="name"><?= $exhibition_user->users_name ?></p>
                                    <p class="age">
                                        <?php
                                            if ($exhibition_user->users_sex == 'M') {
                                                echo '남자 / ';
                                            } else {
                                                echo '여자 / ';
                                            } 
                                        ?>
                                        <?php
                                            echo '나이';
                                        ?>
                                    </p>
                                </div>
                                <p><?= $exhibition_user->users_email ?></p>
                                <p><?= substr($exhibition_user->users_hp, 0, 3) ?>-<?= substr($exhibition_user->users_hp, 3, 4) ?>-<?= substr($exhibition_user->users_hp, 7, 4) ?></p>
                            </div>                            
                        </div>
                        <div class="td-col col2">
                            <div class="con">
                                <button type="button" class="btn-ty3 bor" style="cursor:pointer;" data-toggle="modal" data-target="#surveyCheckModal" data-backdrop="static" data-keyboard="false">
                                    설문확인
                                </button>
                            </div>
                            <div class="modal fade" id="surveyCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="popup-wrap">
                                            <div class="popup-head">
                                                <h1>설문 결과</h1>
                                                <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                            </div>
                                            <div class="popup-body">  
                                                <div class="pop-poll-items-wrap">
                                                    <div class="pop-poll-item">
                                                        <p class="tit">어느 계절이 가장 좋나요?</p>
                                                        <ul>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp1-1" name="pp1"><label for="pp1-1">봄</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp1-2" name="pp1"><label for="pp1-2">여름</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp1-3" name="pp1"><label for="pp1-3">가을</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp1-4" name="pp1"><label for="pp1-4">겨울</label></span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="pop-poll-item">
                                                        <p class="tit">핸드폰을 가지고 있나요?</p>
                                                        <ul>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp2-1" name="pp2"><label for="pp2-1">봄</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp2-2" name="pp2"><label for="pp2-2">여름</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp2-3" name="pp2"><label for="pp2-3">가을</label></span></li>
                                                            <li><span class="chk-dsg"><input type="radio" id="pp2-4" name="pp2"><label for="pp2-4">겨울</label></span></li>
                                                        </ul>
                                                    </div>
                                                    <div class="pop-poll-item">
                                                        <p class="tit">행사 내용이 마음에 드시나요</p>
                                                        <textarea name="" id="" cols="30" rows="3"></textarea>
                                                    </div>
                                                </div>        
                                                <div class="popup-btm alone">     
                                                    <button type="button" class="btn-ty2">확인</button>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="td-col col3">
                            <div class="con">
                                <p><?= $exhibition_user->exhibition_group['name'] ?></p>  
                            </div>
                        </div>
                        <div class="td-col col4">
                            <div class="con">
                                <?php 
                                    $amount = intval($exhibition_user->exhibition_group['amount']);
                                    echo number_format($amount) . "원"; 
                                ?>
                            </div>
                        </div>
                        <div class="td-col col5">
                            <div class="con">
                                <?php
                                    if ($exhibition_user->attend == 1) {
                                        echo '불참';
                                    } elseif ($exhibition_user->attend == 2) {
                                        echo '참석';
                                    } elseif ($exhibition_user->attend == 4) {
                                        echo '시청완료';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col6" id="td-col col6">
                            <div class="con">
                                <select id="participateSelectBox" name="<?= $exhibition_user->id ?>,<?= $exhibition_user->users_email ?>">
                                    <?php if ($exhibition_user->status == 4) { ?>
                                        <option value="2">참가 대기</option>
                                        <option value="4" selected="selected">참가 확정</option>
                                    <?php } else { ?>
                                        <option value="2" selected="selected">참가 대기</option>
                                        <option value="4">참가 확정</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="td-col col7">
                            <div class="con">
                                <button type="button" class="btn-ty3 red" id="exhibitionCancel" name="<?= $exhibition_user->users_name ?>" style="cursor:pointer;" data-toggle="modal" data-target="#exhibitionCancelModal" data-backdrop="static" data-keyboard="false">
                                    취소
                                </button>
                            </div>
                            <div class="modal fade" id="exhibitionCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="popup-wrap popup-ty2">
                                            <div class="popup-head">
                                                <h1>참가자 신청 취소</h1>
                                                <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                            </div>
                                            <div class="popup-body">        
                                                <div class="cert-sect4">
                                                    <p>참가자의 신청을 취소할 경우 참가자가 결제한 금액은<br class="br-mo">
                                                        모두 환불됩니다.<br>
                                                        참가자 신청을 취소하시겠습니까?</p>
                                                </div>
                                                <div class="popup-btm">
                                                    <button type="button" class="btn-ty2 red" data-dismiss="modal" aria-label="Close">취소</button>
                                                    <button type="button" class="btn-ty2" id="exhibitionCancelOk">확인</button>
                                                </div>        
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
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
    $('#participateSelectBox').on('change', function() {
        var id = $(this).attr('name').split(',')[0];
        var value = $(this).val();
        var email = $(this).attr('name').split(',')[1];
        var user_name = "<?=$exhibition_user->users_name?>";
        var group = "<?=$exhibition_user->exhibition_group_id?>";

        $.ajax({
            url: '/exhibition/exhibition-users-approval/' + id,
            method: 'POST',
            type: 'json',
            data: {
                status: value,
                email: email,
                user_name: user_name,
                group: group
            }
        }).done(function(data) {
            if (data.test == 'success') {
                $('#td-col col6').load(location.href+" #td-col col6");
            } else {
                alert("실패하였습니다.");
                $('#td-col col6').load(location.href+" #td-col col6");
            }
        });
    });

    $('#exhibitionCancelOk').on('click', function() {
        console.log($('#exhibitionCancel').attr('name'));
        // var id = $('#exhibitionCance').attr('name');
        // var email = '<?= $exhibition_user->users_email ?>';
        // var pay_id = '<?= $exhibition_user->pay_id ?>';
        // var user_name = '<?= $exhibition_user->users_name?>';

        // $.ajax({
        //     url: '/exhibition/exhibition-users-status/' + id,
        //     method: 'POST',
        //     type: 'json',
        //     data: {
        //         email: email,
        //         pay_id: pay_id,
        //         user_name: user_name
        //     }
        // }).done(function(data) {
        //     if (data.status == 'success') {
        //         $('#container').load(location.href+" #container");
        //         alert("취소 메일 보내드렸습니다. 확인부탁드립니다.");
        //     } else {
        //         alert("실패하였습니다.");
        //     }
        // });
    });
</script>
