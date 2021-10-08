<style>
    #header, footer {
        display: none!important;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="../common/css/style.css">
    <script src="../common/js/jquery-3.2.1.min.js"></script>
    <script src="../common/js/slick.js"></script>
    <script src="../common/js/swiper.min.js"></script>
    <script src="../common/js/mobile-detect.min.js"></script>
    <script src="../common/js/responsiveImg.js"></script>   
    <script src="../common/js/common.js"></script>
    <title>EXON</title>
</head>
<body>
    
 <div class="modal-pop-wrap">
    <div class="popup-wrap">
        <div class="popup-head">
            <h1>휴대폰 인증</h1>
            <button id="close" type="button" class="popup-close">팝업닫기</button>
        </div>
        <div class="popup-body">
            <div class="cert-sect1">
                <input id="hp" type="text" placeholder="전화번호">
                <p id="hpNoti" class="noti hc1"></p>
                <button id="send" type="button" class="btn-ty2 btn-m-bor">인증문자 발송</button>
            </div>        
            <div class="cert-sect2">
                <div class="label-wp">
                    <label for="cert1-1">인증번호</label><input type="text" id="cert1-1" placeholder="인증번호">
                    <p id="codeNoti" class="noti hc1"></p>
                </div> 
                <button id="reSend" type="button" class="btn-ty2 gray">재발송</button>
            </div>
            <div class="popup-btm alone">
                <button id="confirm" type="button" class="btn-ty2">확인</button>
            </div>        
        </div>
     </div>  
 </div>   
</body>

<script> 
    var last_id = 0;
    $("#close").click(function () {
        window.close();
    });

    $("#send").click(function () {
        if ($("#hp").val() == "") {
            $("#hpNoti").html("전화번호를 입력해 주세요.");
            $("#hp").focus();
            return false;
        }

        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#hp").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;
                $("#send").html("<span id='timer'></span>");
                $("#send").attr("disabled", "dusabled");

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
        if ($("#hp").val() == "") {
            $("#hpNoti").html("전화번호를 입력해 주세요.");
            $("#hp").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/send-sms-certification", 
            method: 'POST',
            type: 'json',
            data: {
                hp: $("#hp").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증번호를 발송하였습니다.");
                last_id = data.id;

                $("#send").html("<span id='timer'></span>");
                $("#send").attr("disabled", "dusabled");

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

    $("#confirm").click(function () {
        var user_id = '<?=$user_id?>';

        if ($("#cert1-1").val() == "") {
            $("#codeNoti").html("인증번호를 입력해 주세요.");
            $("#cert1-1").focus();
            return false;
        }
        
        jQuery.ajax({
            url: "/users/confirm-sms/" + last_id, 
            method: 'POST',
            type: 'json',
            data: {
                code: $("#cert1-1").val(),
                user_id: user_id,
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("인증이 완료되었습니다.");
                window.close();
            } else if (data.status == 'fail') {
                alert("인증번호를 다시 확인해주세요.");
                $("#cert1-1").val();
            } else {
                alert("시간이 초과되었습니다. 재발송 해주세요.");
                $("#cert1-1").val();
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