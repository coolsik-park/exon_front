<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser $exhibitionUser
 */
?>
<!-- <div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create($exhibitionUser, ['id' => 'apply', 'enctype' => 'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('Add Exhibition User') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_group_id', ['options' => $exhibitionGroup]);
                    echo $this->Form->control('users_email');
                    echo $this->Form->control('users_name');
                    echo $this->Form->control('users_hp');
                    echo $this->Form->control('users_group');
                    echo $this->Form->control('users_sex');
                ?>
                 <div class="related">
                <h4><?= __('Exhibition Survey') ?></h4>
                <?php if (!empty($exhibitionSurveys)) : ?>
                <div class="table-responsive">
                    <table>
                        <?php $i = 0; ?>
                        <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
                        <tr>
                            <td><?= h($exhibitionSurvey->text) ?></td>
                            <td>
                                <?php
                                    if ($exhibitionSurvey->is_multiple == 'N' || $exhibitionSurvey->parent_id != null) {
                                        echo $this->Form->control('exhibition_survey_users_answer.' . $i . '.text');
                                        $i++; 
                                    } else {
                                        echo $this->Form->control('exhibition_survey_users_answer.' . $i . '.text', ['type' => 'hidden', 'value' => 'question']);
                                        $i++;
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            </fieldset>
            
            <?= $this->Form->end() ?>
            <?= $this->Form->button('Submit', ['id' => 'submit']) ?>
        </div>
    </div>
</div> -->

<div id="container"> 
    <?= $this->Form->create($exhibitionUser, ['id' => 'apply', 'enctype' => 'multipart/form-data']) ?>
    <div class="contents static">
        <h2 class="s-hty0">웨비나 신청하기</h2>
        <div class="section5">
            <h3 class="s-hty1">신청자 정보</h3>
            <div class="mbr-form">
                <div class="item-row">
                <div class="col-dt">이메일</div>
                <div class="col-dd">
                        <input type="text" id="users_email" name="users_email" class="ipt">          
                </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">이름</div>
                    <div class="col-dd">
                        <input type="text" id="users_name" name="users_name" class="ipt">          
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">전화번호</div>
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
                    <div class="col-dt">성별</div>
                    <div class="col-dd">
                        <select class="gender" id="users_sex" name="users_sex">
                            <option value="M">남성</option>
                            <option value="F">여성</option>
                        </select>              
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">소속/직함</div>
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
                    <span class="chk-dsg"><input type="checkbox" id="agree2"><label for="agree2">(필수) 이용약관</label></span><a href="#" class="btn-ss">약관동의</a>
                </div>
                <div>
                    <span class="chk-dsg"><input type="checkbox" id="agree3"><label for="agree3">(필수) 개인정보 수집 및 이용 동의</label></span><a href="#" class="btn-ss">약관보기</a>
                </div>   
            </div>
        </div>
        <div class="section7 fixed">
            <h3 class="s-hty1">선택 그룹</h3>
            <div class="group-join">
                <div class="ipt-form">
                    <select name="exhibition_group_id" id="exhibition_group_id">
                    <?php
                        foreach ($exhibitionGroup as $group) {
                    ?>
                        <option value="<?= $group->id ?>"><?= $group->name ?></option>
                    <?php
                        }
                    ?>  
                    </select>                      
                    <span class="tx">1,000</span>
                </div>
                <button type="button" id="submit" class="btn-join">참가 신청</button>
            </div>
        </div>
        <div class="select8">
            <h3 class="s-hty1">사전 설문 데이터</h3>
            <?php
                if (!empty($exhibitionSurveys)) {
                    $i = 0;
                    $j = 0;
                    foreach ($exhibitionSurveys as $exhibitionSurvey) {
                        if ($exhibitionSurvey->parent_id == null) {
            ?>
                            <div class="survey">                
                                <h4 class="survey-q"><?= $exhibitionSurvey->text ?></h4>
                                <ul class="survey-as">
                                    <?php
                                        if ($exhibitionSurvey->is_multiple == 'Y') {
                                            foreach ($exhibitionSurvey->child_exhibition_survey as $child) { 
                                    ?>
                                    <li><span class="survey-a"><input type="radio" name="exhibition_survey_users_answer<?= $j ?>" id="exhibition_survey_users_answer.<?= $i ?>.text" value="<?= $child->text ?>"><label for="exhibition_survey_users_answer.<?= $i ?>.text"><?= $child->text ?></label></span></li>
                                    <?php
                                            $i++;
                                            }
                                        } else {
                                    ?>
                                    <li><input type="text" name="exhibition_survey_users_answer<?= $j ?>" id="exhibition_survey_users_answer.<?= $i ?>.text"></li>
                                    <?php
                                        $i++;
                                        }
                                    ?>
                                </ul>
                            </div>
                            <br><br>
            <?php
                        }
                        $j++;
                    }
                }
            ?>
        </div>
    </div>        
    <?= $this->Form->end() ?>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    $("#submit").click(function () {
        // var IMP = window.IMP; 
        // IMP.init('imp43823679'); //아임포트 id -> 추후 교체
        // IMP.request_pay({
        //     pg : 'inicis',
        //     pay_method : 'card',
        //     merchant_uid : 'merchant_' + new Date().getTime(),
        //     name : '주문명:결제테스트',
        //     amount : 1000, //$('input#amount').val()
        //     //세션 유저정보에서 가져오기
        //     buyer_email : '',
        //     buyer_name : '구매자이름',
        //     buyer_tel : '010-1234-5678',
        //     buyer_addr : '서울특별시 강남구 삼성동',
        //     buyer_postcode : '123-456'
        // }, function(rsp) {
        //     if ( rsp.success ) {
        //         jQuery.ajax({
        //             url: "/pay/import-pay", 
        //             method: 'POST',
        //             type: 'json',
        //             data: {
        //                 imp_uid: rsp.imp_uid,
        //                 merchant_uid: rsp.merchant_uid,
        //                 pay_method: rsp.pay_method,
        //                 paid_amount: rsp.paid_amount,
        //                 coupon_amount: 0,
        //                 receipt_url: rsp.receipt_url,
        //                 paid_at: rsp.paid_at,
        //                 pg_tid: rsp.pg_tid
        //             }
        //         }).done(function(data) {
        //             if (data.status == 'success') { 
        //                 var msg = '결제가 완료되었습니다.';
        //                 msg += '\n고유ID : ' + rsp.imp_uid;
        //                 msg += '\n상점 거래ID : ' + rsp.merchant_uid;
        //                 msg += '\n결제 금액 : ' + rsp.paid_amount;
        //                 msg += '\n카드 승인번호 : ' + rsp.apply_num; 

        //                 alert(msg);

                        // var formData = new FormData($('#apply')[0]);
                        var formData = $('#apply').serialize();
                        console.log(formData);
                        // formData.append('pay_id', data.pay_id);
                        // formData.append('pay_amount', rsp.paid_amount);

                        // jQuery.ajax({
                        //     url: "/exhibition-users/add/" + <?= $id ?>,
                        //     processData: false,
                        //     contentType: false,
                        //     cache: false,
                        //     data: formData,
                        //     type: 'POST',
                        // });
        //             } 
        //         });
                
        //     } else {
        //         var msg = '결제에 실패하였습니다.';
        //         msg += '에러내용 : ' + rsp.error_msg;

        //         alert(msg);
        //     }
        // });
    });
</script>