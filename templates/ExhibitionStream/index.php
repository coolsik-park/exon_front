<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream[]|\Cake\Collection\CollectionInterface $exhibitionStream
 */
?>
<div class="exhibitionStream index content">
    <?= $this->Html->link(__('New Exhibition Stream'), ['action' => 'setExhibitionStream'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition Stream') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_id') ?></th>
                    <th><?= $this->Paginator->sort('pay_id') ?></th>
                    <th><?= $this->Paginator->sort('coupon_id') ?></th>
                    <th><?= $this->Paginator->sort('stream_key') ?></th>
                    <th><?= $this->Paginator->sort('time') ?></th>
                    <th><?= $this->Paginator->sort('people') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('coupon_amount') ?></th>
                    <th><?= $this->Paginator->sort('url') ?></th>
                    <th><?= $this->Paginator->sort('ip') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibitionStream as $exhibitionStream): ?>
                <tr>
                    <td><?= $this->Number->format($exhibitionStream->id) ?></td>
                    <td><?= $exhibitionStream->has('exhibition') ? $this->Html->link($exhibitionStream->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionStream->exhibition->id]) : '' ?></td>
                    <td><?= $exhibitionStream->has('pay') ? $this->Html->link($exhibitionStream->pay->id, ['controller' => 'Pay', 'action' => 'view', $exhibitionStream->pay->id]) : '' ?></td>
                    <td><?= $exhibitionStream->has('coupon') ? $this->Html->link($exhibitionStream->coupon->id, ['controller' => 'Coupon', 'action' => 'view', $exhibitionStream->coupon->id]) : '' ?></td>
                    <td><?= h($exhibitionStream->stream_key) ?></td>
                    <td><?= $this->Number->format($exhibitionStream->time) ?></td>
                    <td><?= $this->Number->format($exhibitionStream->people) ?></td>
                    <td><?= $this->Number->format($exhibitionStream->amount) ?></td>
                    <td><?= $this->Number->format($exhibitionStream->coupon_amount) ?></td>
                    <td><?= h($exhibitionStream->url) ?></td>
                    <td><?= h($exhibitionStream->ip) ?></td>
                    <td><?= h($exhibitionStream->created) ?></td>
                    <td><?= h($exhibitionStream->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibitionStream->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibitionStream->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibitionStream->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStream->id)]) ?>
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
