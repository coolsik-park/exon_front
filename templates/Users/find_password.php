<div id="container">
    <div class="log-wrap">
        <div class="log-step-wrap">
            <h1><a href="/" class="h-logo">EXON</a></h1>
            <div class="log-step-page log log-step-03">
                <h2 class="h-ty2 fir">비밀번호 찾기</h2>
                <div class="mbr-form">
                    <div class="item-row">
                        <div class="col-dt">이메일</div>
                        <div class="col-dd">
                            <input type="text" id="email" name="email" class="full" label="" title="이메일">
                        </div>
                    </div>
                </div>
                <div class="btn-btm">
                    <a id="next" class="btn-big" style="cursor:pointer; color:#fff;">다음</a>
                </div>
                <div class="div-or"></div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#next", function () {
        jQuery.ajax({
            url: "/users/find-user", 
            method: 'POST',
            type: 'json',
            data: {
                email: $("#email").val(),
            }
        }).done(function(data) {
            if (data.status == 'exist') {
                window.location.replace("/users/pwd-cert/" + data.users_id + "/" + data.cert);
            } else {
                alert("존재하지 않는 이메일 주소입니다.\n이메일 주소를 확인해주세요.");
            }
        });
    });
</script>