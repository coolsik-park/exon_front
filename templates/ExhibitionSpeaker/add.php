<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSpeaker $exhibitionSpeaker
 * @var \Cake\Collection\CollectionInterface|string[] $exhibition
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Speaker'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionSpeaker form content">
            <?= $this->Form->create($exhibitionSpeaker) ?>
            <fieldset>
                <legend><?= __('Add Exhibition Speaker') ?></legend>
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
