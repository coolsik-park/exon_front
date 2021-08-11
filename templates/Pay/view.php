<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pay $pay
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Pay'), ['action' => 'edit', $pay->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Pay'), ['action' => 'delete', $pay->id], ['confirm' => __('Are you sure you want to delete # {0}?', $pay->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Pay'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Pay'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="pay view content">
            <h3><?= h($pay->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product Type') ?></th>
                    <td><?= h($pay->product_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $pay->has('user') ? $this->Html->link($pay->user->name, ['controller' => 'Users', 'action' => 'view', $pay->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Merchant Uid') ?></th>
                    <td><?= h($pay->merchant_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pg Tid') ?></th>
                    <td><?= h($pay->pg_tid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay Method') ?></th>
                    <td><?= h($pay->pay_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Receipt Url') ?></th>
                    <td><?= h($pay->receipt_url) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ip') ?></th>
                    <td><?= h($pay->ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancel Reason') ?></th>
                    <td><?= h($pay->cancel_reason) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fail Reason') ?></th>
                    <td><?= h($pay->fail_reason) ?></td>
                </tr>
                <tr>
                    <th><?= __('Manager') ?></th>
                    <td><?= $pay->has('manager') ? $this->Html->link($pay->manager->name, ['controller' => 'Managers', 'action' => 'view', $pay->manager->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Manager Ip') ?></th>
                    <td><?= h($pay->manager_ip) ?></td>
                </tr>
                <tr>
                    <th><?= __('Imp Uid') ?></th>
                    <td><?= h($pay->imp_uid) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($pay->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Amount') ?></th>
                    <td><?= $this->Number->format($pay->amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay Amount') ?></th>
                    <td><?= $this->Number->format($pay->pay_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Coupon Amount') ?></th>
                    <td><?= $this->Number->format($pay->coupon_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($pay->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancel Amount') ?></th>
                    <td><?= $this->Number->format($pay->cancel_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pay Date') ?></th>
                    <td><?= h($pay->pay_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($pay->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($pay->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Cancel Date') ?></th>
                    <td><?= h($pay->cancel_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fail Date') ?></th>
                    <td><?= h($pay->fail_date) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Exhibition Stream') ?></h4>
                <?php if (!empty($pay->exhibition_stream)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Pay Id') ?></th>
                            <th><?= __('Coupon Id') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Stream Key') ?></th>
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
                        <?php foreach ($pay->exhibition_stream as $exhibitionStream) : ?>
                        <tr>
                            <td><?= h($exhibitionStream->id) ?></td>
                            <td><?= h($exhibitionStream->exhibition_id) ?></td>
                            <td><?= h($exhibitionStream->pay_id) ?></td>
                            <td><?= h($exhibitionStream->coupon_id) ?></td>
                            <td><?= h($exhibitionStream->title) ?></td>
                            <td><?= h($exhibitionStream->description) ?></td>
                            <td><?= h($exhibitionStream->stream_key) ?></td>
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
            <div class="related">
                <h4><?= __('Related Exhibition Users') ?></h4>
                <?php if (!empty($pay->exhibition_users)) : ?>
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
                        <?php foreach ($pay->exhibition_users as $exhibitionUsers) : ?>
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
