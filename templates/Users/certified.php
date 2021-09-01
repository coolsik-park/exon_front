<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.8.js"></script>
<div class="users form content">
    <h1><?= h($user[0]->name) ?>회원가입이 완료되었습니다.</h1>
    <h3>축하드립니다. 이제부터 EXON 서비스를 자유롭게 즐기실 수 있습니다.</h3>
    <?php echo $this->Form->button(__('가입완료')) ?>
    <fieldset>
        <legend><?= __('본인인증') ?></legend>
        <?php echo $this->Form->button(__('이메일 인증')) ?>
        <?php echo $this->Form->button(__('휴대전화 인증'), ['id' => 'hpCertified', 'name' => 'hpCertified']) ?><br>
        <?php echo '본인증이 완료되면 편리하게 웨비나를 즐기실 수 있습니다.' ?>
    </fieldset>
</div>  
<script>
    $('button[name=hpCertified]').on('click', function(){
        var IMP = window.IMP;
        IMP.init('iamport');

        IMP.certification({
            merchant_uid : 'merchant_' + new Date().getTime()
        }, function(rsp) {
            if (rsp.success) {
                console.log(rsp.imp_uid);
                console.log(rsp.merchant_uid);

                $.ajax({
                    type : 'POST',
                    url : 'http://121.126.223.225:8000/users/hp-certified',
                    dataType : 'json',
                    data : {
                        imp_uid : rsp.imp_uid,
                        id : <?php echo $user[0]->id ?>,
                        // hp_cert : '1'
                    }
                }).done(function(rsp) {
                    takeResponseAndHandle(rsp)
                });

                // $.ajax({
                //     type : 'POST',
                //     url : 'http://121.126.223.225:8000/users/hp-certified',
                //     dataType : 'json',
                //     data : {
                //         id : <?php echo $user[0]->id ?>,
                //         hp_cert : '1'
                //     }
                // });
            } else {
                var msg = '인증에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
                alert(msg);
            }
        })

        function takeResponseAndHandle(rsp) {
            if(rsp.success) {
                console.log(rsp.imp_uid);
                console.log(rsp.merchant_uid);
            } else {
                var msg = '인증에 실패하였습니다.';
                msg += '에러 내용 : ' + rsp.error_msg;
                alert(msg);
            }
        }
    });
</script>