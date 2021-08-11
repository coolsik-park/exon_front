<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream $exhibitionStream
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibitionStream->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStream->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition Stream'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionStream form content">
            <?= $this->Form->create($exhibitionStream) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition Stream') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_id', ['options' => $exhibition]);
                    echo $this->Form->control('pay_id', ['options' => $pay]);
                    echo $this->Form->control('coupon_id', ['options' => $coupon, 'empty' => true]);
                    echo $this->Form->control('stream_key');
                    echo $this->Form->control('time');
                    echo $this->Form->control('people');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('coupon_amount');
                    echo $this->Form->control('url');
                    echo $this->Form->control('ip');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
