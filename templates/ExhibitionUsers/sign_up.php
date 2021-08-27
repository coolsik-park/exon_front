<?php
?>
<<<<<<< HEAD
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
=======
>>>>>>> bomi
<div class="userquestion index content">
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
                            if ($exhibition_user->attend == 1) {
                                echo('불참');
                            } elseif($exhibition_user->attend == 2) {
                                echo('참석');
                            } elseif($exhibition_user->attend == 4) {
                                echo('시청완료');
                            }
                        ?>
                    </td>
                    <td rowspan='2'><?php echo($exhibition_user->exhibition_group['name']) ?></td>
                    <td class='actions'>
<<<<<<< HEAD
                        <?php echo $this->Form->postLink(__('취소'), ['action' => 'exhibitionUsersStatus', $exhibition_user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition_user->id)]) ?>
=======
                        <?php echo $this->Form->postLink(__('증빙')) ?>
>>>>>>> bomi
                    </td>
                </tr>
                <tr>
                    <td><?php echo $this->Html->image(DS . $exhibition_user->exhibition['image_path'] . DS . $exhibition_user->exhibition['image_name']) ?></td>
                    <td><?php echo($exhibition_user->exhibition['name']) ?></td>
<<<<<<< HEAD
                    <td><?php echo $this->Form->postLink(__('증빙')) ?></td>
=======
                    <td>
                        <?php 
                            if ($exhibition_user->exhibition['edate'] > date('m-d-Y h:i:s a', time())) {
                                echo('종료된 행사입니다.');
                            } else {
                                echo $this->Form->postLink(__('취소'), ['action' => 'exhibition_users_status', $exhibition_user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition_user->id)]);
                                // echo $this->Form->postLink(__('취소'), ['action' => 'a']);
                            }
                        ?>
                    </td>
>>>>>>> bomi
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
<<<<<<< HEAD
</div>
<script>
    $("select[name=selectBox]").on('change', function() {
        var value = $("#selectBox").val();
        var id = <?= $exhibition->id ?>;
        $.ajax({
            url: "http://121.126.223.225:8000/exhibition/exhibition-users-approval",
            method: 'POST',
                type: 'json',
                data: {
                    id: id,
                    status: value
                }
        })
    });

    $('button[name=wordSearchButton]').on('click', function() {
        var value = $('input[name=wordSearch]').val();
        var id = <?= $exhibition->exhibition_id ?>;
        console.log(value);
        console.log(id);
        $.ajax({
            url: "http://121.126.223.225:8000/exhibition/word-search",
            method: 'POST',
            type: 'json',
            data: {
                id: id,
                word: value
            }
        })
    });
</script>
=======
</div>
>>>>>>> bomi
