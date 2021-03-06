<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Notice'), ['action' => 'notice'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($board, ['enctype'=>'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('Add UserQuestion') ?></legend>
                <?php
                    echo $this->Form->control('board.title');
                    echo $this->Form->control('board.content');
                    echo $this->Form->control('board.status');
                    echo $this->Form->control('file_name', ['type'=>'file']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
