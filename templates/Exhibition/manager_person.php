<?php
?>
<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => '', 'action' => '', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => '', 'action' => '', $id, 'class' => 'side-nav-item']) ?>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
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
                    <td rowspan='5'><?php echo('출석여부') ?></td>
                    <td rowspan='5'><?php echo $this->Form->control('', ['options' => ['2' => '참가 대기', '4' => '참가 확정'], 'id' => 'selectBox', 'name' => 'selectBox']) ?></td>
                    <td class='actions' rowspan='5'>
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
        <div>
            <?php echo $this->Form->create(null, ['valueSources' => 'data', 'action' => 'search']) ?>
            <?php echo $this->Form->control('users_name', ['placeholder' => '검색어를 입력하세요.']) ?>
            <?php echo $this->Form->button(__('검색')) ?>
            <?php echo $this->Form->end() ?>
        </div>
    </div>
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
</script>