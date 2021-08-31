<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSpeaker[]|\Cake\Collection\CollectionInterface $exhibitionSpeaker
 */
?>
<div class="exhibitionSpeaker index content">
    <?= $this->Html->link(__('New Exhibition Speaker'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition Speaker') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('image_name') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibitionSpeaker as $exhibitionSpeaker): ?>
                <tr>
                    <td><?= $this->Number->format($exhibitionSpeaker->id) ?></td>
                    <td><?= $exhibitionSpeaker->has('exhibition') ? $this->Html->link($exhibitionSpeaker->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionSpeaker->exhibition->id]) : '' ?></td>
                    <td><?= h($exhibitionSpeaker->name) ?></td>
                    <td><?= h($exhibitionSpeaker->image_path) ?></td>
                    <td><?= h($exhibitionSpeaker->image_name) ?></td>
                    <td><?= h($exhibitionSpeaker->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibitionSpeaker->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibitionSpeaker->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibitionSpeaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSpeaker->id)]) ?>
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
