<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user, ['enctype'=>'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('회원정보수정') ?></legend>
                <b>기본정보</b>
                <?php
                    echo $this->Form->control('email', ['label' => '*이메일', 'readonly' => 'readonly']);
                    echo $this->Form->control('password', ['label' => '*비밀번호']);
                    echo $this->Form->control('password_check', ['label' => '*비밀번호 확인', 'type' => 'password']);
                    echo $this->Form->control('name', ['label' => '*이름']);
                    echo $this->Form->control('hp', ['label' => '휴대전화 번호', 'type' => 'tel']);
                    if ($user->hp_cert == 0) {
                        echo $this->Form->button('번호인증');
                    } else {
                        echo $this->Form->button('번호변경');
                    }
                ?>
                <br><b>부가정보</b><br>
                <?php
                    echo $this->Form->button('kakao 연동');
                    echo $this->Form->button('NAVER 연동');
                    echo $this->Form->control('user.image_name', ['type' => 'file', 'label' => '프로필']);
                    if ($user->image_name != null) {
                        echo $this->Form->button('삭제');
                    }
                    echo $this->Form->control('birthday', ['label' => '생년월일', 'dateFormat' => 'YMD']);
                    echo $this->Form->control('sex', ['label' => '성별', 'options' => ['M' => '남자', 'F' => '여자']]);
                    echo $this->Form->control('company', ['label' => '소속']);
                    echo $this->Form->control('title', ['label' => '직함']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('취소'), ['action' => 'index']) ?>
            <?= $this->Form->button(__('저장'), ['id' => 'save', 'name' => 'save']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    $('button[name=save]').on('click', function() {
        var password = $('input[name=password]').val();
        var password_check = $('input[name=password_check]').val();
        if (password != password_check) {
            alert('비밀번호가 틀립니다.');
        }
    });
</script>
