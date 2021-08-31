<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSpeaker $exhibitionSpeaker
 * @var string[]|\Cake\Collection\CollectionInterface $exhibition
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibitionSpeaker->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSpeaker->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition Speaker'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionSpeaker form content">
            <?= $this->Form->create($exhibitionSpeaker) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition Speaker') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_id', ['options' => $exhibition]);
                    echo $this->Form->control('name');
                    echo $this->Form->control('image_path');
                    echo $this->Form->control('image_name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
