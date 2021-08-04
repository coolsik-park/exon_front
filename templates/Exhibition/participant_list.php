<div class="row">
    <aside class="column">
        <div class="side-nav">
            
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibitionUsers)?>
            <fieldset>
                <legend><?= __('Participant List') ?></legend>
                <?php
                    if (count($exhibitionUsers) > 0) {
                        echo $this->Form->select('data', $exhibitionUsers, ['multiple' => 'checkbox']);
                    }
                ?>
            </fieldset>
            <?= $this->Form->button('Confirm') ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>