<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="userquestion index content">
    <h3><?= __('UserQuestion by Category') ?></h3>
    <div>
        <?= $this->Html->link(__('전체'), ['action' => 'category']) ?>
        <?= $this->Html->link(__('회원'), ['action' => 'category', '1']) ?>
        <?= $this->Html->link(__('환불'), ['action' => 'category', '2']) ?>
        <?= $this->Html->link(__('결제'), ['action' => 'category', '3']) ?>
        <?= $this->Html->link(__('행사 참여'), ['action' => 'category', '4']) ?>
        <?= $this->Html->link(__('행사 개설'), ['action' => 'category', '5']) ?>
        <?= $this->Html->link(__('웨비나'), ['action' => 'category', '6']) ?>
        <?= $this->Html->link(__('기타'), ['action' => 'category', '7']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($boards as $board): ?>
                <tr>
                    <td><?= $this->Number->format($board->id) ?></td>
                    <td><?= h($board->title) ?></td>
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