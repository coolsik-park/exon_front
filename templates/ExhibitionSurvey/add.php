<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSurvey $exhibitionSurvey
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Survey'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionSurvey form content">
            <?= $this->Form->create($exhibitionSurvey) ?>
            <fieldset>
                <legend><?= __('Add Exhibition Survey') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_id', ['options' => $exhibition]);
                    echo $this->Form->control('survey_type');
                    echo $this->Form->control('parent_id', ['options' => $parentExhibitionSurvey, 'empty' => true]);
                    echo $this->Form->control('text');
                    echo $this->Form->control('is_duplicate');
                    echo $this->Form->control('is_multiple');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
