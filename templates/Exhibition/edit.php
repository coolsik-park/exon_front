<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>

<?= $this->Form->create($exhibition, ['id' => 'editForm', 'enctype' => 'multipart/form-data'])?>
    <div id="container">    
        <div class="sub-menu">
            <div class="sub-menu-inner">
                <ul class="tab">
                    <li class ="active"><a href="">행사 설정 수정</a></li>
                    <li><a href="/exhibition/survey-data/<?= $id ?>">설문 데이터</a></li>
                    <li><a href="/exhibition/manager-person/<?= $id ?>">참가자 관리</a></li>
                    <li><a href="/exhibition-stream/set-exhibition-stream/<?= $id ?>">웨비나 송출 설정</a></li>
                    <li><a href="/exhibition/exhibition-statistics-apply/<?= $id ?>">행사 통계</a></li>
                </ul>
            </div>
        </div>        
        <div class="contents static">
            <h2 class="sr-only">행사 개설</h2>
            <div class="section1">
                <div class="sect-tit">
                    <h3 class="s-hty1">기본설정</h3>
                    <div class="btn-wp">
                        <?php if ($exhibition->status == 4) : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">개설</button>
                        <button type="button" name="temp" class="btn-ty4">임시저장</button>
                        <?php else : ?>
                        <button type="button" name="cancel" class="btn-ty4 red">취소</button>
                        <button type="button" name="save" class="btn-ty4">저장</button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="sect1">
                    <div class="sect1-col1">
                        <div class="photo">
                            <?php if ($exhibition->image_path != '') : ?>
                            <label for="image"><img img id="mainImg" src="<?= DS . $exhibition->image_path . DS . $exhibition->image_name ?>" style="width:380px; height:214px"></p>
                            <?php else : ?>
                            <label for="image"><img id="mainImg" src="../../images/img-no3.png" alt="이미지없음" style="width:380px; height:214px"></p>
                            <?php endif; ?>
                        </div> 
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
                            <?php echo $this->Form->control('apply_sdate', ['id' =>'apply_sdate', 'label' => '시작 일시', 'placeholder' => '시작날짜', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>
                        <div class="date-sett">
                            <?php echo $this->Form->control('apply_edate', ['id' =>'apply_edate', 'label' => '종료 일시', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>               
                    </div>
                </div>
                <div class="sect2">
                    <h4 class="s-hty2">행사 일시</h4>
                    <div class="date-sett-wp">
                        <div class="date-sett">
                            <?php echo $this->Form->control('sdate', ['id' =>'sdate', 'label' => '시작 일시', 'placeholder' => '시작날짜', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
                        </div>
                        <div class="date-sett">
                            <?php echo $this->Form->control('edate', ['id' =>'edate', 'label' => '종료 일시', 'class' => 'date-date', 'style' => 'width:370px; height:48.52px']); ?>
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
                    <input type="hidden" id="hidden_detail" value="<?=$exhibition->detail_html?>">
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
                <div class="sect10 mgtS1">
                    <div class="survey-tit">
                        <h4 class="s-hty3">설문</h4>
                        <button id="surveyAdd" type="button" class="btn-ty4">+ 설문추가</button>
                    </div>   
                    <div id="survey">

                    </div>
                </div>
            </div>

            <div class="section-btm3 mgtS1">
                <?php if ($exhibition->status == 4) : ?>
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">개설</button>
                <button type="button" name="temp" class="btn-big">임시저장</button>
                <?php else : ?>
                <button type="button" name="cancel" class="btn-big red">취소</button>
                <button type="button" name="save" class="btn-big">저장</button>
                <?php endif; ?>
            </div>
        </div>        
    </div>
<?= $this->Form->end() ?>

<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
    //CKEditor 불러오기
    CKEDITOR.replace('detail_html');

    //DB 데이터 불러오기
    var img = "<?=$exhibition->image_name?>";
    if (img != '') {
        $("#mainImg").attr("src", "/<?=$exhibition->image_path?>/<?=$exhibition->image_name?>");
    } else {
        $("#mainImg").attr("src", "../../images/img-no3.png");
    }
    var detail = $("#hidden_detail").val();
    if (detail != '') {
        CKEDITOR.instances.detail_html.setData(detail);
    }

    $("#title").val("<?=$exhibition->title?>");
    $("#description").val("<?=$exhibition->description?>");
    $("#title").val("<?=$exhibition->title?>");
    $("input:radio[name='cost']:radio[value='<?=$exhibition->cost?>']").prop("checked", true);
    $("input:radio[name='private']:radio[value='<?=$exhibition->private?>']").prop("checked", true);
    $("input:radio[name='auto_approval']:radio[value='<?=$exhibition->auto_approval?>']").prop("checked", true);
    $("#name").val("<?=$exhibition->name?>");
    $("#tel").val("<?=$exhibition->tel?>");
    $("#email").val("<?=$exhibition->email?>");
    if ($('input:checkbox[name="require_name"]').val() == "<?=$exhibition->require_name?>") { 
        $('input:checkbox[name="require_name"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_email"]').val() == "<?=$exhibition->require_email?>") { 
        $('input:checkbox[name="require_email"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_tel"]').val() == "<?=$exhibition->require_tel?>") { 
        $('input:checkbox[name="require_tel"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_age"]').val() == "<?=$exhibition->require_age?>") { 
        $('input:checkbox[name="require_age"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_group"]').val() == "<?=$exhibition->require_group?>") { 
        $('input:checkbox[name="require_group"]').prop("checked", true); 
    }
    if ($('input:checkbox[name="require_sex"]').val() == "<?=$exhibition->require_sex?>") { 
        $('input:checkbox[name="require_sex"]').prop("checked", true); 
    }
    $("input:radio[name='require_cert']:radio[value='<?=$exhibition->require_cert?>']").prop("checked", true);
    $("input:radio[name='email_notice']:radio[value='<?=$exhibition->email_notice?>']").prop("checked", true);
    $("input:radio[name='additional']:radio[value='<?=$exhibition->additional?>']").prop("checked", true);

    //그룹 데이터 불러오기
    var groupIndex = 0;
    <?php $i = 0; ?>
    <?php foreach ($exhibitionGroups as $exhibitionGroup) : ?>
        var html = '';  
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="<?=$exhibitionGroup->id?>">';
        html += '       <input name="group_name[]" type="text" class="ipt" value="<?=$exhibitionGroup->name?>" placeholder="그룹명">';
        html += '       <div class="ln-group-wp">';
        html += '           <input name="group_amount[]" type="text" class="ipt" value="<?=$exhibitionGroup->amount?>" placeholder="그룹별 금액" style="margin-right:20px;">';
        html += '           <select id="select' + groupIndex + '" name="group_people[]" class="select">';
        html += '               <option>인원수</option>';
        html += '               <option value="1000">1,000</option>';
        html += '               <option value="2000">2,000</option>';
        html += '               <option value="3000">3,000</option>';
        html += '               <option value="4000">4,000</option>';
        html += '           </select>';
        html += '           <a onclick="deleteGroup(' + groupIndex + ',' + <?=$exhibitionGroup->id?> + ')" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        groupIndex += 1;
        $("#group").append(html);
        $("#select<?=$i?>").val("<?=$exhibitionGroup->people?>").prop("selected", true);
        <?php $i++; ?>
    <?php endforeach; ?>
    
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
    $("#addGroup").click(function() {
        var html = '';
        html += '<div id=group_' + groupIndex + '>';
        html += '   <br>';
        html += '   <div class="ln-group">';
        html += '       <input name="group_id[]" type="hidden" class="ipt" value="0">';
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
        html += '           <a onclick="deleteGroup(' + groupIndex+ ', 0)" class="btn-ty3 md" style="cursor:pointer">삭제</a>';
        html += '       </div>';
        html += '   </div>';
        html += '   <p class="p-noti">그룹명 미 설정 시 그룹명은 ‘참가자’가 됩니다.</p>';
        html += '</div>';
        groupIndex += 1;
        $("#group").append(html);
    });

    //그룹 제거
    function deleteGroup(index, id) {
        var html = '';
        html += '<input name="group_del[]" type="hidden" class="ipt" value="' + id + '">';
        $("#group").append(html);
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
    
    //저장
    $("button[name='save']").click(function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false;
        }

        if ($("#apply_sdate").val().length == 0) {
            alert("모집 시작일시를 입력해주세요.");
            $("#apply_sdate").focus();
            return false;
        }

        if ($("#apply_edate").val().length == 0) {
            alert("모집 종료일시를 입력해주세요.");
            $("#apply_edate").focus();
            return false;
        }

        if ($("#sdate").val().length == 0) {
            alert("행사 시작일시를 입력해주세요.");
            $("#sdate").focus();
            return false;
        }

        if ($("#edate").val().length == 0) {
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
        
        var formData = $("#editForm").serialize();
        formData = formData + '&status=1';
        formData = formData + '&action=add';
        formData = formData + '&detail=' + CKEDITOR.instances.detail_html.getData();

        jQuery.ajax({
            url: "/exhibition/edit/<?=$id?>",
            method: 'PUT',
            type: 'json',
            data: formData
        }).done(function (data) {
            // if (data.status == 'success') {
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
                        alert("저장 되었습니다.");
                        window.location.replace("/exhibition/index/all");
                    } else {
                        alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
                    }
                });
            // } else {
            //     alert("오류가 발생하였습니다. 잠시 후 시도해주세요.");
            // }
        });
    });

    //취소
    $("button[name='cancel']").click(function () {
        window.location.replace("/exhibition/index/all");
    });

    //임시저장
    $("button[name='temp']").click(function() {
        //Validation
        if ($("#title").val().length == 0) {
            alert("행사이름을 입력해주세요.");
            $("#title").focus();
            return false;
        }

        var formData = $("#editForm").serialize();
        formData = formData + '&status=4';
        formData = formData + '&action=add';
        formData = formData + '&detail=' + CKEDITOR.instances.detail_html.getData();
        
        jQuery.ajax({
            url: "/exhibition/edit/<?=$id?>",
            method: 'PUT',
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
                        alert("임시저장 되었습니다.");
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
    
    //설문
    var i = 0; //설문 인덱스
    var j = 0; //보기 인덱스

    //설문 데이터 불러오기
    <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
        <?php if ($exhibitionSurvey->is_multiple == 'Y') : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '                <option value="Y">객관식</option>';
            html += '                <option value="N">주관식</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup'+i+'" value="Y"><label for="dup'+i+'">보기 중복 선택 가능</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '                <!-- <span class="chk-dsg"><input type="checkbox" name="surv1" id="surv1-2" value="1"><label for="surv1-2">필수</label></span> -->';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">삭제</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="질문" value="<?=$exhibitionSurvey->text?>">';
            html += '        <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">'
            html += '        <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '            <option value="N">일반설문</option>';
            html += '            <option value="B">사전설문</option>';
            html += '        </select>';
            html += '    </div>';
            html += '    <div id="rows_'+i+'" class="survey-bx-sect3">';
            html += '        <div class="btns">';
            html += '            <button type="button" onclick="addRow('+i+')">보기 추가</button>';
            html += '        </div>';
            <?php foreach ($exhibitionSurvey->child_exhibition_survey as $child) : ?>
            html += '        <div id="row_'+j+'" class="wrt-after">';
            html += '            <input name="child_text_'+i+'[]" type="text" class="ipt" placeholder="보기" value="<?=$child->text?>">';
            html += '            <input name="child_survey_id_'+i+'[]" type="hidden" value="<?=$child->id?>">'
            html += '            <button type="button" class="btn-del" onclick="deleteRow('+j+', <?=$child->id?>)">보기 삭제</button>';
            html += '        </div>';
            j++;
            <?php endforeach; ?>
            html += '    </div>';
            html += '</div>';
            $("#survey").append(html);
            <?php if ($exhibitionSurvey->is_duplicate == 'Y') : ?>
                $("#dup" + i).prop("checked", true);
                document.getElementById("dup_hidden_" + i).disabled = true;
            <?php else: ?>
                $("#dup" + i).prop("checked", false);
                document.getElementById("dup_hidden_" + i).disabled = false;
            <?php endif; ?>
            $("#survey_type_" + i).val("<?=$exhibitionSurvey->survey_type?>").prop("selected", true);
        
        <?php else : ?>
            var html = '';
            html += '<div id="survey_'+i+'" class="survey-bx">';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+i+'" name="is_multiple[]" class="<?=$exhibitionSurvey->id?>">';
            html += '            <option value="Y">객관식</option>';
            html += '            <option selected="selected" value="N">주관식</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+i+', <?=$exhibitionSurvey->id?>)">삭제</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="질문" value="<?=$exhibitionSurvey->text?>">';
            html += '    <input name="survey_id[]" type="hidden" value="<?=$exhibitionSurvey->id?>">'
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
            html += '    <select id="survey_type_'+i+'" name="survey_type[]">';
            html += '        <option value="N">일반설문</option>';
            html += '        <option value="B">사전설문</option>';
            html += '    </select>';
            html += '</div>';
            html += '</div>';
            $("#survey").append(html);
            $("#survey_type_" + i).val("<?=$exhibitionSurvey->survey_type?>").prop("selected", true);
        <?php endif; ?>
        i++;
    <?php endforeach; ?>

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
        html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup'+i+'" value="Y"><label for="dup'+i+'">보기 중복 선택 가능</label></span>';
        html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+i+'" value="N" checked="checked" style="display:none">';
        html += '                <!-- <span class="chk-dsg"><input type="checkbox" name="surv1" id="surv1-2" value="1"><label for="surv1-2">필수</label></span> -->';
        html += '            </div>';                                
        html += '        </div>';
        html += '        <div class="btns">';                                
        html += '            <button type="button" class="btn2" onclick="deleteSurvey('+i+', 0)">삭제</button>';
        html += '        </div>';
        html += '    </div>';
        html += '    <div class="survey-bx-sect2">';
        html += '        <input name="text[]" type="text" class="ipt" placeholder="질문">';
        html += '        <input name="survey_id[]" type="hidden" value="0">'
        html += '        <select name="survey_type[]">';
        html += '            <option value="N">일반설문</option>';
        html += '            <option value="B">사전설문</option>';
        html += '        </select>';
        html += '    </div>';
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
    function deleteSurvey(index, id) {
        var html = '';
        html += '<input name="survey_del[]" type="hidden" value="' + id + '">';
        $("#survey").append(html);
        $("#survey_" + index).remove();
        i--;
    };

    //보기 추가
    function addRow(index) {
        var html = '';
        html += '<div id="row_'+j+'" class="wrt-after">';
        html += '   <input name="child_text_'+index+'[]" type="text" class="ipt" placeholder="보기">';
        html += '   <input name="child_survey_id[]" type="hidden" value="0">'
        html += '   <button type="button" class="btn-del" onclick="deleteRow('+j+', 0)">보기 삭제</button>';
        html += '</div>';
        $("#rows_" + index).append(html);
        j++;
    };

    //보기 삭제
    function deleteRow(index, id) {
        var html = '';
        html += '<input name="child_survey_del[]" type="hidden" value="' + id + '">';
        $("#survey").append(html);
        $("#row_" + index).remove();
        j--;
    };

    //주관식/객관식 전환
    $(document).on("change", "select[name='is_multiple[]']", function() {
        
        if ($(this).attr("class") != 0) {
            alert("저장된 설문의 객관식/주관식 항목을 수정하시려면 삭제 후 다시 등록해 주세요.");
            if ($("option:selected", this).val() == 'N') {
                $(this).val("Y").prop("selected", true);
            } else {
                $(this).val("N").prop("selected", true);
            }
            return false;
        }

        if ($("option:selected", this).val() == 'N') {
            var index = $(this).attr("id").substr($(this).attr("id").length-1, 1);
            var html = '';
            html += '<div class="survey-bx-sect1">';
            html += '    <div class="tits">';
            html += '        <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '            <option value="Y">객관식</option>';
            html += '            <option selected="selected" value="N">주관식</option>';
            html += '        </select>';
            html += '        <div class="chk-dsg-wp">';
            html += '        </div>';                           
            html += '    </div>';
            html += '    <div class="btns">';                          
            html += '       <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '    </div>';
            html += '</div>';
            html += '<div class="survey-bx-sect2">';
            html += '    <input name="text[]" type="text" class="ipt" placeholder="질문">';
            html += '    <input name="survey_id[]" type="hidden" value="0">'
            html += '    <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '    <select name="survey_type[]">';
            html += '        <option value="N">일반설문</option>';
            html += '        <option value="B">사전설문</option>';
            html += '    </select>';
            html += '</div>';
            
            $("#survey_" + index).children().remove();
            $("#survey_" + index).append(html);
        
        } else {
            var index = $(this).attr("id").substr($(this).attr("id").length-1, 1);
            var html = '';
            html += '    <div class="survey-bx-sect1">';
            html += '        <div class="tits">';
            html += '            <select id="is_multiple_'+index+'" name="is_multiple[]" class="0">';
            html += '                <option value="Y">객관식</option>';
            html += '                <option value="N">주관식</option>';
            html += '            </select>';
            html += '            <div class="chk-dsg-wp">';
            html += '                <span class="chk-dsg"><input type="checkbox" name="is_duplicate[]" id="dup'+index+'" value="Y"><label for="dup'+index+'">보기 중복 선택 가능</label></span>';
            html += '                <input type="checkbox" name="is_duplicate[]" id="dup_hidden_'+index+'" value="N" checked="checked" style="display:none">';
            html += '                <!-- <span class="chk-dsg"><input type="checkbox" name="surv1" id="surv1-2" value="1"><label for="surv1-2">필수</label></span> -->';
            html += '            </div>';                                
            html += '        </div>';
            html += '        <div class="btns">';                                
            html += '            <button type="button" class="btn2" onclick="deleteSurvey('+index+', 0)">삭제</button>';
            html += '        </div>';
            html += '    </div>';
            html += '    <div class="survey-bx-sect2">';
            html += '        <input name="text[]" type="text" class="ipt" placeholder="질문">';
            html += '        <input name="survey_id[]" type="hidden" value="0">'
            html += '        <select name="survey_type[]">';
            html += '            <option value="N">일반설문</option>';
            html += '            <option value="B">사전설문</option>';
            html += '        </select>';
            html += '    </div>';
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
        var id = $(this).attr("id").substr($(this).attr("id").length - 1, 1);
        
        if (document.getElementById("dup" + id).checked) {
            document.getElementById("dup_hidden_" + id).disabled = true;
        
        } else {
            document.getElementById("dup_hidden_" + id).disabled = false;
        }  
    });
</script>
