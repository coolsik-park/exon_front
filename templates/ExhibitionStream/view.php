<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionStream $exhibitionStream
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition Stream'), ['action' => 'edit', $exhibitionStream->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition Stream'), ['action' => 'delete', $exhibitionStream->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStream->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition Stream'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition Stream'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionStream view content">
            <h3><?= h($exhibitionStream->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Exhibition') ?></th>
                    <td><?= $exhibitionStream->has('exhibition') ? $this->Html->link($exhibitionStream->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionStream->exhibition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay') ?></th>
                    <td><?= $exhibitionStream->has('pay') ? $this->Html->link($exhibitionStream->pay->id, ['controller' => 'Pay', 'action' => 'view', $exhibitionStream->pay->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Coupon') ?></th>
                    <td><?= $exhibitionStream->has('coupon') ? $this->Html->link($exhibitionStream->coupon->id, ['controller' => 'Coupon', 'action' => 'view', $exhibitionStream->coupon->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Stream Key') ?></th>
                    <td><?= h($exhibitionStream->stream_key) ?></td>
                </tr>
                <tr>
                    <th><?= __('Url') ?></th>
                    <td><?= h($exhibitionStream->url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($exhibitionStream->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibitionStream->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Time') ?></th>
                    <td><?= $this->Number->format($exhibitionStream->time) ?></td>
                </tr>
                <tr>
                    <th><?= __('People') ?></th>
                    <td><?= $this->Number->format($exhibitionStream->people) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($exhibitionStream->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coupon Amount') ?></th>
                    <td><?= $this->Number->format($exhibitionStream->coupon_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibitionStream->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exhibitionStream->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Exhibition Stream Chat Log') ?></h4>
                <?php if (!empty($exhibitionStream->exhibition_stream_chat_log)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Stream Id') ?></th>
                            <th><?= __('Users Id') ?></th>
                            <th><?= __('Message') ?></th>
                            <th><?= __('User Name') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibitionStream->exhibition_stream_chat_log as $exhibitionStreamChatLog) : ?>
                        <tr>
                            <td><?= h($exhibitionStreamChatLog->id) ?></td>
                            <td><?= h($exhibitionStreamChatLog->exhibition_stream_id) ?></td>
                            <td><?= h($exhibitionStreamChatLog->users_id) ?></td>
                            <td><?= h($exhibitionStreamChatLog->message) ?></td>
                            <td><?= h($exhibitionStreamChatLog->user_name) ?></td>
                            <td><?= h($exhibitionStreamChatLog->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionStreamChatLog', 'action' => 'view', $exhibitionStreamChatLog->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionStreamChatLog', 'action' => 'edit', $exhibitionStreamChatLog->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionStreamChatLog', 'action' => 'delete', $exhibitionStreamChatLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStreamChatLog->id)]) ?>
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
