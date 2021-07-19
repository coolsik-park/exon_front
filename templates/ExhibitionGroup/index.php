<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionGroup[]|\Cake\Collection\CollectionInterface $exhibitionGroup
 */
?>
<div class="exhibitionGroup index content">
    <?= $this->Html->link(__('New Exhibition Group'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition Group') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('people') ?></th>
                    <th><?= $this->Paginator->sort('amount') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibitionGroup as $exhibitionGroup): ?>
                <tr>
                    <td><?= $this->Number->format($exhibitionGroup->id) ?></td>
                    <td><?= $exhibitionGroup->has('exhibition') ? $this->Html->link($exhibitionGroup->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionGroup->exhibition->id]) : '' ?></td>
                    <td><?= h($exhibitionGroup->name) ?></td>
                    <td><?= $this->Number->format($exhibitionGroup->people) ?></td>
                    <td><?= $this->Number->format($exhibitionGroup->amount) ?></td>
                    <td><?= h($exhibitionGroup->created) ?></td>
                    <td><?= h($exhibitionGroup->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibitionGroup->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibitionGroup->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibitionGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionGroup->id)]) ?>
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
