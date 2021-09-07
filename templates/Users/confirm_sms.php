<div class="row">
    <aside class="column">
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Send SMS') ?></legend>
                <?php
                    echo $this->Form->control('code');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit', ['controller' => 'Users', 'action' => 'confirmSms'])) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
