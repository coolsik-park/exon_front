<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser $exhibitionUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibitionUser->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionUser->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create($exhibitionUser) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition User') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_id', ['options' => $exhibition]);
                    echo $this->Form->control('exhibition_group_id', ['options' => $exhibitionGroup]);
                    echo $this->Form->control('users_id');
                    echo $this->Form->control('users_email');
                    echo $this->Form->control('users_name');
                    echo $this->Form->control('users_hp');
                    echo $this->Form->control('users_group');
                    echo $this->Form->control('users_sex');
                    echo $this->Form->control('pay_id', ['options' => $pay, 'empty' => true]);
                    echo $this->Form->control('pay_amount');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
