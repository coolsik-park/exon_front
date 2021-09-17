<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<div class="row">
    <aside class="column">
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create() ?>
            <h1><?= h($user[0]->name) ?>회원가입이 완료되었습니다.</h1>
            <h3>축하드립니다. 이제부터 EXON 서비스를 자유롭게 즐기실 수 있습니다.</h3>
            <?= $this->Form->button(__('가입완료')) ?>
                <fieldset>
                <legend><?= __('본인인증') ?></legend>
                <?= $this->Form->button(__('이메일 인증')) ?>
                <?= $this->Form->button(__('휴대전화 인증'), ['id' => 'hpButton', 'name' => 'hpButton']) ?><br>
                <?= '본인증이 완료되면 편리하게 웨비나를 즐기실 수 있습니다.' ?>
            </fieldset>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div> -->

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
        window.open('/users/sendSmsCertified', '휴대전화 인증', 'width=500px,height=500px,left=800px,top=300px');
    });
</script>