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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'notice_delete', $board->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $board->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Notice'), ['action' => 'notice'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($board) ?>
            <fieldset>
                <legend><?= __('Edit Notice') ?></legend>
                <?php
                    echo $this->Form->control('title');
                    echo $this->Form->control('content');
                    echo $this->Form->control('status');
                    echo $this->Form->control('file_name', ['type'=>'file']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
