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
            <?= $this->Html->link(__('List UserQuestion'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($board, ['enctype'=>'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('Add UserQuestion') ?></legend>
                <?php
                    echo $this->Form->control('faq_category_id', ['options' => $categories]);
                    echo $this->Form->control('title');
                    echo $this->Form->control('users_name');
                    echo $this->Form->control('users_hp');
                    echo $this->Form->control('users_email', ['type' => 'email']);
                    echo $this->Form->control('question');
                    echo $this->Form->control('file_name', ['type'=>'file']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
