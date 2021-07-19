<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionGroup $exhibitionGroup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibitionGroup->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionGroup->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition Group'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionGroup form content">
            <?= $this->Form->create($exhibitionGroup) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition Group') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_id', ['options' => $exhibition]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('people');
                    echo $this->Form->control('amount');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
