<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser $exhibitionUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition User'), ['action' => 'edit', $exhibitionUser->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition User'), ['action' => 'delete', $exhibitionUser->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionUser->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers view content">
            <h3><?= h($exhibitionUser->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Exhibition') ?></th>
                    <td><?= $exhibitionUser->has('exhibition') ? $this->Html->link($exhibitionUser->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionUser->exhibition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Exhibition Group') ?></th>
                    <td><?= $exhibitionUser->has('exhibition_group') ? $this->Html->link($exhibitionUser->exhibition_group->name, ['controller' => 'ExhibitionGroup', 'action' => 'view', $exhibitionUser->exhibition_group->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Email') ?></th>
                    <td><?= h($exhibitionUser->users_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Name') ?></th>
                    <td><?= h($exhibitionUser->users_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Hp') ?></th>
                    <td><?= h($exhibitionUser->users_hp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Group') ?></th>
                    <td><?= h($exhibitionUser->users_group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Sex') ?></th>
                    <td><?= h($exhibitionUser->users_sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay') ?></th>
                    <td><?= $exhibitionUser->has('pay') ? $this->Html->link($exhibitionUser->pay->id, ['controller' => 'Pay', 'action' => 'view', $exhibitionUser->pay->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibitionUser->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Id') ?></th>
                    <td><?= $this->Number->format($exhibitionUser->users_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay Amount') ?></th>
                    <td><?= $this->Number->format($exhibitionUser->pay_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($exhibitionUser->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibitionUser->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exhibitionUser->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
