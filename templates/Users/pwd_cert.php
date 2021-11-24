<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">
    
    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log-step-00">  
                <h2>비밀번호 찾기</h2>
                <div class="tit">                   
                    <h3 class="t1">본인확인 방법 선택</h3>
                    <p class="t2">본인확인을 할 방법을 선택해 주세요.</p>
                </div>                
                <div class="auth-wp">
                    <span class="chk-dsg"><input type="radio" id="authEmail" name="auth"><label id="authEmailLabel" for="authEmail">이메일 인증</label></span>
                    <span class="chk-dsg"><input type="radio" id="authCell" name="auth"><label id="authCellLabel" for="authCell">휴대전화 인증</label></span>
                </div> 
                <div id="buttonDiv" class="btn-btm">
                    <button type="button" id="certificationButton" class="btn-big" data-toggle="modal" data-target="" data-backdrop="static" data-keyboard="false">인증번호 발송</button>
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
                                    <div class="cert-sect2">
                                        <div class="label-wp">
                                            <label for="emailCode">인증번호</label><input type="text" id="emailCode" placeholder="인증번호">
                                        </div> 
                                        <button id="emailResend" type="button" class="btn-ty2 gray">재발송</button>
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
                <div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="background-color:transparent; border:none;">
                            <div class="popup-wrap">
                                <div class="popup-head">
                                    <h4>휴대전화 인증</h4>
                                    <button id="close" type="button" class="popup-close close" data-dismiss="modal" aria-label="Close">팝업닫기</button>
                                </div>
                                <div class="popup-body"> 
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
            </div>
        </div>
    </div>    

</div>

<script>
    //모달 팝업 창 닫기 시
    $("#close").click(function () {
        window.location.reload();
    });

    //라디오 버튼 컨트롤
    var cert = "<?=$cert?>";
    if (cert == 1) {
        $("#authCell").attr("disabled", true);
        $("#authCellLabel").css("color", "gray");
    } else if (cert == 2) {
        $("#authEmail").attr("disabled", true);
        $("#authEmailLabel").css("color", "gray");
    }
    $(document).on("change", "input[name='auth']", function () {
        if ($(this).attr("id") == 'authEmail') {
            $("#certificationButton").attr("data-target", "#emailModal");
        } else {
            $("#certificationButton").attr("data-target", "#smsModal");
        }
    });

    //발송버튼
    $(document).on("click", "#certificationButton", function () {
        if ($(this).attr("data-target") == "#emailModal") {
            jQuery.ajax({
                url: "/users/pwd-email-certification/<?=$users_id?>", 
                method: 'POST',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("인증번호를 발송하였습니다.");
                    last_id = data.id;
                } else {
                    alert("오류가 발생하였습니다. 다시 시도해 주세요.");
                }
            });
        } else {
            jQuery.ajax({
                url: "/users/pwd-sms-certification/<?=$users_id?>", 
                method: 'POST',
            }).done(function(data) {
                if (data.status == 'success') {
                    alert("인증번호를 발송하였습니다.");
                    last_id = data.id;
                } else {
                    alert("오류가 발생하였습니다. 다시 시도해 주세요.");
                }
            });
        }
    });

    //이메일
    var last_id = 0;

    $(document).on("change", "#emailCode", function () {
        $("#emailCodeNoti").html("");
    });

    $("#emailResend").click(function () {
        jQuery.ajax({
            url: "/users/pwd-email-certification/<?=$users_id?>", 
            method: 'POST',
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    $("#emailConfirm").click(function () {

        if ($("#emailCode").val() == "") {
            $("#emailCodeNoti").html("인증번호를 입력해 주세요.");
            $("#emailCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/pwd-confirm/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#emailCode").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                window.location.replace("/users/reset-password/<?=$users_id?>");
            } else if (data.status == 'fail') {
                alert("인증번호를 다시 확인해주세요.");
                $("#emailCode").val("");
            } else {
                alert("시간이 초과되었습니다. 재발송 해주세요.");
                $("#emailCode").val("");
            }
        });
    });

    //sms
    last_id = 0;

    $(document).on("change", "#smsCode", function () {
        $("#smsCodeNoti").html("");
    });

    $("#smsResend").click(function () {
        jQuery.ajax({
            url: "/users/pwd-sms-certification/<?=$users_id?>", 
            method: 'POST',
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;
            } else {
                alert("오류가 발생하였습니다. 다시 시도해 주세요.");
            }
        });
    });

    $("#smsConfirm").click(function () {

        if ($("#smsCode").val() == "") {
            $("#smsNoti").html("인증번호를 입력해 주세요.");
            $("#smsCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/pwd-confirm/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#smsCode").val(),
                hp: $("#sms").val()
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                window.location.replace("/users/reset-password/<?=$users_id?>");
            } else if (data.status == 'fail') {
                alert("인증번호를 다시 확인해주세요.");
                $("#smsCode").val("");
            } else {
                alert("시간이 초과되었습니다. 재발송 해주세요.");
                $("#smsCode").val("");
            }
        });
    });
</script>