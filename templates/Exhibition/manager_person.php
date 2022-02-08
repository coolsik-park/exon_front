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
                <?php 
                    foreach ($exhibition_users as $key => $exhibition_user):
                        if ($exhibition_user->status != 8):
                ?>
                            <div class="tr-row">
                                <div class="td-col col1">
                                    <div class="con ag-ty1">
                                        <p class="tit fir">
                                            <?php 
                                                if ($exhibition_user->users_id != null):
                                                    for ($i=0; $i<count($users)+1; $i++) {
                                                        if ($exhibition_user->users_id == $users[$i]['id']) {
                                                            echo $users[$i]['company'];
                                                            break;
                                                        }
                                                    }
                                                endif;
                                            ?>
                                        </p>
                                        <div class="u-name">
                                            <p class="name"><?= $exhibition_user->users_name ?></p>
                                            <p class="age">
                                                <?php
                                                    if ($exhibition_user->users_sex == 'M') {
                                                        echo '남자 / ';
                                                    } else if ($exhibition_user->users_sex == 'F') {
                                                        echo '여자 / ';
                                                    } else {
                                                        echo '/ ';
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
                                    <div class="con">
                                        <button type="button" class="btn-ty3 bor" style="cursor:pointer;" data-toggle="modal" data-target="#surveyCheckModal" data-backdrop="static" data-keyboard="false" onClick="surveyCheck(<?= $exhibition_user->id ?>)">
                                            설문확인
                                        </button>
                                    </div>
                                    <div id="surveyPopup"></div>
                                    <!-- <div class="modal fade" id="surveyCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content" style="background-color:transparent; border:none;">
                                                <div class="popup-wrap">
                                                    <div class="popup-head">
                                                        <h1>설문 결과</h1>
                                                        <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                                    </div>
                                                    <div class="popup-body">  
                                                        <div class="pop-poll-items-wrap">
                                                            <?php for ($y=0; $y<count($beforeParentData); $y++) { ?>
                                                                <div class="pop-poll-item">
                                                                    <p class="tit"><?= $beforeParentData[$y]->text ?></p>
                                                                    <?php if ($beforeParentData[$y]->is_multiple == 'Y') { ?>
                                                                        <ul>
                                                                            <?php for ($j=0; $j<count($beforeParentData[$y]->child_exhibition_survey); $j++) { ?>
                                                                                <li><span class="chk-dsg"><input type="radio" id="pp<?= $y+1 ?>-<?= $j+1 ?>" name="pp<?= $y+1 ?>" checked="checked"><label for="pp<?= $y+1 ?>-<?= $j+1 ?>"><?= $beforeParentData[$y]->child_exhibition_survey[$j]->text ?></label></span></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } else {  ?>
                                                                        <textarea name="" id="" cols="30" rows="3"> 
                                                                            <?php
                                                                                for ($z=0; $z<count($beforeParentData[$y]->exhibition_survey_users_answer); $z++) { 
                                                                                    if ($beforeParentData[$y]->exhibition_survey_users_answer[$z]->users_id == $exhibition_user->users_id) {
                                                                                        echo $beforeParentData[$y]->exhibition_survey_users_answer[$z]->text;
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </textarea>
                                                                    <?php } ?>
                                                                </div>
                                                            <?php } ?>
                                                        </div>        
                                                        <div class="popup-btm alone">     
                                                            <button type="button" class="btn-ty2" data-dismiss="modal" aria-label="Close">확인</button>
                                                        </div>        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                                <div class="td-col col3">
                                    <div class="con">
                                        <p>
                                            <?= $exhibition_user->exhibition_group['name'] ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="td-col col4">
                                    <div class="con">
                                        <?php
                                            if ($exhibition_user->exhibition_group['amount'] != 0) {
                                                echo number_format($exhibition_user->exhibition_group['amount']) . "원";
                                            } else {
                                                echo "무료";
                                            }
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
                                        <select id="participateSelectBox" onChange="exhibitionUsersStatus(this, '<?= $exhibition_user->id ?>', '<?= $exhibition_user->exhibition_id ?>', '<?= $exhibition_user->users_email ?>', '<?=$exhibition_user->users_name?>', '<?=$exhibition_user->exhibition_group_id?>')">
                                            <?php if ($exhibition_user->status == 4) { ?>
                                                <option id="2" value="2">참가 대기</option>
                                                <option id="4" value="4" selected>참가 확정</option>
                                            <?php } else { ?>
                                                <option id="2" value="2" selected>참가 대기</option>
                                                <option id="4" value="4">참가 확정</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="td-col col7">
                                    <div class="con">
                                        <button type="button" class="btn-ty3 red" style="cursor:pointer;" data-toggle="modal" data-target="#exhibitionCancelModal" data-backdrop="static" data-keyboard="false" onClick="exhibitionCancel(<?= $key ?>)">
                                            취소
                                        </button>
                                    </div>
                                    <div id="popup"></div>
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
    function surveyCheck(users_id) {
        var beforeParentData = <?= json_encode($beforeParentData) ?>;
        if (beforeParentData == '') {
            alert("사전설문이 없습니다.");
        } else {
            var beforeChildData = <?= json_encode($beforeChildData) ?>;
            var html = '';
            html += '<div class="modal fade" id="surveyCheckModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            html += '   <div class="modal-dialog" role="document">';
            html += '       <div class="modal-content" style="background-color:transparent; border:none;">';
            html += '           <div class="popup-wrap">';
            html += '               <div class="popup-head">';
            html += '                   <h1>설문 결과</h1>';
            html += '                   <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>';
            html += '               </div>';
            html += '               <div class="popup-body">';
            html += '                   <div class="pop-poll-items-wrap">';
            for (var i =0; i<beforeParentData.length; i++) {
                html += '                    <div class="pop-poll-item">';
                html += '                       <p class="tit">' + beforeParentData[i]['text'] +'</p>';
                if (beforeParentData[i]['is_multiple'] == 'Y') {
                    html += '                   <ul>';
                    for (var y=0; y<beforeChildData[beforeParentData[i]['id']].length; y++) {
                        for (var z=0; z<beforeChildData[beforeParentData[i]['id']][y]['exhibition_survey_users_answer'].length; z++) {
                            if (beforeChildData[beforeParentData[i]['id']][y]['exhibition_survey_users_answer'][z]['users_id'] == users_id) {
                                if (beforeChildData[beforeParentData[i]['id']][y]['exhibition_survey_users_answer'][z]['text'] == 'Y') {
                                    html += '      <li><span class="chk-dsg"><input type="radio" id="pp' + i+1 + '-' + y+1 + '" name="pp' + i+1 + '-' + y+1 + '" checked="checked" disabled="disabled"><label for="pp' + i+1 + '-' + y+1 + '">' + beforeChildData[beforeParentData[i]['id']][y]['text'] + '</label></span></li>';
                                } else {
                                    html += '      <li><span class="chk-dsg"><input type="radio" id="pp' + i+1 + '-' + y+1 + '" name="pp' + i+1 + '-' + y+1 + '" disabled="disabled"><label for="pp' + i+1 + '-' + y+1 + '">' + beforeChildData[beforeParentData[i]['id']][y]['text'] + '</label></span></li>';
                                }
                            } else {
                                html += '      <li><span class="chk-dsg"><input type="radio" id="pp' + i+1 + '-' + y+1 + '" name="pp' + i+1 + '-' + y+1 + '" disabled="disabled"><label for="pp' + i+1 + '-' + y+1 + '">' + beforeChildData[beforeParentData[i]['id']][y]['text'] + '</label></span></li>';
                                break;
                            }
                        }
                    }
                    html += '                   </ul>';
                } else {
                    html += '                   <textarea readonly name="" id="" cols="30" rows="3">';
                    for (var j=0; j<beforeParentData[i]['exhibition_survey_users_answer'].length; j++) {
                        if (beforeParentData[i]['exhibition_survey_users_answer'][j]['users_id'] == users_id) {
                            html += beforeParentData[i]['exhibition_survey_users_answer'][j]['text'];
                        }
                    }
                    html += '                   </textarea>';
                }
                html += '                   </div>';
            }
            html += '                   </div>';
            html += '                   <div class="popup-btm alone">';
            html += '                       <button type="button" class="btn-ty2" data-dismiss="modal" aria-label="Close">확인</button>';
            html += '                   </div>';
            html += '               </div>';
            html += '           </div>';
            html += '       </div>';
            html += '   </div>';
            html += '</div>';
            $("#surveyPopup").html(html);
        }
    }

    function exhibitionUsersStatus(v, id, exhibition_id, users_email, users_name, exhibition_group_id) {
        var value = v.value;
        
        $.ajax({
            url: '/exhibition/exhibition-users-approval',
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                exhibition_id: exhibition_id,
                status: value,
                email: users_email,
                name: users_name,
                group_id: exhibition_group_id
            }
        }).done(function(data) {
            if (data.test == 'success') {
                // $('#td-col col6').load(location.href+" #td-col col6");
            } else {
                alert("실패하였습니다.");
                $('#td-col col6').load(location.href+" #td-col col6");
            }
        });
    }

    function exhibitionCancel(key) {
        var html = '';
        html += '<div class="modal fade" id="exhibitionCancelModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">';
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
        html += '                        <button type="button" class="btn-ty2" onClick="exhibitionCancelOK(' + key + ')">확인</button>';
        html += '                    </div>';
        html += '               </div>';
        html += '           </div>';
        html += '       </div>';
        html += '   </div>';
        html += '</div>';
        $("#popup").html(html);
    }

    function exhibitionCancelOK(index) {
        var exhibition_users = <?= json_encode($exhibition_users) ?>;
        var id = exhibition_users[index]['id'];
        var exhibition_id = exhibition_users[index]['exhibition_id'];
        var users_name = exhibition_users[index]['users_name'];
        var users_email = exhibition_users[index]['users_email'];
        var pay_id = exhibition_users[index]['pay_id'];
        
        $.ajax({
            url: '/exhibition/exhibition-users-status',
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                exhibition_id: exhibition_id,
                users_name: users_name,
                users_email: users_email,
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
