<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 * 
 */
?>
<style>
    .date-sett label {
        padding-bottom:10px;
    }

    em {
        color:#e4342d;
        font-weight:700;
        position:absolute;
        top:-8px;
        left:-6px;
    }

    .col-th { 
        vertical-align: top;
        position: relative;
    } 

    .s-hty2 { 
        position: relative;
    } 

    .selectDiv {
        display: flex;
        flex-direction: column;
    }
    .sect1 .photo {
        position: relative;
    }
    .sect1 .photo img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    @media  screen and (max-width: 768px) {
        .sect1 .photo {
            height: 214px;
        }  
    }

    @media  screen and (min-width: 768px) {
        .selectDiv {
            display: flex;
            flex-direction: row;
        }
    }
</style>

<?= $this->Form->create($exhibition, ['id' => 'createForm', 'enctype' => 'multipart/form-data'])?>
    <div id="container">    
        <div class="contents static">
            <h2 class="sr-only">행사 개설</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">기본설정</h3>
                    <!-- <div class="btn-wp">
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">개설</button>
                        <button type="button" name="temp" class="btn-ty4">임시저장</button>
                    </div> -->
                </div>
                
                <div class="sect1">
                    <div class="sect1-col1">
                        <div class="photo"><label for="image"><img id="mainImg" src="../images/img-no3.png" alt="이미지없음" style="height:214px"></div> 
                        <input type="file" id="image" name="image" style="display:none">
                        <p class="p-noti">클릭하여 이미지를 등록하세요.</p>
                    </div>
                    <div class="sect1-col2">
                        <div class="row2 fir">
                            <div class="col-th"><em class="st">*</em>행사이름</div>
                            <div class="col-td"><input type="text" id="title" name="title" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">간단한 행사 소개</div>
                            <div class="col-td"><input type="text" id="description" name="description" class="ipt"></div>
                        </div>
                        <div class="row2">
                            <div class="col-th">행사 분야 및 유형</div>
                            <div class="col-td sel-bx">
                                <div class="selectDiv">
                                    <?php echo $this->Form->control('category', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                                    <?php echo $this->Form->control('type', ['empty' => false, 'label' => false, 'class' => 'select', 'style' => 'width:274.36px; height:48.52px']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2"><em class="st">*</em>모집 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="apply_sdate" data-target-input="nearest">
                                <label for="data_apply_sdate">시작 일시</label> 
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->apply_sdate?>" id="data_apply_sdate" class="form-control datetimepicker-input" data-target="#apply_sdate"/>
                                    <div class="input-group-append" data-target="#apply_sdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="date-sett">
                            <div class="input-group date" id="apply_edate" data-target-input="nearest">
                                <label for="data_apply_edate">종료 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->apply_edate?>" id="data_apply_edate" class="form-control datetimepicker-input" data-target="#apply_edate"/>
                                    <div class="input-group-append" data-target="#apply_edate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>            
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2"><em class="st">*</em>행사 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <div class="input-group date" id="sdate" data-target-input="nearest">
                                <label for="data_sdate">시작 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->sdate?>" id="data_sdate" class="form-control datetimepicker-input" data-target="#sdate"/>
                                    <div class="input-group-append" data-target="#sdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="date-sett">
                            <div class="input-group date" id="edate" data-target-input="nearest">
                                <label for="data_apply_edate">종료 일시</label>
                                <div class="input-group date">
                                    <input type="text" value="<?=$exhibition->edate?>" id="data_edate" class="form-control datetimepicker-input" data-target="#edate"/>
                                    <div class="input-group-append" data-target="#edate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>              
                    </div>
                </div>
                <div class="sect3">
                    <div class="row2">
                        <div class="col-th"><h4 class="s-hty2">행사유료화</h4></div>
                        <div class="col-td">
                            <span class="chk-dsg"><input type="radio" id="cost1" name="cost" value="free" checked="checked"><label for="cost1">무료</label></span>
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
                        <span class="chk-dsg"><input type="radio" name="private" id="private1" value="0" checked="checked"><label for="private1">공개</label></span>
                        <p class="p-noti">누구나 이 행사를 보고 참여 할 수 있습니다.</p>
                    </div>
                    
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="private" id="private2" value="1"><label for="private2">비공개</label></span>
                        <p class="p-noti">행사 URL을 얻은 사람만 행사에 참여 할 수 있습니다.</p>
                    </div>
                </div>
                <div id="group" class="sect5 mgtS1">
                    <h4 class="s-hty2">그룹 설정</h4>
                    <div id="group_0">
                    <br>
                        <div class="ln-group">
                            <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">
                            <div class="ln-group-wp">
                                <input name="group_amount[]" type="hidden" class="ipt" placeholder="그룹별 금액" value="0" style="margin-right:20px;">
                                <select name="group_people[]" class="select">
                                    <option value="0">인원수</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                    <option value="200">200</option>
                                    <option value="300">300</option>
                                    <option value="400">400</option>
                                    <option value="500">500</option>
                                </select>
                            </div>
                        </div>
                    <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>
                    </div>
                </div>
                <a id="addGroup" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">그룹추가</a>
                <div class="sect4 mgtS1">
                    <h4 class="s-hty2">참가자 승인 방법</h4>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval1" value="0" checked="checked"><label for="auto_approval1">수동 승인</label></span>
                        <p class="p-noti">개설자가 승인한 참가자만 참여가 가능합니다.</p>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="auto_approval" id="auto_approval2" value="1"><label for="auto_approval2">자동 승인</label></span>
                        <p class="p-noti">참가자가 행사 참여 신청을 하면 자동으로 승인이 됩니다.</p>
                    </div>
                </div>
                <div class="sect6 mgtS1">
                    <div class="sect-tit">
                        <h4 class="s-hty2"><em class="st">*</em>담당자 정보 입력</h4>
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
                        <span class="chk-dsg"><input type="checkbox" id="require_name" name="require_name" value="1" checked="checked" onclick="return false"><label for="require_name">이름</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_email" name="require_email" value="1" checked="checked" onclick="return false"><label for="require_email">이메일</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_tel" name="require_tel" value="1"><label for="require_tel">연락처</label></span>
                        <!-- <span class="chk-dsg"><input type="checkbox" id="require_age" name="require_age" value="1"><label for="require_age">나이</label></span> -->
                        <span class="chk-dsg"><input type="checkbox" id="require_group" name="require_group" value="1"><label for="require_group">소속</label></span>
                        <span class="chk-dsg"><input type="checkbox" id="require_sex" name="require_sex" value="1"><label for="require_sex">성별</label></span>
                    </div>
                </div>
                <div class="sect7 mgtS1">
                    <h4 class="s-hty2">웨비나 접속 시 본인 인증</h4>
                    <p class="p-noti">웨비나 접속 시 인증 절차를 진행합니다.</p>
                    <div class="list-chks">
                        <span class="chk-dsg"><input type="radio" name="require_cert" id="require_cert1" value="1" checked="checked"><label for="require_cert1">인증하기</label></span>
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
                <!-- <div class="sect9 mgtS1">
                    <h4 class="s-hty3">확인 메일</h4>
                    <p class="p-noti2">행사 시작 1시간 전에 이메일로 행사 시작 시간을 알립니다. </p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice1" value="1" checked="checked"><label for="email_notice1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="email_notice" id="email_notice2" value="0"><label for="email_notice2">사용 안함</label></span>
                    </div>
                </div> -->
                <div class="sect9 mgtS1">
                    <h4 class="s-hty3">추가 신청</h4>
                    <p class="p-noti2">모집 일시가 종료된 후에도 신청이 가능합니다. 이 때 신청자는 자동으로 대기 처리 됩니다.</p>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional1" value="1" checked="checked"><label for="additional1">사용</label></span>
                    </div>
                    <div class="ln-rdo">
                        <span class="chk-dsg"><input type="radio" name="additional" id="additional2" value="0"><label for="additional2">사용 안함</label></span>
                    </div>
                </div>
                <div class="sect10 mgtS1">
                    <div class="survey-tit">
                        <h4 class="s-hty3">설문</h4>
                    </div>   
                    <div id="survey">                 
                        <!-- <div id="survey_0" class="survey-bx">
                            <div class="survey-bx-sect1">
                                <div class="tits">
                                    <select id="is_multiple_0" name="is_multiple[]">
                                        <option value="Y">객관식</option>
                                        <option value="N">주관식</option>
                                    </select>
                                    <div class="chk-dsg-wp">
                                        <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup0" value="Y"><label for="dup0">보기 중복 선택 가능</label></span>
                                        <input type="checkbox" name="is_duplicate[]" id="dup_hidden_0" value="N" checked="checked" style="display:none">
                                    </div>                                
                                </div>
                                <div class="btns">                                
                                    <button type="button" class="btn2" onclick="deleteSurvey(0)">삭제</button>
                                </div>
                            </div>
                            <div class="survey-bx-sect2">
                                <input name="text[]" type="text" class="ipt" placeholder="질문">
                                <select name="survey_type[]">
                                    <option value="N">일반설문</option>
                                    <option value="B">사전설문</option>
                                </select>
                            </div>
                            <div id="rows_0" class="survey-bx-sect3">
                                <div class="btns">
                                    <button type="button" onclick="addRow(0)">보기 추가</button>
                                </div>
                                <div id="row_0" class="wrt-after">
                                    <input name="child_text_0[]" type="text" class="ipt" placeholder="보기">
                                    <button type="button" class="btn-del" onclick="deleteRow(0)">보기 삭제</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <a id="surveyAdd" class="btn-ty3 md" style="margin-top:10px; cursor:pointer">설문추가</a>
                </div>
            </div>
            <div class="section-btm3 mgtS1">
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">개설</button>
                <button type="button" name="temp" class="btn-big bor">임시저장</button>
            </div>
        </div>        
    </div>
<?= $this->Form->end() ?>

<script src="/js/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" />

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
    
    //유무료 전환
    $(document).on("click", "input[name='cost']", function () {
        if ($("input[name='cost']:checked").val() == "free") {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "hidden");
                $(this).val(0);
            });
        } else {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "text");
                $(this).val('');
            });
        }
    });

    //커서 맨 앞으로
    $(document).on("click", "input[name='group_amount[]']", function () {
        $(this).val(",000");
        $(this).selectRange(0,0);
    });

    $.fn.selectRange = function(start, end) {
        return this.each(function() {
            if(this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    }; 

    //필수정보
    // $("#require_tel").click(function() {
    //     if ($(this).prop("checked") == true) {
    //         $("#require_email").attr("onclick", "");
    //     } else {
    //         $("#require_email").prop("checked", true);
    //         $("#require_email").attr("onclick", "return false");
    //     }
    // });

    //datetimepicker
    $(function () {
        $('#apply_sdate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#apply_edate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#sdate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
        $('#edate').datetimepicker({
            stepping : 30,
            useCurrent : false,
            sideBySide : true
        });
    });
    
    //유무료 전환
    $(document).on("click", "input[name='cost']", function () {
        if ($("input[name='cost']:checked").val() == "free") {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "hidden");
                $(this).val(0);
            });
        } else {
            $("input[name='group_amount[]']").each(function () {
                $(this).attr("type", "text");
                $(this).val('');
            });
        }
    });

    //커서 맨 앞으로
    $(document).on("click", "input[name='group_amount[]']", function () {
        $(this).val(",000");
        $(this).selectRange(0,0);
    });

    $.fn.selectRange = function(start, end) {
        return this.each(function() {
            if(this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    }; 

    //그룹 추가
    var groupIndex = 1;
    $(document).on("click", "#addGroup", function() {
        if ($("input[name='cost']:checked").val() == "free") {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="hidden" class="ipt" placeholder="그룹별 금액" value="0" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">인원수</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
            html += '</div>';
        } else {
            var html = '';
            html += '<div id=group_' + groupIndex + '>';
            html += '   <br>';
            html += '   <div class="ln-group">';
            html += '       <input name="group_name[]" type="text" class="ipt" placeholder="그룹명">';
            html += '       <div class="ln-group-wp">';
            html += '           <input name="group_amount[]" type="text" class="ipt" placeholder="그룹별 금액" style="margin-right:20px;">';
            html += '           <select name="group_people[]" class="select">';
            html += '               <option value="0">인원수</option>';
            html += '               <option value="50">50</option>';
            html += '               <option value="100">100</option>';
            html += '               <option value="200">200</option>';
            html += '               <option value="300">300</option>';
            html += '               <option value="400">400</option>';
            html += '               <option value="500">500</option>';
            html += '           </select>';
            html += '           <a onclick="deleteGroup(' + groupIndex + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
            html += '       </div>';
            html += '   </div>';
            html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
            html += '</div>';
        }
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
        //Validation
        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false;
        }
        
        if ($("#data_apply_sdate").val().length == 0) {
            alert("모집 시작일시를 입력해주세요.");
            $("#apply_sdate").focus();
            return false;
        }

        if ($("#data_apply_edate").val().length == 0) {
            alert("모집 종료일시를 입력해주세요.");
            $("#apply_edate").focus();
            return false;
        }

        if ($("#data_sdate").val().length == 0) {
            alert("행사 시작일시를 입력해주세요.");
            $("#sdate").focus();
            return false;
        }

        if ($("#data_edate").val().length == 0) {
            alert("행사 종료일시를 입력해주세요.");
            $("#edate").focus();
            return false;
        }

        if ($("#name").val().length == 0) {
            alert("담당자 이름을 입력해주세요.");
            $("#name").focus();
            return false;
        }

        if ($("#tel").val().length == 0) {
            alert("담당자 연락처를 입력해주세요.");
            $("#tel").focus();
            return false;
        }

        if ($("#email").val().length == 0) {
            alert("담당자 이메일을 입력해주세요.");
            $("#email").focus();
            return false;
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('참가자');
            }
        });
        
        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("유료 행사인 경우 그룹별 금액을 입력해주세요.");
                    group_empty = 1;
                    return false
                }
            });
        }

        if (group_empty == 1) {
            return false
        }

        $("select[name='group_people[]']").each(function () {
            if ($(this).val() == '0') {
                alert("그룹 인원수를 선택해 주세요.");
                $(this).focus();
                group_empty = 1;
                return false
            }
        });
        
        if (group_empty == 1) {
            return false
        }

        var formData = $("#createForm").serialize();
        formData = formData + '&status=1';
        formData = formData + '&action=add';
        formData = formData + '&detail=' + CKEDITOR.instances.detail_html.getData();

        var apply_sdate = new Date($("#data_apply_sdate").val());
        apply_sdate.setHours(apply_sdate.getHours()+9);
        formData = formData + '&apply_sdate=' + apply_sdate.toISOString();

        var apply_edate = new Date($("#data_apply_edate").val());
        apply_edate.setHours(apply_edate.getHours()+9);
        formData = formData + '&apply_edate=' + apply_edate.toISOString();

        var sdate = new Date($("#data_sdate").val());
        sdate.setHours(sdate.getHours()+9);
        formData = formData + '&sdate=' + sdate.toISOString();

        var edate = new Date($("#data_edate").val());
        edate.setHours(edate.getHours()+9);
        formData = formData + '&edate=' + edate.toISOString();

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
                        window.location.replace("/exhibition/index/all");
                    } else {
                        alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                    }
                });
            }else {
                alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            }
        });
    });

    //취소
    $("button[name='cancel']").click(function () {
        window.location.replace("/");
    });

    //임시저장
    $("button[name='temp']").click(function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false
        }

        var group_empty = 0;
        $("input[name='group_name[]']").each(function () {
            if ($(this).val() == '') {
                $(this).val('참가자');
            }
        });

        if ($("input:radio[name='cost']:checked").val() == "charged") {
            $("input[name='group_amount[]']").each(function () {
                if ($(this).val() == '' || $(this).val() == ',000') {
                    alert("유료 행사인 경우 그룹별 금액을 입력해주세요.");
                    group_empty = 1;
                    return false
                }
            });
        }

        if (group_empty == 1) {
            return false
        }

        $("select[name='group_people[]']").each(function () {
            if ($(this).val() == '0') {
                alert("그룹 인원수를 선택해 주세요.");
                $(this).focus();
                group_empty = 1;
                return false
            }
        });
        
        if (group_empty == 1) {
            return false
        }

        var formData = $("#createForm").serialize();
        formData = formData + '&status=4';
        formData = formData + '&action=add';
        formData = formData + '&detail=' + CKEDITOR.instances.detail_html.getData();

        var apply_sdate = new Date($("#data_apply_sdate").val());
        apply_sdate.setHours(apply_sdate.getHours()+9);
        formData = formData + '&apply_sdate=' + apply_sdate.toISOString();

        var apply_edate = new Date($("#data_apply_edate").val());
        apply_edate.setHours(apply_edate.getHours()+9);
        formData = formData + '&apply_edate=' + apply_edate.toISOString();

        var sdate = new Date($("#data_sdate").val());
        sdate.setHours(sdate.getHours()+9);
        formData = formData + '&sdate=' + sdate.toISOString();

        var edate = new Date($("#data_edate").val());
        edate.setHours(edate.getHours()+9);
        formData = formData + '&edate=' + edate.toISOString();

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
                        alert("행사가 임시저장 되었습니다.");
                        window.location.replace("/exhibition/index/temp");
                    } else {
                        alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                    }
                });
            }else {
                alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            }
        });
    });

    //CKEditor 불러오기
    CKEDITOR.replace('detail_html');
    
    //설문
    var i = 0; //설문 인덱스
    var j = 0; //보기 인덱스

    //설문 추가
    $("#surveyAdd").click(function () {
        var html = '';
        html += '<div id="survey_'+i+'" class="survey-bx">';
        html += '    <div class="survey-bx-sect1">';
        html += '        <div class="tits">';
        html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="0">';
        html += '                <option value="Y">객관식</option>';
        html += '                <option value="N">주관식</option>';
        html += '            </select>';
        html += '            <div class="chk-dsg-wp">';
        html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+i+'" value="Y"><label for="dup_'+i+'">보기 중복 선택 가능</label></span>';
        html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '                <span class="chk-dsg" id="req_span_'+i+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+i+'" value="Y"><label for="req_'+i+'">필수</label></span>';
        html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '            </div>';                                
        html += '        </div>';
        html += '        <div class="btns">';                                
        html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', 0)">삭제</button>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="survey-bx-sect2">';
        html += '        <input name="text[]" type="text" class="ipt" placeholder="질문">';
        html += '        <input name="survey_id[]" type="hidden" value="0">';
        html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
        html += '            <option value="N">일반설문</option>';
        html += '            <option value="B">사전설문</option>';
        html += '        </select>';
        html += '    </div>';
        html += '    <p id="type_noti_'+i+'" class="p-noti">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
        html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
        html += '        <div class="btns">';
        html += '            <button type="button" onclick="addRow('+i+')">보기 추가</button>';
        html += '        </div>';
        html += '        <div id="row_'+j+'" class="wrt-after">';
        html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="보기">';
        html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="0">'
        html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
        html += '        </div>';
        html += '    </div>';
        html += '</div>';
        i++;
        j++;
        $("#survey").append(html);
    });

    //설문 삭제
    function deleteSurvey(index) {
        $("#survey_" + index).remove();
        i--;
    };

    //보기 추가
    function addRow(index) {
        var html = '';
        html += '<div id="row_'+j+'" class="wrt-after">';
        html += '   <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="보기">';
        html += '   <button type="button" class="btn-del" onclick="deleteRow('+j+')">보기 삭제</button>';
        html += '</div>';
        $("#rows_" + index).append(html);
        j++;
    };

    //보기 삭제
    function deleteRow(index) {
        $("#row_" + index).remove();
        j--;
    };

    //주관식/객관식 전환
    $(document).on("change", "select[name='is_multiple[]']", function() {
        if ($("option:selected", this).val() == 'N') {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2];
            var html = '';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '            <option value="Y">객관식</option>';
            html += '            <option selected="selected" value="N">주관식</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'">필수</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="질문">';
            html += '    <input name="survey_id[]" type="hidden" value="0">';
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '        <option value="N">일반설문</option>';
            html += '        <option value="B">사전설문</option>';
            html += '    </select>';
            html += '</div>';
            html += '<p id="type_noti_'+index+'" class="p-noti">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
            
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        
        } else {
            var index = $(this).attr("id").substr($(this).attr("id"));
            index = index.split("_")[2];
            var html = '';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '                <option value="Y">객관식</option>';
            html += '                <option value="N">주관식</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup_'+index+'" value="Y"><label for="dup_'+index+'">보기 중복 선택 가능</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none;">';
            html += '                <span class="chk-dsg" id="req_span_'+index+'" style="display:none;"><input type="checkbox" name="is_required[]" id="req_'+index+'" value="Y"><label for="req_'+index+'">필수</label></span>';
            html += '                <input type="checkbox" name="is_required[]" id="req_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="질문">';
            html += '        <input name="survey_id[]" type="hidden" value="0">';
            html += '        <select id="survey_type_'+index+'" name="survey_type[]">';
            html += '            <option value="N">일반설문</option>';
            html += '            <option value="B">사전설문</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <p id="type_noti_'+index+'" class="p-noti">일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.</p>';
            html += '    <div id="rows_'+index+'" class="survey-bx-sect3">';
            html += '        <div class="btns">';
            html += '            <button type="button" onclick="addRow('+index+')">보기 추가</button>';
            html += '        </div>';
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="보기">';
            html += '            <input name="child_survey_id_'+index+'[]" type="hidden" value="0">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
            html += '        </div>';
            html += '    </div>';

            j++;
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        }
    });

    //is_duplicate 제어
    $(document).on("change", "input:checkbox[name='is_duplicate[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1];

        if (document.getElementById("dup_" + id).checked) {
            document.getElementById("dup_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("dup_hidden_" + id).disabled = false;
        }  
    });

    //is_required 제어
    $(document).on("change", "input:checkbox[name='is_required[]']", function() {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[1];

        if (document.getElementById("req_" + id).checked) {
            document.getElementById("req_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("req_hidden_" + id).disabled = false;
        }  
    });

    //설문타입 변경
    $(document).on("change", "select[name='survey_type[]']", function () {
        var id = $(this).attr("id").substr($(this).attr("id"));
        id = id.split("_")[2];

        if ($(this).val() == 'N') {
            $("#req_span_"+id).hide();
            $("#req_"+id).prop("checked", false);
            $("#req_hidden_"+id).attr("disabled", false);
            $("#type_noti_"+id).html("일반설문으로 설정하시면 행사 진행 중에 참가자분들이 설문에 참여할 수 있습니다.");
        } else {
            $("#req_span_"+id).show();
            $("#type_noti_"+id).html("사전설문으로 설정하시면 행사 신청 때 참가자분들이 설문에 참여할 수 있습니다.");
        }
    });

</script>  