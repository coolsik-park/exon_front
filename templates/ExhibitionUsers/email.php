<div class="row">
    <aside class="column">
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Send Email') ?></legend>
                <?php
                    echo $this->Form->control('email_address');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit', ['controller' => 'ExhibitionUsers', 'action' => 'sendEmail'])) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
