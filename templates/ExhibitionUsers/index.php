<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser[]|\Cake\Collection\CollectionInterface $exhibitionUsers
 */
?>
<div class="exhibitionUsers index content">
    <?= $this->Html->link(__('New Exhibition User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_group_id') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('users_email') ?></th>
                    <th><?= $this->Paginator->sort('users_name') ?></th>
                    <th><?= $this->Paginator->sort('users_hp') ?></th>
                    <th><?= $this->Paginator->sort('users_group') ?></th>
                    <th><?= $this->Paginator->sort('users_sex') ?></th>
                    <th><?= $this->Paginator->sort('pay_id') ?></th>
                    <th><?= $this->Paginator->sort('pay_amount') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibitionUsers as $exhibitionUser): ?>
                <tr>
                    <td><?= $this->Number->format($exhibitionUser->id) ?></td>
                    <td><?= $exhibitionUser->has('exhibition') ? $this->Html->link($exhibitionUser->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionUser->exhibition->id]) : '' ?></td>
                    <td><?= $exhibitionUser->has('exhibition_group') ? $this->Html->link($exhibitionUser->exhibition_group->name, ['controller' => 'ExhibitionGroup', 'action' => 'view', $exhibitionUser->exhibition_group->id]) : '' ?></td>
                    <td><?= $this->Number->format($exhibitionUser->users_id) ?></td>
                    <td><?= h($exhibitionUser->users_email) ?></td>
                    <td><?= h($exhibitionUser->users_name) ?></td>
                    <td><?= h($exhibitionUser->users_hp) ?></td>
                    <td><?= h($exhibitionUser->users_group) ?></td>
                    <td><?= h($exhibitionUser->users_sex) ?></td>
                    <td><?= $exhibitionUser->has('pay') ? $this->Html->link($exhibitionUser->pay->id, ['controller' => 'Pay', 'action' => 'view', $exhibitionUser->pay->id]) : '' ?></td>
                    <td><?= $this->Number->format($exhibitionUser->pay_amount) ?></td>
                    <td><?= $this->Number->format($exhibitionUser->status) ?></td>
                    <td><?= h($exhibitionUser->created) ?></td>
                    <td><?= h($exhibitionUser->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibitionUser->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibitionUser->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibitionUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionUser->id)]) ?>
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
