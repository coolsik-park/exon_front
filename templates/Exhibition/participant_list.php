<div class="row">
    <aside class="column">
        <div class="side-nav">
            
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?php if (count($exhibitionUsers) > 0 ) { ?>
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
            <?php 
                } else { 
                    echo('신청자가 아직 없습니다.'); 
                } 
            ?>
        </div>
    </div>
</div>