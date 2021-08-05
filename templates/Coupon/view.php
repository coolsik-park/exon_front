<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Coupon $coupon
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Coupon'), ['action' => 'edit', $coupon->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Coupon'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete # {0}?', $coupon->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Coupon'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Coupon'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="coupon view content">
            <h3><?= h($coupon->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $coupon->has('user') ? $this->Html->link($coupon->user->name, ['controller' => 'Users', 'action' => 'view', $coupon->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Type') ?></th>
                    <td><?= h($coupon->product_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($coupon->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sdate') ?></th>
                    <td><?= h($coupon->sdate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Edate') ?></th>
                    <td><?= h($coupon->edate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($coupon->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($coupon->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($coupon->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($coupon->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($coupon->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Exhibition Stream') ?></h4>
                <?php if (!empty($coupon->exhibition_stream)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Pay Id') ?></th>
                            <th><?= __('Coupon Id') ?></th>
                            <th><?= __('Time') ?></th>
                            <th><?= __('People') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Coupon Amount') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($coupon->exhibition_stream as $exhibitionStream) : ?>
                        <tr>
                            <td><?= h($exhibitionStream->id) ?></td>
                            <td><?= h($exhibitionStream->exhibition_id) ?></td>
                            <td><?= h($exhibitionStream->pay_id) ?></td>
                            <td><?= h($exhibitionStream->coupon_id) ?></td>
                            <td><?= h($exhibitionStream->time) ?></td>
                            <td><?= h($exhibitionStream->people) ?></td>
                            <td><?= h($exhibitionStream->amount) ?></td>
                            <td><?= h($exhibitionStream->coupon_amount) ?></td>
                            <td><?= h($exhibitionStream->url) ?></td>
                            <td><?= h($exhibitionStream->ip) ?></td>
                            <td><?= h($exhibitionStream->created) ?></td>
                            <td><?= h($exhibitionStream->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionStream', 'action' => 'view', $exhibitionStream->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionStream', 'action' => 'edit', $exhibitionStream->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionStream', 'action' => 'delete', $exhibitionStream->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStream->id)]) ?>
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
