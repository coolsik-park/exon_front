<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition[]|\Cake\Collection\CollectionInterface $exhibition
 */
?>
<div class="exhibition index content">
    <?= $this->Html->link(__('New Exhibition'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('users_id') ?></th>
                    <th><?= $this->Paginator->sort('title') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('apply_sdate') ?></th>
                    <th><?= $this->Paginator->sort('apply_edate') ?></th>
                    <th><?= $this->Paginator->sort('sdate') ?></th>
                    <th><?= $this->Paginator->sort('edate') ?></th>
                    <th><?= $this->Paginator->sort('image_path') ?></th>
                    <th><?= $this->Paginator->sort('image_name') ?></th>
                    <th><?= $this->Paginator->sort('private') ?></th>
                    <th><?= $this->Paginator->sort('auto_approval') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('tel') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('require_name') ?></th>
                    <th><?= $this->Paginator->sort('require_email') ?></th>
                    <th><?= $this->Paginator->sort('require_tel') ?></th>
                    <th><?= $this->Paginator->sort('require_age') ?></th>
                    <th><?= $this->Paginator->sort('require_group') ?></th>
                    <th><?= $this->Paginator->sort('require_sex') ?></th>
                    <th><?= $this->Paginator->sort('require_cert') ?></th>
                    <th><?= $this->Paginator->sort('email_notice') ?></th>
                    <th><?= $this->Paginator->sort('additional') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibition as $exhibition): ?>
                <tr>
                    <td><?= $this->Number->format($exhibition->id) ?></td>
                    <td><?= $this->Number->format($exhibition->users_id) ?></td>
                    <td><?= h($exhibition->title) ?></td>
                    <td><?= h($exhibition->description) ?></td>
                    <td><?= h($exhibition->category) ?></td>
                    <td><?= h($exhibition->type) ?></td>
                    <td><?= h($exhibition->apply_sdate) ?></td>
                    <td><?= h($exhibition->apply_edate) ?></td>
                    <td><?= h($exhibition->sdate) ?></td>
                    <td><?= h($exhibition->edate) ?></td>
                    <td><?= h($exhibition->image_path) ?></td>
                    <td><?= h($exhibition->image_name) ?></td>
                    <td><?= $this->Number->format($exhibition->private) ?></td>
                    <td><?= $this->Number->format($exhibition->auto_approval) ?></td>
                    <td><?= h($exhibition->name) ?></td>
                    <td><?= h($exhibition->tel) ?></td>
                    <td><?= h($exhibition->email) ?></td>
                    <td><?= $this->Number->format($exhibition->require_name) ?></td>
                    <td><?= $this->Number->format($exhibition->require_email) ?></td>
                    <td><?= $this->Number->format($exhibition->require_tel) ?></td>
                    <td><?= $this->Number->format($exhibition->require_age) ?></td>
                    <td><?= $this->Number->format($exhibition->require_group) ?></td>
                    <td><?= $this->Number->format($exhibition->require_sex) ?></td>
                    <td><?= $this->Number->format($exhibition->require_cert) ?></td>
                    <td><?= $this->Number->format($exhibition->email_notice) ?></td>
                    <td><?= $this->Number->format($exhibition->additional) ?></td>
                    <td><?= $this->Number->format($exhibition->status) ?></td>
                    <td><?= h($exhibition->created) ?></td>
                    <td><?= h($exhibition->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibition->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibition->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition->id)]) ?>
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
