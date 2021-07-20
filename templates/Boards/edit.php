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
                ['action' => 'delete', $board->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $board->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List UseQuestion'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($board) ?>
            <fieldset>
                <legend><?= __('Edit UseQuestion') ?></legend>
                <?php
                    echo $this->Form->control('faq_category_id');
                    echo $this->Form->control('title');
                    echo $this->Form->control('users_name');
                    echo $this->Form->control('users_hp');
                    echo $this->Form->control('users_email');
                    echo $this->Form->control('question');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
