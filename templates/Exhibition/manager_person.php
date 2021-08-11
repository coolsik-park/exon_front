<?php
?>
<div class="userquestion index content">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('인적사항') ?></th>
                    <th><?= __('설문확인') ?></th>
                    <th><?= __('신청 그룹') ?></th>
                    <th><?= __('결제 내역') ?></th>
                    <th><?= __('출석 여부') ?></th>
                    <th><?= __('승인 상태') ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibition_users as $exhibition): ?>
                <tr>
                    <td><?= h($exhibition->users_name) ?></td>
                    <td class="actions" rowspan='5'>
                        <?= $this->Form->postLink(__('설문확인'), ['action' => 'userSurveyView', $exhibition->id]) ?>
                    </td>
                    <td rowspan='5'><?= h($exhibition->exhibition_group['name']) ?></td>
                    <td rowspan='5'><?= h($exhibition->exhibition_group['amount']) ?></td>
                    <td rowspan='5'><?php echo('결제 내역') ?></td>
                    <td rowspan='5'><?php echo $this->Form->control('', ['options' => ['1' => '참가 대기', '2' => '참가 확정']]) ?></td>
                    <td class="actions" rowspan='5'>
                        <?= $this->Form->postLink(__('취소'), ['action' => 'exhibitionUsersStatus', $exhibition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition->id)]) ?>
                    </td>
                </tr>
                <tr>
                    <td><?= h($exhibition->users_email) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition->users_hp) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition->users_group) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition->users_sex) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
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
</div>