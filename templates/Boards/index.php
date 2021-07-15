<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="userquestion index content">
    <?= $this->Html->link(__('New question'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('UserQuestion') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('users_name') ?></th>
                    <th><?= $this->Paginator->sort('users_hp') ?></th>
                    <th><?= $this->Paginator->sort('users_email') ?></th>
                    <th><?= $this->Paginator->sort('question') ?></th>
                    <th><?= $this->Paginator->sort('answer') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boards as $board): ?>
                <tr>
                    <td><?= $this->Number->format($board->id) ?></td>
                    <td><?= h($board->users_id) ?></td>
                    <td><?= h($board->users_name) ?></td>
                    <td><?= h($board->users_hp) ?></td>
                    <td><?= h($board->users_email) ?></td>
                    <td><?= h($board->question) ?></td>
                    <td><?= h($board->answer) ?></td>
                    <td><?= h($board->created) ?></td>
                    <td><?= h($board->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $board->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $board->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $board->id], ['confirm' => __('Are you sure you want to delete # {0}?', $board->id)]) ?>
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