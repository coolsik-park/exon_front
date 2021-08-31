<?php
?>
<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => 'Exhibition', 'action' => 'surveyData', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => 'Exhibition', 'action' => 'exhibitionStatisticsApply', $id, 'class' => 'side-nav-item']) ?>
<br><br>
<?= $this->Html->link(__('참가자'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('이메일 발송'), ['controller' => 'Exhibition', 'action' => 'sendEmailToParticipant', $id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('문자 발송'), ['controller' => 'Exhibition', 'action' => 'sendSmsToParticipant', $id, 'class' => 'side-nav-item']) ?>


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
                <?php foreach ($exhibition_users as $exhibition_user): ?>
                <tr>
                    <td><?= h($exhibition_user->users_name) ?></td>
                    <td class="actions" rowspan='5'>
                        <?= $this->Form->button(__('설문확인'), ['id' => 'userSurveyView', 'name' => 'userSurveyView']) ?>
                    </td>
                    <td rowspan='5'><?= h($exhibition_user->exhibition_group['name']) ?></td>
                    <td rowspan='5'><?= h($exhibition_user->exhibition_group['amount']) ?></td>
                    <td rowspan='5'>
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
                    <td rowspan='5'><?php echo $this->Form->control('', ['options' => ['2' => '참가 대기', '4' => '참가 확정'], 'id' => 'selectBox', 'name' => 'selectBox']) ?></td>
                    <td class='actions' rowspan='5'>
                        <?= $this->Form->postLink(__('취소'), ['action' => 'exhibitionUsersStatus', $exhibition_user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition_user->id)]) ?>
                    </td>
                </tr>
                <tr>
                    <td><?= h($exhibition_user->users_email) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition_user->users_hp) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition_user->users_group) ?></td>
                </tr>
                <tr>
                    <td><?= h($exhibition_user->users_sex) ?></td>
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
            <?php
                echo $this->Form->input('', ['placeholder' => '검색어를 입력하세요.', 'id' => 'wordSearch', 'name' => 'wordSearch']);
                echo $this->Form->button(__('검색'), ['id' => 'wordSearchButton', 'name' => 'wordSearchButton']);
                echo $this->Form->end();
            ?>
        </div>
    </div>
</div>
<script>
    $("select[name=selectBox]").on('change', function() {
        var value = $("#selectBox").val();
        var id = <?= $exhibition_user->id ?>;
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
        var id = <?= $exhibition_user->exhibition_id ?>;
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

    $('button[name=userSurveyView]').on('click', function() {
        window.open('http://121.126.223.225:8000/exhibition/userSurveyView/<?= $exhibition_user->id ?>', '설문확인', '');
    });
</script>