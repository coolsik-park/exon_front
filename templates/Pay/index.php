<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pay[]|\Cake\Collection\CollectionInterface $pay
 */
?>
<div class="pay index content">
    <?= $this->Html->link(__('New Pay'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Pay') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_type') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('merchant_uid') ?></th>
                    <th><?= $this->Paginator->sort('pg_tid') ?></th>
                    <th><?= $this->Paginator->sort('pay_method') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('pay_amount') ?></th>
                    <th><?= $this->Paginator->sort('coupon_amount') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('receipt_url') ?></th>
                    <th><?= $this->Paginator->sort('pay_date') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('cancel_amount') ?></th>
                    <th><?= $this->Paginator->sort('cancel_date') ?></th>
                    <th><?= $this->Paginator->sort('cancel_reason') ?></th>
                    <th><?= $this->Paginator->sort('fail_date') ?></th>
                    <th><?= $this->Paginator->sort('fail_reason') ?></th>
                    <th><?= $this->Paginator->sort('managers_id') ?></th>
                    <th><?= $this->Paginator->sort('manager_ip') ?></th>
                    <th><?= $this->Paginator->sort('imp_uid') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pay as $pay): ?>
                <tr>
                    <td><?= $this->Number->format($pay->id) ?></td>
                    <td><?= h($pay->product_type) ?></td>
                    <td><?= $pay->has('user') ? $this->Html->link($pay->user->name, ['controller' => 'Users', 'action' => 'view', $pay->user->id]) : '' ?></td>
                    <td><?= h($pay->merchant_uid) ?></td>
                    <td><?= h($pay->pg_tid) ?></td>
                    <td><?= h($pay->pay_method) ?></td>
                    <td><?= $this->Number->format($pay->amount) ?></td>
                    <td><?= $this->Number->format($pay->pay_amount) ?></td>
                    <td><?= $this->Number->format($pay->coupon_amount) ?></td>
                    <td><?= $this->Number->format($pay->status) ?></td>
                    <td><?= h($pay->receipt_url) ?></td>
                    <td><?= h($pay->pay_date) ?></td>
                    <td><?= h($pay->ip) ?></td>
                    <td><?= h($pay->created) ?></td>
                    <td><?= h($pay->modified) ?></td>
                    <td><?= $this->Number->format($pay->cancel_amount) ?></td>
                    <td><?= h($pay->cancel_date) ?></td>
                    <td><?= h($pay->cancel_reason) ?></td>
                    <td><?= h($pay->fail_date) ?></td>
                    <td><?= h($pay->fail_reason) ?></td>
                    <td><?= $pay->has('manager') ? $this->Html->link($pay->manager->name, ['controller' => 'Managers', 'action' => 'view', $pay->manager->id]) : '' ?></td>
                    <td><?= h($pay->manager_ip) ?></td>
                    <td><?= h($pay->imp_uid) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $pay->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $pay->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $pay->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pay->id)]) ?>
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
