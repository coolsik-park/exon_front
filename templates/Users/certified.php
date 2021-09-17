<div id="container">
    <div class="join-ok-wrap static">
        <div class="join-ok-sect1">
            <h3>회원가입이 완료되었습니다</h3>
            <p class="tx1">축하드립니다, 이제부터 EXON 서비스를 자유롭게 즐기실 수 있습니다.</p>
            <a href="/" class="btn-big-cir">가입완료</a>
        </div>
        <div class="join-ok-sect2">
            <div class="js1">
                <h4>본인인증</h4>
                <p class="tx1">본인인증이 완료가 되면 편리하게 웨비나를 즐기실 수 있습니다.</p>
            </div>
            <div class="js2">
                <a href="#" class="btn-md">이메일 인증</a>
                <a id="hpButton" class="btn-md" style="cursor:pointer;">휴대폰 인증</a>
            </div>
        </div>            
    </div>
</div>

<script>
    $('#hpButton').on('click', function() {
        window.open('/users/sendSmsCertified', '휴대전화 인증', 'width=800px,height=500px,left=800px,top=300px');
    });
</script>