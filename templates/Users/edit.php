<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$naver_client_id = getEnv('NAVER_CLIENT_ID');
$naver_redirectURI = urlencode(NAVER_CONNECT_URL);
$_SESSION['state'] = md5(microtime()) . mt_rand();
$state = $_SESSION['state'];
$naver_apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$naver_client_id."&redirect_uri=".$naver_redirectURI."&state=".$state;

$kakao_client_id = getEnv('KAKAO_CLIENT_ID');
$kakao_redirectURI = urlencode(KAKAO_CONNECT_URL);
$kakao_apiURL = "https://kauth.kakao.com/oauth/authorize?response_type=code&client_id=".$kakao_client_id."&redirect_uri=".$kakao_redirectURI
?>

<style>
.col-dd {
    /* pointer-events : none; */
}
.blueBtn {
    display: inline-block;
    padding: 8px 22px;
    border-radius: 3px;
    border: solid 1px #0071BC;
    background-color: #FFFFFF;
    font-size: 1rem;
    font-weight: 500;
    line-height: 1.5;
    color: #0071BC;
    text-align: center;
}
#emailText {
    width: 100%;
}
.emailBtn {
    width: 135px;
}

@media  screen and (min-width: 768px) {
    #delete {
        position: absolute;
        top: 100px;
        right: 10px;
    }
    .contents.static {
        position: relative;
    }
}
@media  screen and (max-width: 768px) {
    .emailBtn {
        width: 100%;
    }
}
@media  screen and (min-width: 1024px) {
    .profile-photo .photo img {
        width: 200px;
        height: 200px;
    }
    #imgUpload {
        margin-left: 66px;
    }
    .profile-photo .btns .btn-ty3 {
        width: 200%;
    }
    
}
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<div id="container">
    <div class="contents static">
        <h2 class="s-hty">회원정보수정</h2>
        <div class="section3">
            <h3 class="s-hty1 fir">기본 정보</h3>
            <div class="mbr-form">
                <div class="item-row">
                    <div class="col-dt"><em>*</em>이메일 (아이디)</div>
                    <?php if ($user->email_cert != 1): ?>
                        <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <input type="text" id="emailText" readonly="readonly" class="full" value="<?= $user->email ?>" title="이메일 (아이디)">
                            </div>
                            <button type="button" class="btn-ty3 md emailBtn" data-toggle="modal" data-target="#emailModal">이메일 인증</button>
                        </div>
                        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="background-color:transparent; border:none;">
                                    <div class="popup-wrap">
                                        <div class="popup-head">
                                            <h4>이메일 인증</h4>
                                            <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                        </div>
                                        <div class="popup-body">
                                            <div class="cert-sect1">
                                                <input id="email" type="text" placeholder="이메일" autocomplete="off" value="<?= $user->email ?>">
                                                <button id="emailSend" type="button" class="btn-ty2 btn-m-bor">인증메일 발송</button>
                                            </div>
                                            <p id="emailNoti" class="noti hc1"></p>
                                            <div class="cert-sect2">
                                                <div class="label-wp">
                                                    <label for="emailCode">인증번호</label><input type="text" id="emailCode" placeholder="인증번호" autocomplete="off">
                                                </div> 
                                                <button id="eamilResend" type="button" class="btn-ty2 gray">재발송</button>
                                            </div>
                                            <p id="emailCodeNoti" class="noti hc1"></p>
                                            <div class="popup-btm alone">
                                                <button id="emailConfirm" type="button" class="btn-ty2">확인</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <input type="text" id="emailText" readonly="readonly" class="full" value="<?= $user->email ?>" title="이메일 (아이디)">
                            </div>
                            <button type="button" class="blueBtn md emailBtn" data-toggle="modal" style='cursor:default;'>인증 완료</button>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="item-row">
                    <div class="col-dt"><em>*</em>비밀번호</div>                      
                    <div class="col-dd">
                        <input type="password"  id="password" class="full" title="비밀번호">
                        <p id="lengthNoti" class="noti hc1"></p>
                    </div>
                </div>  
                <div class="item-row">
                    <div class="col-dt"><em>*</em>비밀번호 확인</div>
                    <div class="col-dd">
                        <input type="password"  id="passwordRe" class="full" title="비밀번호 확인">
                        <p id="ReNoti" class="noti hc1"></p>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt"><em>*</em>이름</div>                    
                  <div class="col-dd">
                      <input type="text" id="name" class="full" value="<?= $user->name ?>" title="이름">
                      <p id="nameNoti" class="noti hc1"></p>
                  </div>
                </div>    
                <div class="item-row" id="hp-row">
                    <div class="col-dt">휴대전화 번호</div>    
                        <?php if ($user->hp_cert == 0): ?>                
                            <div class="col-dd col-cell">
                            <div class="col-cell-wp">
                                <select id="cellNumber">
                                    <option value="010">010</option>
                                </select>
                                <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="- 없이 입력해 주세요" title="휴대전화 번호">
                            </div>
                            <button type="button" class="btn-ty3 md" data-toggle="modal" id="smsButton" data-target="#smsModal">
                                휴대전화 인증
                            </button>
                            <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content" style="background-color:transparent; border:none;">
                                        <div class="popup-wrap">
                                            <div class="popup-head">
                                                <h4>휴대폰 인증</h4>
                                                <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                            </div>
                                            <div class="popup-body"> 
                                                <div class="cert-sect1">
                                                    <input id="sms" type="text" placeholder="전화번호">
                                                    <button id="smsSend" type="button" class="btn-ty2 btn-m-bor">인증문자 발송</button>
                                                </div>        
                                                <p id="smsNoti" class="noti hc1"></p>
                                                <div class="cert-sect2">
                                                    <div class="label-wp">
                                                        <label for="smsCode">인증번호</label><input type="text" id="smsCode" placeholder="인증번호">
                                                    </div> 
                                                    <button id="smsResend" type="button" class="btn-ty2 gray">재발송</button>
                                                </div>
                                                <p id="smsCodeNoti" class="noti hc1"></p>
                                                <div class="popup-btm alone">
                                                    <button id="smsConfirm" type="button" class="btn-ty2">확인</button>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>                    
                            <div class="col-dd col-cell">
                                <div class="col-cell-wp" style="width: 100%;">
                                    <select id="cellNumber">
                                        <option value="010">010</option>
                                    </select>
                                    <input type="text" id="cellNumber2" value="<?= substr($user->hp, 3) ?>" placeholder="- 없이 입력해 주세요" title="휴대전화 번호">
                                </div>
                        <?php endif; ?>
                    </div>
                  <p id="hpNoti" class="noti hc1"></p>
                </div>
            </div>
        </div>
        <div class="section4">
            <h3 class="s-hty1">부가 정보</h3>
            <div class="log-other">
                <label class="chk-box">
                    <input id="kakao-connect" type="radio" name="logOther">
                    <span class="btn-kakao"><span>KaKao 연동하기</span></span>
                </label>
                <label class="chk-box">
                    <input id="naver-connect" type="radio" name="logOther">
                    <span class="btn-naver"><span>NAVER 연동하기</span></span>
                </label>
            </div>
            <div class="mbr-form mgtS1">
                <div class="item-row" id="image-row">
                    <div class="col-dt">프로필 사진</div>     
                    <div class="col-dd">
                        <div class="profile-photo">
                            <?php if ($user->image_name == null) { ?>
                                    <div class="mouse-area" id="dropZone">
                                        <!-- <label for="imgSaveButton"><span class="ico-plus-c">+</span></label>
                                        <input type="file" id="imgSaveButton" name="imgSaveButton" accept="image/*" style="display:none"> -->
                                        <p>마우스로 자료를 끌어오세요</p>
                                    </div>
                            <?php } else { ?>
                                    <div class="photo">
                                        <img src="/<?= $user->image_path ?>/<?= $user->image_name ?>">
                                    </div>
                            <?php } ?>
                            <div class="btns">
                                <form name="imgUpload" id="imgUpload">
                                    <label class="btn-ty3" for="imgSaveButton">불러오기</label>
                                    <input type="file" id="imgSaveButton" name="imgSaveButton" accept="image/*" style="display:none"/>
                                    <?php if ($user->image_name != null) { ?>
                                        <button type="button" class="btn-ty3 bor" id="imgDeleteButton">삭제</button>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-row">
                  <div class="col-dt">생년월일</div>
                  <div class="col-dd">
                        <div class="birth-wp" id="ymd">
                            <select class="yy" id="yy"></select>
                            <span>년</span>
                            <select class="mm" id="mm"></select>
                            <span>월</span>
                            <select class="dd" id="dd"></select>
                            <span>일</span>
                        </div>                            
                  </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">성별</div>
                    <div class="col-dd">
                         <select class="gender" id="gender">
                            <?php
                              if ($user->sex == "F" || $user->sex == null) {
                            ?>
                                <option value="M">남성</option>
                                <option value="F" selected="selected">여성</option>
                            <?php
                              } else {
                            ?>
                                <option value="M" selected="selected">남성</option>
                                <option value="F">여성</option>
                            <?php
                              }
                            ?>
                         </select>              
                    </div>
                </div>
                <div class="item-row">
                    <div class="col-dt">소속/직함</div>
                    <div class="col-dd">
                        <div class="belong">
                            <input type="text" id="company" value="<?= $user->company ?>" title="소속">
                            <input type="text" id="title" value="<?= $user->title ?>" title="직함">
                        </div>                   
                    </div>
                </div>
                <div class="item-row">
                    <button type="button" class="btn-ty3 bor md" id="delete">회원 탈퇴</button>
                </div>
            </div>
        </div>
        <div class="section-btm2 mgtS1">
            <a href="javascript:history.back();" id="backButton" class="btn-big bor">취소</a>
            <a href="#" id="saveButton" class="btn-big" style="cursor:pointer;">저장</a>
        </div>
    </div>
</div>

<script>
    //회원탈퇴
    $(document).on("click", "#delete", function () {
        if (confirm("회원 탈퇴시 행사참여 정보 및 결제 정보는 모두 삭제됩니다.\n탈퇴하시겠습니까?")) {
            jQuery.ajax({
                url: "/users/delete/<?=$user->id?>", 
                method: 'DELETE',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("회원탈퇴가 완료되었습니다.");
                    window.location.replace("/users/logout");
                } else if(data.status == 'fail') {
                    alert("오류가 발생하였습니다. 다시 시도해 주세요.");
                } else {
                    alert("개설한 행사가 있는 경우 회원탈퇴를 할 수 없습니다.\n행사 취소 후 다시 시도해주세요.");
                }
            });
        }
    });

    $(document).on("change", "#email", function () {
        $("#emailNoti").html("");
    });

    $(document).on("change", "#emailCode", function () {
        $("#emailCodeNoti").html("");
    });
    
    $("#emailSend").click(function () {
        if ($("#email").val() == "") {
            $("#emailNoti").html("이메일을 입력해 주세요.");
            $("#email").focus();
            return false;
        }

        jQuery.ajax({
            url: "/users/send-email-certification", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;
                $("#emailSend").html("<span id='timer'></span>");
                $("#emailSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("다시인증을 시도해주세요.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    $("#emailResend").click(function () {
        if ($("#email").val() == "") {
            $("#emailNoti").html("이메일을 입력해 주세요.");
            $("#email").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/send-email-certification", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;

                $("#emailSend").html("<span id='timer'></span>");
                $("#emailSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("다시인증을 시도해주세요.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    $("#emailConfirm").click(function () {
        var user_id = '<?=$user->id?>';

        if ($("#emailCode").val() == "") {
            $("#emailCodeNoti").html("인증번호를 입력해 주세요.");
            $("#emailCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/confirm-email/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#emailCode").val(),
                user_id: user_id,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                window.location.replace("/");
            } else if (data.status == 'fail') {
                alert("인증번호를 다시 확인해주세요.");
                $("#emailCode").val("");
            } else {
                alert("시간이 초과되었습니다. 재발송 해주세요.");
                $("#emailCode").val("");
            }
        });
    });

    last_id = 0;

    $(document).on("change", "#sms", function() {
        $("#smsNoti").html("");
    });

    $(document).on("change", "#smsCode", function () {
        $("#smsCodeNoti").html("");
    });

    $(document).on("click", "#smsButton", function () {
        $("#sms").attr('value', $("#cellNumber").val()+$("#cellNumber2").val());
    });

    $(document).on('click', "#smsSend", function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("전화번호를 입력해 주세요.");
            $("#sms").focus();
            return false;
        }

        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#sms").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;
                $("#smsSend").html("<span id='timer'></span>");
                $("#smsSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("다시인증을 시도해주세요.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    $("#reSend").click(function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("전화번호를 입력해 주세요.");
            $("#sms").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#sms").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 재발송하였습니다.");
                last_id = data.id;

                $("#smsSend").html("<span id='timer'></span>");
                $("#smsSend").attr("disabled", "disabled");

                var AuthTimer = new $ComTimer()
                AuthTimer.comSecond = 180;
                AuthTimer.fnCallback = function(){alert("다시인증을 시도해주세요.")}
                AuthTimer.timer =  setInterval(function(){AuthTimer.fnTimer()},1000);
                AuthTimer.domId = document.getElementById("timer");
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    // $("#smsConfirm").click(function () {
    $(document).on('click', "#smsConfirm", function () {
        console.log("aaaaa");
        var user_id = '<?=$user->id?>';

        if ($("#smsCode").val() == "") {
            $("#smsCodeNoti").html("인증번호를 입력해 주세요.");
            $("#smsCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/confirm-sms/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#smsCode").val(),
                user_id: user_id,
                hp: $("#cellNumber").val()+$("#cellNumber2").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                // $('#hp-row').load(location.href+" #hp-row");
                $('#smsModal').modal('hide');
            } else if (data.status == 'fail') {
                alert("인증번호를 다시 확인해주세요.");
                $("#smsCode").val("");
            } else {
                alert("시간이 초과되었습니다. 재발송 해주세요.");
                $("#smsCode").val("");
            }
        });
    });

    function $ComTimer(){
    //prototype extend
    }

    $ComTimer.prototype = {
        comSecond : ""
        , fnCallback : function(){}
        , timer : ""
        , domId : ""
        , fnTimer : function(){
            var m = Math.floor(this.comSecond / 60) + "분 " + (this.comSecond % 60) + "초";	// 남은 시간 계산
            this.comSecond--;					// 1초씩 감소
            this.domId.innerText = m;
            if (this.comSecond < 0) {			// 시간이 종료 되었으면..
                clearInterval(this.timer);		// 타이머 해제
                alert("인증시간이 초과하였습니다. 다시 인증해주시기 바랍니다.")
            }
        }
        ,fnStop : function(){
            clearInterval(this.timer);
        }
    }

    $(function() {
        var dropZone = $('#dropZone');
        
        dropZone.on('dragenter', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#E3F2FC');
        });

        dropZone.on('dragleave', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#FFFFFF');
        });
        
        dropZone.on('dragover', function(e) {
            e.stopPropagation();
            e.preventDefault();
            dropZone.css('background-color', '#E3F2FC');
        });

        dropZone.on('drop', function(e) {
            e.preventDefault();
            dropZone.css('background-color', '#FFFFFF');

            var img = e.originalEvent.dataTransfer.files;

            if (img.length == 1) {
                var formData = new FormData();
                formData.append('imgSaveButton', img[0]);

                $.ajax({
                    url: '/users/img-update/<?= $user->id ?>',
                    processData: false,
                    contentType: false,
                    cache: false,
                    method: 'POST',
                    data: formData,
                }).done(function(data) {
                    if (data.status == 'success') {
                        $('#image-row').load(location.href+" #image-row");
                    } else {
                        alert("실패하였습니다.");
                    }
                });
            } else {
                alert('업로드 불가입니다.');
            }
        });
    });

    $(document).on('change', '#imgSaveButton', function() {
        var existence = '<?= $user->image_name ?>';

        if (existence != null) {
            $.ajax({
                url: '/users/img-delete/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
            });
        }

        var img = document.getElementById('imgSaveButton').files;

        if (img.length == 1) {
            var formData = new FormData();
            formData.append('imgSaveButton', img[0]);

            $.ajax({
                url: '/users/img-update/<?= $user->id ?>',
                processData: false,
                contentType: false,
                cache: false,
                method: 'POST',
                data: formData,
            }).done(function(data) {
                if (data.status == 'success') {
                    $('#image-row').load(location.href+" #image-row");
                } else {
                    alert("실패하였습니다.");
                }
            });
        } else {
            alert("취소하였습니다.");
        }
    });

    $(document).on('click', '#imgDeleteButton', function() {
        var id = <?= $user->id ?>;
        
        if (confirm("사진을 삭제하시겠습니까?")) {
            $.ajax({
                url: '/users/img-delete/<?= $user->id ?>',
                method: 'POST',
                type: 'json',
            }).done(function(data) {
                if (data.status == 'success') {
                    $('#image-row').load(location.href+" #image-row");
                } else {
                    alert("실패하였습니다.");
                }
            });
        } else {
            alert("취소되었습니다.");
        }
    });

    $(document).ready(function() {
        var dt = new Date();
        var com_year = dt.getFullYear();

        for (var y=(com_year-100); y<=(com_year); y++) {
            if (y == <?= date("Y", strtotime($user->birthday)) ?>) {
                $('#yy').append('<option value='+y+' selected="selected">'+y+'</option>');
            } else {
                $('#yy').append('<option value='+y+'>'+y+'</option>');
            }
        }

        for (var m=1; m<=12; m++) {
            if (m == <?= date("m", strtotime($user->birthday)) ?>) {
                $('#mm').append('<option value='+m+' selected="selected">'+m+'</option>');
            } else {
                $('#mm').append('<option value='+m+'>'+m+'</option>');
            }
        }

        for (var d=1; d<=31; d++) {
            if (d == <?= date("d", strtotime($user->birthday)) ?>) {
                $('#dd').append('<option value='+d+' selected="selected">'+d+'</option>');
            } else {
                $('#dd').append('<option value='+d+'>'+d+'</option>');
            }
        }
    });
    
    $('#saveButton').on('click', function() {
        var getName = RegExp(/^[가-힣]+$/);
        var getHp = RegExp(/^[0-9]*$/);

        if ($('#password').val().length < 8) {
            $('#lengthNoti').html("비밀번호는 8자 이상으로 입력해 주세요.");
            $('#password').focus();
            return false;
        } else {
            $('#lengthNoti').html('');
        }
        
        if ($('#password').val() != $('#passwordRe').val()) {
            $('#ReNoti').html('비밀번호가 다릅니다.\n다시 입력해 주세요.');
            $('#passwordRe').focus();
            return false;
        } else {
            $('#ReNoti').html('');
        }

        if ($('#name').val() == '') {
            $('#nameNoti').html('이름을 입력해 주세요.');
            $('#name').focus();
            return false;
        } else {
            $('#nameNoti').html('');
        }

        if ($('#cellNumber2').val().length < 4) {
            $('#hpNoti').html('전화번호를 다시 한번 확인해 주세요.');
            $('#cellNumber').focus();
            return false;
        } else {
            $('#hpNoti').html('');
        }

        if (!getHp.test($('#cellNumber2').val())) {
            $('#hpNoti').html('전화번호를 다시 한번 확인해 주세요.');
            $('#cellNumber').focus();
            return false;
        } else {
            $('#hpNoti').html('');
        }

        $.ajax({
            url: '/users/edit/<?= $user->id ?>',
            method: 'POST',
            type: 'json',
            data: {
                password: $('#password').val(),
                name: $('#name').val(),
                hp: $("#cellNumber").val()+$("#cellNumber2").val(),
                birthday: $('#yy').val() + "-" + $('#mm').val() + "-" + $('#dd').val(),
                sex: $('#gender').val(),
                company: $('#company').val(),
                title: $('#title').val(),
            }
        }).done(function (data) {
            if (data.status == 'success') {
                alert("저장되었습니다.");
                location.replace('https://exon.live/');
            } else {
                alert("성공되지 않았습니다.");
            }
        });
    });

    //연동 확인 및 알림
    $(document).ready(function () {
        var msg = "<?=$msg?>";
        var refer = "<?=$user->refer?>";

        if (msg != '') {
            alert(msg);
        }

        if (refer == 'naver') {
            $("#naver-connect").prop("checked", "checked");
            $("#naver-connect").prop("disabled", "disabled");
            $("#kakao-connect").prop("disabled", "disabled");
        }

        if (refer == 'kakao') {
            $("#kakao-connect").prop("checked", "checked");
            $("#naver-connect").prop("disabled", "disabled");
            $("#kakao-connect").prop("disabled", "disabled");
        }
    });

    //네이버 연동
    $("#naver-connect").click(function () {
        <?php $this->request->getSession()->write('user_id', $user->id) ?>

        var url = "<?=$naver_apiURL?>";
        window.location.replace(url);
    });

    //카카오 연동
    $("#kakao-connect").click(function () {
        <?php $this->request->getSession()->write('user_id', $user->id) ?>

        var url = "<?=$kakao_apiURL?>";
        window.location.replace(url);
    });
</script>