<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibition->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibition) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition') ?></legend>
                <?php
                    echo $this->Form->control('users_id');
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category');
                    echo $this->Form->control('type');
                    echo $this->Form->control('detail_html');
                    echo $this->Form->control('apply_sdate', ['empty' => true]);
                    echo $this->Form->control('apply_edate', ['empty' => true]);
                    echo $this->Form->control('sdate', ['empty' => true]);
                    echo $this->Form->control('edate', ['empty' => true]);
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('image_name');
                    echo $this->Form->control('private');
                    echo $this->Form->control('auto_approval');
                    echo $this->Form->control('name');
                    echo $this->Form->control('tel');
                    echo $this->Form->control('email');
                    echo $this->Form->control('require_name');
                    echo $this->Form->control('require_email');
                    echo $this->Form->control('require_tel');
                    echo $this->Form->control('require_age');
                    echo $this->Form->control('require_group');
                    echo $this->Form->control('require_sex');
                    echo $this->Form->control('require_cert');
                    echo $this->Form->control('email_notice');
                    echo $this->Form->control('additional');
                    echo $this->Form->control('status');
                    echo $this->Form->control('users._ids', ['options' => $users]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>