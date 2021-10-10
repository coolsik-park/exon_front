<div id="container">
        
    <div class="contents static wb1">
        <h2 class="s-hty1">웨비나 접속 본인인증</h2>            
        <div class="section-webinar1">
            <h3 class="wb-tit">웨비나에 접속하기 위한 본인인증이 필요합니다</h3>
            <div class="cert-chk-wp">
                <span class="chk-dsg"><input type="radio" id="cert1" name="cert"><label for="cert1">이메일 인증</label></span>
                <span class="chk-dsg"><input type="radio" id="cert2" name="cert"><label for="cert2">휴대전화 인증</label></span>
            </div>
            <div class="btn-btm-center">
                <button type="button" id="certify" class="btn-big-cir">인증하기</button>
            </div>
        </div>
    </div>      

</div>

<script>
    $(document).on("click", "#certify", function () {
        if ($("#cert1").prop("checked") == true) {
            var user_id = '<?=$auth_id?>';
            var popup = window.open('/exhibitionStream/sendEmailCertification/'+user_id+'', '이메일 인증', 'width=800px,height=500px,left=800px,top=300px');

            popup.addEventListener('beforeunload', function() {
                window.location.reload();
            });
            
        } else {
            var user_id = '<?=$auth_id?>';
            var popup = window.open('/exhibitionStream/sendSmsCertification/'+user_id+'', '휴대전화 인증', 'width=800px,height=500px,left=800px,top=300px');

            popup.addEventListener('beforeunload', function() {
                window.location.reload();
            });
        }
    });
</script>