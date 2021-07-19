<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionGroup $exhibitionGroup
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition Group'), ['action' => 'edit', $exhibitionGroup->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition Group'), ['action' => 'delete', $exhibitionGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionGroup->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition Group'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition Group'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionGroup view content">
            <h3><?= h($exhibitionGroup->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Exhibition') ?></th>
                    <td><?= $exhibitionGroup->has('exhibition') ? $this->Html->link($exhibitionGroup->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionGroup->exhibition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($exhibitionGroup->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibitionGroup->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('People') ?></th>
                    <td><?= $this->Number->format($exhibitionGroup->people) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($exhibitionGroup->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibitionGroup->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exhibitionGroup->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Exhibition Users') ?></h4>
                <?php if (!empty($exhibitionGroup->exhibition_users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Exhibition Group Id') ?></th>
                            <th><?= __('Users Id') ?></th>
                            <th><?= __('Users Email') ?></th>
                            <th><?= __('Users Name') ?></th>
                            <th><?= __('Users Hp') ?></th>
                            <th><?= __('Users Group') ?></th>
                            <th><?= __('Users Sex') ?></th>
                            <th><?= __('Pay Id') ?></th>
                            <th><?= __('Pay Amount') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibitionGroup->exhibition_users as $exhibitionUsers) : ?>
                        <tr>
                            <td><?= h($exhibitionUsers->id) ?></td>
                            <td><?= h($exhibitionUsers->exhibition_id) ?></td>
                            <td><?= h($exhibitionUsers->exhibition_group_id) ?></td>
                            <td><?= h($exhibitionUsers->users_id) ?></td>
                            <td><?= h($exhibitionUsers->users_email) ?></td>
                            <td><?= h($exhibitionUsers->users_name) ?></td>
                            <td><?= h($exhibitionUsers->users_hp) ?></td>
                            <td><?= h($exhibitionUsers->users_group) ?></td>
                            <td><?= h($exhibitionUsers->users_sex) ?></td>
                            <td><?= h($exhibitionUsers->pay_id) ?></td>
                            <td><?= h($exhibitionUsers->pay_amount) ?></td>
                            <td><?= h($exhibitionUsers->status) ?></td>
                            <td><?= h($exhibitionUsers->created) ?></td>
                            <td><?= h($exhibitionUsers->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionUsers', 'action' => 'view', $exhibitionUsers->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionUsers', 'action' => 'edit', $exhibitionUsers->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionUsers', 'action' => 'delete', $exhibitionUsers->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionUsers->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
