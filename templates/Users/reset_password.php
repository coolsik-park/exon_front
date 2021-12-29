<div id="container">
    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log log-step-03">
                <h2 class="h-ty2 fir">비밀번호 재설정</h2>
                <div class="mbr-form">
                    <div class="item-row">
                        <div class="col-dt">비밀번호</div>
                        <div class="col-dd">
                            <input type="password" id="pwd" name="pwd" class="full" label="" title="비밀번호" placeholder="최소 8자 이상">
                        </div>
                    </div>
                    <div class="item-row">
                        <div class="col-dt">비밀번호 확인</div>
                        <div class="col-dd">
                            <input type="password" id="pwd_confirm" name="pwd_confirm" class="full" label="" title="비밀번호 확인" placeholder="최소 8자 이상">
                        </div>
                    </div>
                </div>
                <div class="btn-btm">
                    <a id="change" class="btn-big" style="cursor:pointer; color:#fff;">변경</a>
                </div>
                <div class="div-or"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#change", function () {
        if ($("#pwd").val().length < 8) {
            alert("비밀번호는 8자 이상으로 입력해 주세요.");
            $("#pwd").val("");
            $("#pwd").focus();
            return false
        }
        
        if ($("#pwd").val() != $("#pwd_confirm").val()) {
            alert("비밀번호를 다시 확인해 주세요.");
            $("#pwd_confirm").val("");
            $("#pwd_confirm").focus();
            return false
        }
        jQuery.ajax({
            url: "/users/reset-password/<?=$users_id?>", 
            method: 'POST',
            type: 'json',
            data: {
                pwd: $("#pwd").val(),
            }
        }).done(function(data) {
            if (data.status == 'success') {
                alert("비밀번호가 재설정되었습니다.\n새로운 비밀번호로 EXON 서비스를 이용해 주세요.");
                window.location.replace("/users/login");
            } else {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해 주세요.");
            }
        });
    });
</script>