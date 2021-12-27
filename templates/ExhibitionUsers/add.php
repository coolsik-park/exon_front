<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser $exhibitionUser
 */
?>
<style>
    .chk-dsg input + label:before {
        left: 8px;
    } 
    .survey-b input {
    position: absolute;
    margin: 19px 5px 0px 13px;
    }
    .survey-b input + label {
    display: block;
    padding: 12px 20px 12px 35px;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5;
    }
    #groupTx{
        cursor: default;
    }
    @media  screen and (min-width: 768px) {
    .section7 .group-join .ipt-form .tx {
            padding-right: 2.5rem;
        }
    }
    @media  screen and (max-width: 768px) {
    .chk-dsg input + label:before {
        top: 14px;
    }
    .chk-dsg input + label {
        padding-top: 3vW;
    }
    .agree-wp .btn-ss {
        margin-top: 10px;
    }
    }
</style>

<div id="container"> 
    <?= $this->Form->create($exhibitionUser, ['id' => 'apply', 'enctype' => 'multipart/form-data']) ?>
    <div class="contents static">
        <h2 class="s-hty0">웨비나 신청하기</h2>
        <div class="section5">
            <h3 class="s-hty1">신청자 정보</h3>
            <div class="mbr-form">
                <div class="item-row">
                <div class="col-dt"><em class="st">*</em>이메일</div>
                <div class="col-dd">
                        <input type="text" id="users_email" name="users_email" class="ipt">          
                </div>
                </div>
                <div class="item-row">
                    <div class="col-dt"><em class="st">*</em>이름</div>
                    <div class="col-dd">
                        <input type="text" id="users_name" name="users_name" class="ipt">          
                    </div>
                </div>
                <div class="item-row">
                    <div id="require_tel" class="col-dt">전화번호</div>
                    <div class="col-dd">
                        <div class="col-cell-wp">
                            <!-- <select id="cellNumber">
                                <option value="010">010</option>
                            </select> -->
                            <input type="text" id="users_hp" name="users_hp" placeholder="'-' 없이 입력해 주세요">
                        </div>
                    </div>
                </div>
                <!-- <div class="item-row">
                    <div class="col-dt">나이</div>
                    <div class="col-dd">
                        <input type="text" id="users_email" name="users_email" class="ipt age">             
                    </div>
                </div> -->
                <div class="item-row">
                    <div id="require_sex" class="col-dt">성별</div>
                    <div class="col-dd">
                        <select class="gender" id="users_sex" name="users_sex">
                            <option value="">성별</option>
                            <option value="M">남성</option>
                            <option value="F">여성</option>
                        </select>              
                    </div>
                </div>
                <div class="item-row">
                    <div id="require_group" class="col-dt">소속/직함</div>
                    <div class="col-dd">
                        <div class="belong">
                            <input type="text" id="company" name="company" title="소속">
                            <input type="text" id="title" name="title" title="직함">
                        </div>     
                        <p class="p-noti">웨비나 접속 시 인증에 필요할 수 있습니다. 정확히 입력해 주세요.</p>              
                    </div>
                </div>
            </div>
        </div>
        <div class="section6">
            <h3 class="s-hty1">이용약관 / 개인정보 수집 및 이용 동의</h3>
            <div class="agree-wp">                    
                <div>
                    <span class="chk-dsg"><input type="checkbox" id="agree2"><label for="agree2">(필수) 이용약관</label></span><a href="/pages/terms-of-service" target="_blank" class="btn-ss">약관보기</a>
                </div>
                <div>
                    <span class="chk-dsg"><input type="checkbox" id="agree3"><label for="agree3">(필수) 개인정보 수집 및 이용 동의</label></span><a href="/pages/personal-info-agreement" target="_blank" class="btn-ss">약관보기</a>
                </div>   
            </div>
        </div>
        <div class="section7 fixed">
            <h3 class="s-hty1">선택 그룹</h3>
            <div class="group-join">
                <div class="ipt-form">
                    <?php if ($exhibitionGroup == '') : ?>
                        <input type="text" id="groupTx" value="그룹 미선택" readonly>
                        <input type="hidden" id="groupTx" value="" name="exhibition_group_id" id="exhibition_group_id">
                    <?php else : ?>
                        <?php foreach ($exhibitionGroup as $group) : ?>
                            <input type="text" id="groupTx" value="<?= $group->name ?>" readonly>
                            <input type="hidden" id="groupTx" value="<?= $group->id ?>" name="exhibition_group_id" id="exhibition_group_id">
                        <?php endforeach; ?>
                    <?php endif; ?>  
                    </select>                      
                    <span id="amount" class="tx">
                        <?php
                            if ($exhibition->cost == 'charged'): 
                                if ($amount == 0) {
                                    echo "무료";
                                } else {
                                    echo $amount;
                                }
                            else :
                                echo '무료';
                            endif;
                        ?>
                    </span>
                </div>
                <button type="button" id="submit" class="btn-join">참가 신청</button>
            </div>
        </div>
        <div class="select8">
            <?php
            $m = 0;
            $s = 0;
            $subjective_parents = [];
            $multiple_parents = [];
            ?>
            <h3 class="s-hty1">사전 설문 데이터</h3>
            <?php if (!empty($exhibitionSurveys->toArray())) : ?>
                <?php $i = 0; ?>
                <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>  
                    <?php if ($exhibitionSurvey->is_multiple == 'N') : ?>
                        <?php
                        if ($exhibitionSurvey->is_required == 'Y') : 
                        $subjective_parents[$s] = $exhibitionSurvey->id;
                        $s++;
                        endif; 
                        ?>   
                        <div class="survey"> 
                            <h4 class="survey-q"><?= $exhibitionSurvey->text ?></h4>
                            <ul class="survey-as">
                                <li><input type="text" id="<?=$exhibitionSurvey->id?>" name="exhibition_survey_users_answer.<?=$i?>.text"></li>
                                <?php $i++; ?>
                            </ul>
                        </div>
                    <?php else : ?>
                        <?php
                        if ($exhibitionSurvey->is_required == 'Y') : 
                        $multiple_parents[$m] = $exhibitionSurvey->id;
                        $m++;
                        endif; 
                        ?>
                        <div class="survey"> 
                            <h4 class="survey-q"><?= $exhibitionSurvey->text ?></h4>
                            <input type="hidden" name="exhibition_survey_users_answer.<?=$i?>.text" value="question">
                            <?php $i++; ?>
                            <ul class="survey-as">
                            <?php if ($exhibitionSurvey->is_duplicate == 'N') : ?>
                                <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
                                    <li><span class="survey-b chk-dsg" style="display: block;"><input type="radio" id="<?=$child->id?>" name="<?=$child->parent_id?>" value="<?=$child->text?>"><label for="<?=$child->id?>"><?=$child->text?></label></span></li>
                                    <input type="hidden" id="<?=$child->id?>" name="exhibition_survey_users_answer.<?=$i?>.text" class="<?=$child->parent_id?>" value="">
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
                                    <li><span class="survey-b chk-dsg" style="display: block;"><input type="checkbox" id="<?=$child->id?>" name="<?=$child->parent_id?>" value="<?=$child->text?>"><label for="<?=$child->id?>"><?=$child->text?></label></span></li>
                                    <input type="hidden" id="<?=$child->id?>" name="exhibition_survey_users_answer.<?=$i?>.text" class="<?=$child->parent_id?>" value="">
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <br><br>
                <?php endforeach; ?>
            <?php else: ?>
            <p>등록된 사전 설문이 없습니다.</p>
            <?php endif; ?>
        </div>
    </div>        
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    //유저 정보 불러오기
    <?php if (!empty($user)) : ?>
    $("#users_email").val("<?=$user->email?>");
    $("#users_name").val("<?=$user->name?>");
    $("#users_hp").val("<?=$user->hp?>");      
    $("#users_sex").val("<?=$user->sex?>").prop("selected", true);
    $("#company").val("<?=$user->company?>");
    $("#title").val("<?=$user->title?>");
    <?php endif; ?>

    //필수 정보 불러오기
    var require_tel = "<?=$exhibition->require_tel?>";
    var require_sex = "<?=$exhibition->require_sex?>";
    var require_group = "<?=$exhibition->require_group?>";
    var star = '<em class="st">*</em>';
    if (require_tel == 1) {
        $("#require_tel").append(star);
    }
    if (require_sex == 1) {
        $("#require_sex").append(star);
    }
    if (require_group == 1) {
        $("#require_group").append(star);
    }

    $(":input:radio").change(function () {
        var id = $(this).attr("id");
        var name = $(this).attr("name")
        $(":input:hidden[class=" + name + "]").val('');
        $(":input:hidden[id=" + id + "]").val("Y"); 
    });

    $(":input:checkbox").change(function () {
        var id = $(this).attr("id");
        if ($(":input:hidden[id=" + id + "]").val() == 'Y' ) {
            $(":input:hidden[id=" + id + "]").val(""); 
        } else {
            $(":input:hidden[id=" + id + "]").val("Y"); 
        }
    });

    $("#submit").click(function () {
        //Validation
        if ($("#users_email").val().length == 0) {
            alert("이메일을 입력해주세요.");
            $("#users_email").focus();
            return false;
        }
        
        var getMail = RegExp(/^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/);
        if (!getMail.test($("#users_email").val())) {
            alert("이메일 형식을 확인해주세요.");
            $("#users_email").focus();
            return false;
        }
        
        if ($("#users_name").val().length == 0) {
            alert("이름을 입력해주세요.");
            $("#users_name").focus();
            return false;
        }

        // var getName = RegExp(/^[가-힣]+$/);
        // if (!getName.test($("#users_name").val())) {
        //     alert("이름을 올바르게 입력해 주세요.");
        //     $("#users_name").focus();
        //     return false;
        // }

        if (require_tel == 1) {
            if ($("#users_hp").val().length == 0) {
                alert("전화번호를 입력해주세요.");
                $("#users_hp").focus();
                return false;
            }
        }

        if (require_sex == 1) {
            if ($("#users_sex").val() == '') {
                alert("성별을 입력해주세요.");
                $("#users_sex").focus();
                return false;
            }
        }

        if (require_group == 1) {
            if ($("#company").val() == '') {
                alert("소속을 입력해주세요.");
                $("#company").focus();
                return false
            }
            if ($("#title").val() == '') {
                alert("직함을 입력해주세요.");
                $("#title").focus();
                return false
            }
        }

        if ($("#agree2").prop("checked") == false || $("#agree3").prop("checked") == false) {
            alert("필수 이용약관 및 개인정보 수집/이용 동의를 확인해주세요.");
            return false;
        }
        
        var subjective_parents = [];
        var multiple_parents = [];    
        var s = 0;
        var m = 0;
        <?php if ($subjective_parents != '') : ?> 
        <?php foreach ($subjective_parents as $subjective_parent) : ?>
            subjective_parents[s] = "<?=$subjective_parent?>"
            s++;
        <?php endforeach; ?>
        <?php endif ?>
        <?php if ($multiple_parents != '') : ?>
        <?php foreach ($multiple_parents as $multiple_parent) : ?>
            multiple_parents[m] = "<?=$multiple_parent?>"
            m++;
        <?php endforeach; ?>
        <?php endif; ?>

        for (var i=0; i<subjective_parents.length; i++) {
            if ($("#"+subjective_parents[i]).val() == '') {
                alert("응답되지 않은 필수 사전설문이 있습니다.");
                return false;
                $("#"+subjective_parents[i]).focus();
            }
        }

        for (var i=0; i<multiple_parents.length; i++) {
            if ($("input[name='"+multiple_parents[i]+"']:checked").length == 0) {
                alert("응답되지 않은 필수 사전설문이 있습니다.");
                return false;
                $("input[name='"+multiple_parents[i]+"']").focus();
            }
        }
        var html = "";
        html += "이메일 : " + $("#users_email").val() + "\n";
        html += "이름 : " + $("#users_name").val() + "\n";
        html += "전화번호 : " + $("#users_hp").val() + "\n";
        html += "웨비나 접속 시 인증이 필요할 수 있습니다.\n위 내용으로 신청하시겠습니까?";
        if (confirm(html)) {
            var amount = "<?=$amount?>";     
            var cost = "<?=$exhibition->cost?>";
            //무료
            if (cost == 'free' || amount == 0) {
                var formData = new FormData($('#apply')[0]);
                formData.append('pay_id', 0);
                formData.append('pay_amount', 0);

                jQuery.ajax({
                    url: "/exhibition-users/add/" + <?= $id ?>,
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: formData,
                    type: 'POST',
                }).done(function(data) {
                    if (data.status == 'success') {
                        alert("신청이 완료되었습니다.");
                        window.location.replace("/exhibition/view/<?=$id?>");
                    } else if (data.status == 'exist') {
                        alert("해당 이메일 주소로 이미 신청이 완료된 행사입니다.");
                        window.location.replace("/exhibition/view/<?=$id?>");
                    } else {
                        alert("오류가 발생했습니다. 잠시 후 다시 시도해주세요.");
                    }
                });

            } else {
                //결제         
                var IMP = window.IMP; 
                IMP.init('imp43823679'); //아임포트 id -> 추후 교체
                IMP.request_pay({
                    pg : 'inicis',
                    pay_method : 'card',
                    merchant_uid : 'merchant_' + new Date().getTime(),
                    name : '웨비나 신청',
                    amount : amount
                    //세션 유저정보에서 가져오기
                    // buyer_email : '',
                    // buyer_name : '구매자이름',
                    // buyer_tel : '010-1234-5678',
                    // buyer_addr : '서울특별시 강남구 삼성동',
                    // buyer_postcode : '123-456'
                }, function(rsp) {
                    if ( rsp.success ) {
                        jQuery.ajax({
                            url: "/pay/import-pay", 
                            method: 'POST',
                            type: 'json',
                            data: {
                                imp_uid: rsp.imp_uid,
                                merchant_uid: rsp.merchant_uid,
                                pay_method: rsp.pay_method,
                                paid_amount: rsp.paid_amount,
                                coupon_amount: 0,
                                receipt_url: rsp.receipt_url,
                                paid_at: rsp.paid_at,
                                pg_tid: rsp.pg_tid
                            }
                        }).done(function(data) {
                            if (data.status == 'success') { 
                                var msg = '결제가 완료되었습니다.';
                                msg += '\n고유ID : ' + rsp.imp_uid;
                                msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                                msg += '\n결제 금액 : ' + rsp.paid_amount;
                                msg += '\n카드 승인번호 : ' + rsp.apply_num; 

                                alert(msg);

                                var formData = new FormData($('#apply')[0]);
                                formData.append('pay_id', data.pay_id);
                                formData.append('pay_amount', rsp.paid_amount);

                                jQuery.ajax({
                                    url: "/exhibition-users/add/" + <?= $id ?>,
                                    processData: false,
                                    contentType: false,
                                    cache: false,
                                    data: formData,
                                    type: 'POST',
                                }).done(function(data) {
                                    if (data.status == 'success') {
                                        alert("신청이 완료되었습니다.");
                                        window.location.replace("/exhibition/view/<?=$id?>");
                                    }
                                });
                            } 
                        });
                        
                    } else {
                        var msg = '결제에 실패하였습니다.';
                        msg += '에러내용 : ' + rsp.error_msg;

                        alert(msg);
                    }
                });
            }
        }
    });
</script>