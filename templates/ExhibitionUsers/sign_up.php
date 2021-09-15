<?php
?>
<div class="userquestion index content">
    <h3><?= __('신청 내역 관리') ?></h3>
    <div>
        <?php 
            if ($exhibition_users == null) {
                echo '목록이 없습니다.';
                exit;
            }
        ?>
        <?php echo $this->Html->link(__('신청행사'), ['action' => 'signUp', $exhibition_users[0]->users_id]) ?>
        <?php echo $this->Html->link(__('종료행사'), ['action' => 'signUp', $exhibition_users[0]->users_id, '1']) ?>
        <?php echo $this->Html->link(__('취소/환불'), ['action' => 'signUp', $exhibition_users[0]->users_id, '2']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= __('신청일시') ?></th>
                    <th><?= __('신청행사') ?></th>
                    <th><?= __('행사내용') ?></th>
                    <th><?= __('결제내역') ?></th>
                    <th><?= __('승인상태') ?></th>
                    <th><?= __('출석여부') ?></th>
                    <th><?= __('신청그룹') ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($exhibition_users as $exhibition_user): ?>
                <tr>
                    <td rowspan='2'><?php echo($exhibition_user->created) ?></td>
                    <td><?php echo($exhibition_user->exhibition['title']) ?></td>
                    <td><?php echo($exhibition_user->exhibition['sdate'].'~'.$exhibition_user->exhibition['edate']) ?></td>
                    <td rowspan='2'><?php echo($exhibition_user->exhibition_group['amount']) ?></td>
                    <td rowspan='2'>
                        <?php 
                            if ($exhibition_user->attend == 1) {
                                echo('신청 전');
                            } elseif($exhibition_user->attend == 2) {
                                echo('신청완료(참가대기)');
                            } elseif($exhibition_user->attend == 4) {
                                echo('참가확정');
                            } elseif($exhibition_user->attend == 8) {
                                echo('취소(환불)');
                            }
                        ?>
                    </td>
                    <td rowspan='2'>
                        <?php 
                            $today = new DateTime();
                            if ($exhibition_user->attend == 1) {
                                if ($today > $exhibition_user->exhibition['edate']) {
                                    echo('불참');
                                } else {
                                    echo('-');
                                }
                            } elseif($exhibition_user->attend == 2) {
                                echo('참석');
                            } elseif($exhibition_user->attend == 4) {
                                echo('시청완료');
                            }
                        ?>
                    </td>
                    <td rowspan='2'><?php echo($exhibition_user->exhibition_group['name']) ?></td>
                    <td class='actions'>
                        <?php echo $this->Form->postLink(__('증빙')) ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $this->Html->image(DS . $exhibition_user->exhibition['image_path'] . DS . $exhibition_user->exhibition['image_name']) ?></td>
                    <td><?php echo($exhibition_user->exhibition['name']) ?></td>
                    <td>
                        <?php 
                            $today = new DateTime();
                            if ($today < $exhibition_user->exhibition['sdate']) {
                                echo $this->Form->postLink(__('취소'), ['action' => 'exhibition_users_status', $exhibition_user->id, $exhibition_user->users_email, $exhibition_user->pay_id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition_user->id)]);
                            } elseif ($today > $exhibition_user->exhibition['edate']) {
                                echo('종료된 행사입니다.');
                            } else {
                                echo('진행중인 행사입니다.');
                            }
                        ?>
                    </td>
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
