<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 * 
 */
?>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<!-- <div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibition, ['id' => 'createForm', 'enctype' => 'multipart/form-data'])?>
            <fieldset>
                <legend><?= __('Add Exhibition') ?></legend>
                <?php
                    echo $this->Form->control('image', ['type' => 'file']);
                    echo $this->Form->control('users_id');
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category');
                    echo $this->Form->control('type');
                    echo $this->Form->control('detail_html');
                    echo $this->Form->control('apply_sdate', ['empty' => true]);
                    echo $this->Form->control('apply_edate', ['empty' => true]);
                    echo $this->Form->control('sdate', ['empty' => true]);
                    echo $this->Form->control('edate', ['empty' => true]);
                    echo $this->Form->control('private');
                    echo $this->Form->control('auto_approval');
                    echo $this->Form->control('name');
                    echo $this->Form->control('tel');
                    echo $this->Form->control('email');
                    echo $this->Form->control('require_name');
                    echo $this->Form->control('require_email');
                    echo $this->Form->control('require_tel');
                    echo $this->Form->control('require_age');
                    echo $this->Form->control('require_group');
                    echo $this->Form->control('require_sex');
                    echo $this->Form->control('require_cert');
                    echo $this->Form->control('email_notice');
                    echo $this->Form->control('additional');
                    echo $this->Form->control('status');
                    ?>
                    <br>
                    <legend><?= __('ExhibitionGroup 1') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_group.0.name');
                    echo $this->Form->control('exhibition_group.0.people');
                    echo $this->Form->control('exhibition_group.0.amount');
                    ?>
                    <br>
                    <legend><?= __('ExhibitionGroup 2') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_group.1.name');
                    echo $this->Form->control('exhibition_group.1.people');
                    echo $this->Form->control('exhibition_group.1.amount');
                    ?>
                    <br>
                    
                    <fieldset>
                        <?php 
                            echo $this->Form->select('exhibition_survey.0.is_multiple', [['value' => 'Y', 'text' => '객관식'], ['value' => 'N', 'text' => '주관식']], ['default' => 'Y', 'id' => 'multiple', 'name' => 'multiple']);
                            echo $this->Form->select('exhibition_survey.0.survey_type', [['value' => 'Y', 'text' => '사전설문'], ['value' => 'N', 'text' => '일반설문']], ['default' => 'N', 'id' => 'surveyType', 'name' => 'surveyType']);
                            echo $this->Form->radio('exhibition_survey.0.is_duplicate', [['value' => 'Y', 'text' => '보기 중복 선택 가능']], ['id' => 'duplicate', 'name' => 'duplicate']);
                            // echo $this->Form->radio('exhibition_survey.0.is_duplicate', [['value' => '', 'text' => '필수']]);  //필수 라디오 버튼
                            echo $this->Form->control('exhibition_survey.0.text', ['value' => '질문', 'label' => false]);
                            // echo $this->Form->control('exhibition_survey.'.$a.'.text', ['value' => '보기', 'label' => false]);
                            echo $this->Form->control('exhibition_survey.1.text', ['value' => '보기', 'label' => false]);
                            echo $this->Form->button('보기 추가', ['id' => 'textAdd', 'name' => 'textAdd']);
                            echo $this->Form->button('보기 삭제', ['id' => 'textDelete', 'name' => 'textDelete']);
                        ?>
                    </fieldset>

            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div> -->

