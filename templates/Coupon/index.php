<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Coupon[]|\Cake\Collection\CollectionInterface $coupon
 */
?>
<div class="coupon index content">
    <?= $this->Html->link(__('New Coupon'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Coupon') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('product_type') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('sdate') ?></th>
                    <th><?= $this->Paginator->sort('edate') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($coupon as $coupon): ?>
                <tr>
                    <td><?= $this->Number->format($coupon->id) ?></td>
                    <td><?= $coupon->has('user') ? $this->Html->link($coupon->user->name, ['controller' => 'Users', 'action' => 'view', $coupon->user->id]) : '' ?></td>
                    <td><?= h($coupon->product_type) ?></td>
                    <td><?= h($coupon->code) ?></td>
                    <td><?= $this->Number->format($coupon->amount) ?></td>
                    <td><?= h($coupon->sdate) ?></td>
                    <td><?= h($coupon->edate) ?></td>
                    <td><?= $this->Number->format($coupon->status) ?></td>
                    <td><?= h($coupon->created) ?></td>
                    <td><?= h($coupon->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $coupon->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $coupon->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
