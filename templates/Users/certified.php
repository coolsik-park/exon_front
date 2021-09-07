<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
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
</div>
<script>
    $('button[name=hpButton]').on('click', function() {
        window.open('http://121.126.223.225:8000/Users/sendSmsCertified', '휴대전화 인증', '');
    });
</script>