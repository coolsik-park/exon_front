<div class="row">
    <aside class="column">
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('휴대전화 인증') ?></legend>
                <?php
                    echo $this->Form->control('hp', ['label' => '전화번호']);
                    echo $this->Form->button(__('인증번호 발송'));
                ?>
            </fieldset>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>