<?= $this->Form->create($exhibition, ['id' => 'createForm', 'enctype' => 'multipart/form-data'])?>
    <div id="container">    
        <div class="contents static">
            <h2 class="sr-only">행사 개설</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">기본설정</h3>
                    <div class="btn-wp">
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">개설</button>
                        <button type="button" name="temp" class="btn-ty4">임시저장</button>
                    </div>
                </div>
                
                <div class="sect1">
                    <div class="sect1-col1">
                        <div class="photo"><label for="image"><img id="mainImg" src="../images/img-no3.png" alt="이미지없음" style="width:380px; height:214px"></div> 
                        <input type="file" id="image" name="image" style="display:none">
                    </div>
                    <div class="sect1-col2">
                        <div class="row2 fir">
                            <div class="col-th">행사이름</div>
                            <div class="col-td"><input type="text" id="title" name="title" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">간단한 행사 소개</div>
                            <div class="col-td"><input type="text" id="description" name="description" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">행사 분야 및 유형</div>
                            <div class="col-td sel-bx">
                                <?php echo $this->Form->control('category', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                                <?php echo $this->Form->control('type', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2">모집 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <?php echo $this->Form->control('apply_sdate', ['label' => '시작 일시', 'placeholder' => '시작날짜', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>
                        <div class="date-sett">
                            <?php echo $this->Form->control('apply_edate', ['label' => '종료 일시', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>               
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2">행사 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <?php echo $this->Form->control('sdate', ['label' => '시작 일시', 'placeholder' => '시작날짜', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>
                        <div class="date-sett">
                            <?php echo $this->Form->control('edate', ['label' => '종료 일시', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>                
                    </div>
                </div>
                <div class="sect3">
                    <div class="row2">
                        <div class="col-th"><h4 class="s-hty2">행사유료화</h4></div>
                        <div class="col-td">
                            <span class="chk-dsg"><input type="radio" id="cost1" name="cost" value="free"><label for="cost1">무료</label></span>
                            <span class="chk-dsg"><input type="radio" id="cost2" name="cost" value="charged"><label for="cost2">유료</label></span>
                        </div>
                    </div>    
                </div>
            </div>
            <div class="section2">
                <h3 class="s-hty1">상세 설정</h3>
                <div class="sect4">
                    <h4 class="s-hty2">공개 여부</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private1" value="1"><label for="private1">공개</label></span>
                        <p class="p-noti">누구나 이 행사를 보고 참여 할 수 있습니다.</p>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private2" value="0"><label for="private2">비공개</label></span>
                        <p class="p-noti">행사 URL을 얻은 사람만 행사에 참여 할 수 있습니다.</p>
                    </div>
                </div>
                <div id="group" class="sect5 mgtS1">
                    <h4 class="s-hty2">그룹 설정</h4>
                    <div class="ln-group">
                        <!-- <input id="group_name0" name="group_name0" type="text" class="ipt" placeholder="그룹명"> -->
                        <div class="ln-group-wp">
                            <!-- <input id="group_amount0" name="group_amount0" type="text" class="ipt" placeholder="그룹별 금액" style="margin-right:20px;">
                            <select class="select">
                                <option>인원 수</option>
                            </select>
                            <select id="group_people0" name="group_people0" class="select">
                                <option>인원수</option>
                                <option>1,000</option>
                                <option>2,000</option>
                                <option>3,000</option>
                                <option>4,000</option>
                            </select> -->
                            <a id="addGroup" class="btn-ty3 md" style="cursor:pointer">그룹추가</a>
                        </div>
                    </div>
                    <!-- <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p> -->
                </div>
                <div class="sect4 mgtS1">
                    <h4 class="s-hty2">참가자 승인 방법</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval1" value="1"><label for="auto_approval1">수동 승인</label></span>
                        <p class="p-noti">개설자가 승인한 참가자만 참여가 가능합니다.</p>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval2" value="0"><label for="auto_approval2">자동 승인</label></span>
                        <p class="p-noti">참가자가 행사 참여 신청을 하면 자동으로 승인이 됩니다.</p>
                    </div>
                </div>
                <div class="sect6 mgtS1">
                    <div class="sect-tit">
                        <h4 class="s-hty2">담당자 정보 입력</h4>
                        <span class="chk-dsg"><input type="checkbox" id="getUser"><label for="getUser">개설자 정보로 담당자 정보 입력</label></span>
                    </div>
                    <div>
                        <input type="text" id="name" name="name" placeholder="이름" class="ipt">
                        <input type="text" id="tel" name="tel" placeholder="연락처" class="ipt">
                        <input type="text" id="email" name="email" placeholder="이메일" class="ipt">
                        <div class="col-email-wp">
                            <!-- <input type="text" id="email" name="email" placeholder="이메일">
                            <span class="sp">@</span>
                            <select name="" id="">
                                <option value="">선택</option>
                            </select> -->
                        </div>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">참가자 정보</h4>
                    <p class="p-noti">필요한 참가자 정보를 선택합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="checkbox" id="require_name" name="require_name" value="1"><label for="require_name">이름</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_email" name="require_email" value="1"><label for="require_email">이메일</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_tel" name="require_tel" value="1"><label for="require_tel">연락처</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_age" name="require_age" value="1"><label for="require_age">나이</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_group" name="require_group" value="1"><label for="require_group">소속</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_sex" name="require_sex" value="1"><label for="require_sex">성별</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">웨비나 접속 시 본인 인증</h4>
                    <p class="p-noti">웨비나 접속 시 인증 절차를 진행합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert1" value="1"><label for="require_cert1">인증하기</label></span>
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert2" value="0"><label for="require_cert2">건너뛰기</label></span>
                    </div>
                </div>
                <div class="sect8 mgtS1">
                    <h4 class="s-hty2">행사 설명</h4>
                    <textarea id="detail_html" name="detail_html" cols="30" rows="10"></textarea>                    
                </div>
            </div>
            <div class="section4">
                <h3 class="s-hty1">부가 정보</h3>
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">확인 메일</h4>
                    <p class="p-noti2">행사 시작 1시간 전에 이메일로 행사 시작 시간을 알립니다. </p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice1" value="1"><label for="email_notice1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice2" value="0"><label for="email_notice2">사용 안함</label></span>
                    </div>
                </div>
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">추가 신청</h4>
                    <p class="p-noti2">모집 일시가 종료된 후에도 신청이 가능합니다. 이 때 신청자는 자동으로 대기 처리 됩니다.</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional1" value="1"><label for="additional1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional2" value="0"><label for="additional2">사용 안함</label></span>
                    </div>
                </div>
                <!-- <div class="sect10 mgtS1">
                    <div class="survey-tit">
                        <h4 class="s-hty3">설문</h4>
                        <button type="button" id="addSurvey" class="btn-ty4" onclick=false>+ 설문추가</button>
                    </div>                    
                    <div class="survey-bx">
                        <div class="survey-bx-sect1">
                            <div class="tits">
                                <select>
                                    <option>객관식</option>
                                    <option>주관식</option>
                                </select>
                                <div class="chk-dsg-wp">
                                    <span class="chk-dsg"><input type="radio" name="surv1" id="surv1-1"><label for="surv1-1">보기 중복 선택 가능</label></span>
                                    <span class="chk-dsg"><input type="radio" name="surv1" id="surv1-2"><label for="surv1-2">필수</label></span>
                                </div>                                
                            </div>
                            <div class="btns">                                
                                <button type="button" class="btn2">삭제</button>
                            </div>
                        </div>
                        <div class="survey-bx-sect2">
                            <input type="text" class="ipt" placeholder="질문">
                            <select>
                                <option>일반설문</option>
                                <option>사전설문</option>
                            </select>
                        </div>
                        <div class="survey-bx-sect3">
                            <div class="btns">
                                <button type="button">보기 추가</button>
                            </div>
                            <div class="wrt-after">
                                <input type="text" value="어느 계절이 가장 좋나요" class="ipt">
                                <button type="button" class="btn-del">보기 삭제</button>
                            </div>
                            <div class="wrt-before">
                                <input type="text" placeholder="보기" class="ipt">
                            </div>
                        </div>
                    </div>
                    
                    <div class="survey-bx">
                        <div class="survey-bx-sect1">
                            <div class="tits">
                                <select>
                                    <option>객관식</option>
                                    <option selected="selected">주관식</option>
                                </select>
                                <div class="chk-dsg-wp">
                                    <span class="chk-dsg"><input type="radio" name="surv2" id="surv2-1"><label for="surv2-1">보기 중복 선택 가능</label></span>
                                    <span class="chk-dsg"><input type="radio" name="surv2" id="surv2-2"><label for="surv2-2">필수</label></span>
                                </div>                                
                            </div>
                            <div class="btns">                                
                                <button type="button" class="btn2">삭제</button>
                            </div>
                        </div>
                        <div class="survey-bx-sect2">
                            <input type="text" class="ipt" placeholder="질문">
                            <select>
                                <option>일반설문</option>
                                <option>사전설문</option>
                            </select>
                        </div>                        
                    </div>
                    
                </div> -->
            </div>

            <div class="section-btm3 mgtS1">
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">개설</button>
                <button type="button" name="temp" class="btn-big bor">임시저장</button>
            </div>
        </div>        
    </div>
<?= $this->Form->end() ?>

<script>
    //메인 이미지 삽입 
    $("#image").change(function() {
        var formData = new FormData();
        var image = document.getElementById("image").files;
        formData.append('image', image[0]);
        formData.append('action', 'image');
        
        jQuery.ajax({
            url: '/exhibition/add/',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            type: 'POST',
        }).done(function (data) {
            if (data.status == 'success') {
                $("#mainImg").attr("src", "/" + data.path + "/" + data.imgName);
            } else {
                alert('이미지 등록에 실패하였습니다. 잠시 후 다시 시도해 주세요.');
            }
        });
    });

    //그룹 추가
    var groupIndex = 0;
    $("#addGroup").click(function() {
        var html = '';
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select name="group_people[]" class="select">';
        html += '               <option>인원수</option>';
        html += '               <option value="1000">1,000</option>';
        html += '               <option value="2000">2,000</option>';
        html += '               <option value="3000">3,000</option>';
        html += '               <option value="4000">4,000</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        groupIndex += 1;
        $("#group").append(html);
    });

    //그룹 제거
    function deleteGroup(index) {
        $("#group_" + index).remove();
        groupIndex -= 1;
    };

    //개설자 정보를 담당자 정보로 등록
    $("#getUser").change(function() {
        if ($("#getUser").is(":checked")) {
            jQuery.ajax({
                url: "/exhibition/get-user-info/",
                method: 'POST',
                type: 'json',
            }).done(function (data) {
                if (data.status == 'success') {
                    $("#name").val(data.name);
                    $("#tel").val(data.tel);
                    $("#email").val(data.email);
                }
            });
        } else {
            $("#name").val(null);
            $("#tel").val(null);
            $("#email").val(null);
        }
    });
    
    //개설
    $("button[name='save']").click(function() {
        var formData = $("#createForm").serialize();
        formData = formData + '&status=1';
        formData = formData + '&action=add';

        jQuery.ajax({
            url: "/exhibition/add/",
            method: 'POST',
            type: 'json',
            data: formData
        }).done(function (data) {
            if (data.status == 'success') {
                var imageData = new FormData();
                var image = document.getElementById("image").files;
                imageData.append('image', image[0]);
                
                jQuery.ajax({
                    url: '/exhibition/save-img/' + data.id,
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: imageData,
                    type: 'POST',
                }).done(function (data) {
                    if (data.status == 'success') {
                        alert("행사가 개설되었습니다.");
                        window.location.replace("/exhibition/index");
                    } else {
                        alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                    }
                });
            }else {
                alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            }
        });
    });

    CKEDITOR.replace('detail_html');
    
    // $(function() {
    //     <?php $a=1; ?>
    //     $('button[name=textAdd]').on('click', function() {
    //         $('button[name=textAdd]').before('<?php echo $this->Form->control('exhibition_survey.'.++$a.'.text', ['value' => '보기', 'label' => false]) ?>');
    //     })
    // });
</script>  