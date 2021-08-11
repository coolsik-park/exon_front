<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pay $pay
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $pay->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $pay->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Pay'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pay form content">
            <?= $this->Form->create($pay) ?>
            <fieldset>
                <legend><?= __('Edit Pay') ?></legend>
                <?php
                    echo $this->Form->control('product_type');
                    echo $this->Form->control('users_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('merchant_uid');
                    echo $this->Form->control('pg_tid');
                    echo $this->Form->control('pay_method');
                    echo $this->Form->control('amount');
                    echo $this->Form->control('pay_amount');
                    echo $this->Form->control('coupon_amount');
                    echo $this->Form->control('status');
                    echo $this->Form->control('receipt_url');
                    echo $this->Form->control('pay_date', ['empty' => true]);
                    echo $this->Form->control('ip');
                    echo $this->Form->control('cancel_amount');
                    echo $this->Form->control('cancel_date', ['empty' => true]);
                    echo $this->Form->control('cancel_reason');
                    echo $this->Form->control('fail_date', ['empty' => true]);
                    echo $this->Form->control('fail_reason');
                    echo $this->Form->control('managers_id', ['options' => $managers, 'empty' => true]);
                    echo $this->Form->control('manager_ip');
                    echo $this->Form->control('imp_uid');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
