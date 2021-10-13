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
        <div class="pr3-section1">
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
                                <a class="btn-ty3 bor" id="surveyCheck" style="cursor:pointer;">설문확인</a>
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
                                        echo $exhibition_user->id . '불참';
                                    } elseif ($exhibition_user->attend == 2) {
                                        echo $exhibition_user->id . '참석';
                                    } elseif ($exhibition_user->attend == 4) {
                                        echo $exhibition_user->id . '시청완료';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="td-col col6" id="td-col col6">
                            <div class="con">
                                <select id="participateSelectBox" name="<?= $exhibition_user->id ?>,<?= $exhibition_user->users_email ?>">
                                    <?php
                                        if ($exhibition_user->status == 4) {
                                    ?>
                                            <option value="2">참가 대기</option>
                                            <option value="4" selected="selected">참가 확정</option>
                                    <?php
                                        } else {
                                    ?>
                                            <option value="2" selected="selected">참가 대기</option>
                                            <option value="4">참가 확정</option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="td-col col7">
                            <div class="con">                                
                                <p><a class="btn-ty3 red" id="exhibitionCancle" name="<?= $exhibition_user->id ?>" style="cursor:pointer;">취소</a></p>
                            </div>
                        </div>                        
                    </div>
                <?php endforeach; ?>
            </div>
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
<footer id="footer"></footer>

<script>
    $('#surveyCheck').on('click', function() {
        window.open('/exhibition/userSurveyView/<?= $exhibition_user->id ?>', '설문 결과', 'width=400px,height=600px,left=800px,top=300px');
    });

    $('#participateSelectBox').on('change', function() {
        var id = $(this).attr('name').split(',')[0];
        var value = $(this).val();
        var email = $(this).attr('name').split(',')[1];

        $.ajax({
            url: '/exhibition/exhibition-users-approval/' + id,
            method: 'POST',
            type: 'json',
            data: {
                status: value,
                email: email,
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

    $('#exhibitionCancle').on('click', function() {
        window.open('/exhibition/exhibitionCancle', '참가자 신청 취소', 'width=400px,height=600px,left=800px,top=300px');

        // var id = $(this).attr('name');
        // var email = '<?= $exhibition_user->users_email ?>';
        // var pay_id = '<?= $exhibition_user->pay_id ?>';

        // if (confirm("정말 취소하시겠습니까?") == true) {
        //     console.log(id);
        //     $.ajax({
        //         url: '/exhibition/exhibition-users-status/' + id,
        //         method: 'POST',
        //         type: 'json',
        //         data: {
        //             email: email,
        //             pay_id: pay_id,
        //         }
        //     }).done(function(data) {
        //         if (data.status == 'success') {
        //             $('#container').load(location.href+" #container");
        //             alert("취소 메일 보내드렸습니다. 확인부탁드립니다.");
        //         } else {
        //             alert("실패하였습니다.");
        //         }
        //     });
        // }
    });
</script>
