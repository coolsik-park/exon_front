<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSurvey[]|\Cake\Collection\CollectionInterface $exhibitionSurvey
 */
?>
<div class="exhibitionSurvey index content">
    <?= $this->Html->link(__('New Exhibition Survey'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Exhibition Survey') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('exhibition_id') ?></th>
                    <th><?= $this->Paginator->sort('survey_type') ?></th>
                    <th><?= $this->Paginator->sort('parent_id') ?></th>
                    <th><?= $this->Paginator->sort('text') ?></th>
                    <th><?= $this->Paginator->sort('is_duplicate') ?></th>
                    <th><?= $this->Paginator->sort('is_multiple') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibitionSurvey as $exhibitionSurvey): ?>
                <tr>
                    <td><?= $this->Number->format($exhibitionSurvey->id) ?></td>
                    <td><?= $exhibitionSurvey->has('exhibition') ? $this->Html->link($exhibitionSurvey->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionSurvey->exhibition->id]) : '' ?></td>
                    <td><?= h($exhibitionSurvey->survey_type) ?></td>
                    <td><?= $exhibitionSurvey->has('parent_exhibition_survey') ? $this->Html->link($exhibitionSurvey->parent_exhibition_survey->text, ['controller' => 'ExhibitionSurvey', 'action' => 'view', $exhibitionSurvey->parent_exhibition_survey->id]) : '' ?></td>
                    <td><?= h($exhibitionSurvey->text) ?></td>
                    <td><?= h($exhibitionSurvey->is_duplicate) ?></td>
                    <td><?= h($exhibitionSurvey->is_multiple) ?></td>
                    <td><?= h($exhibitionSurvey->created) ?></td>
                    <td><?= h($exhibitionSurvey->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $exhibitionSurvey->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $exhibitionSurvey->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $exhibitionSurvey->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSurvey->id)]) ?>
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
