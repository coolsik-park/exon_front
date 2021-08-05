<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Coupon $coupon
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Coupon'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="coupon form content">
            <?= $this->Form->create($coupon) ?>
            <fieldset>
                <legend><?= __('Add Coupon') ?></legend>
                <?php
                    echo $this->Form->control('users_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('product_type');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('sdate');
                    echo $this->Form->control('edate');
                    echo $this->Form->control('status');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
