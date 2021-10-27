<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<div id="container">

    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log-step-00">  
                <h2>행사 신청 내역 비로그인 조회</h2>
                <div class="tit">                   
                    <h3 class="t1">고객님은 비로그인 이용자입니다.</h3>
                    <p class="t2">행사 신청 내역을 조회하기 위한 본인인증이 필요합니다.<br>
                    행사 신청 때 입력했던 정보로 인증해주세요.</p>
                </div>                
                <div class="auth-wp">
                    <span class="chk-dsg"><input type="radio" id="authEmail" name="auth"><label for="authEmail">이메일 인증</label></span>
                    <span class="chk-dsg"><input type="radio" id="authCell" name="auth"><label for="authCell">휴대전화 인증</label></span>
                </div> 
                <div id="buttonDiv" class="btn-btm">
                    <button type="button" id="certificationButton" class="btn-big" data-toggle="modal" data-target="" data-backdrop="static" data-keyboard="false">인증하기</button>
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
                                        <input id="email" type="text" placeholder="이메일">
                                        <button id="emailSend" type="button" class="btn-ty2 btn-m-bor">인증메일 발송</button>
                                    </div>
                                    <p id="emailNoti" class="noti hc1"></p>
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
            </div>
        </div>
    </div>    

</div>

<script>
    //라디오 버튼 컨트롤
    $(document).on("change", "input[name='auth']", function () {
        if ($(this).attr("id") == 'authEmail') {
            $("#certificationButton").attr("data-target", "#emailModal");
        } else {
            $("#certificationButton").attr("data-target", "#smsModal");
        }
    });

    //이메일
    var last_id = 0;

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
            url: "/exhibition-users/send-email-certification", 
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
            url: "/exhibition-users/send-email-certification", 
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

        if ($("#emailCode").val() == "") {
            $("#emailCodeNoti").html("인증번호를 입력해 주세요.");
            $("#emailCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/exhibition-users/confirm-email/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#emailCode").val(),
                email: $("#email").val()
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                var email = $("#email").val();
                window.location.replace("/exhibition-users/sign-up/application");
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

    $(document).on("change", "#sms", function () {
        $("#smsNoti").html("");
    });

    $(document).on("change", "#smsCode", function () {
        $("#smsCodeNoti").html("");
    });

    $("#smsSend").click(function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("전화번호를 입력해 주세요.");
            $("#sms").focus();
            return false;
        }

        jQuery.ajax({
            url: "/exhibition-users/send-sms-certification", 
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

    $("#smsResend").click(function () {
        if ($("#sms").val() == "") {
            $("#smsNoti").html("전화번호를 입력해 주세요.");
            $("#sms").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/exhibition-users/send-sms-certification", 
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

    $("#smsConfirm").click(function () {

        if ($("#smsCode").val() == "") {
            $("#smsNoti").html("인증번호를 입력해 주세요.");
            $("#smsCode").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/exhibition-users/confirm-sms/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#smsCode").val(),
                hp: $("#sms").val()
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                var hp = $("#sms").val();
                window.location.replace("/exhibition-users/sign-up/application");
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
            console.log(m);
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
</script>