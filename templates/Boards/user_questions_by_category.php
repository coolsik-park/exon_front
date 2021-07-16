<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="userquestion index content">
    <h3><?= __('UserQuestions by Category') ?></h3>
    <div>
        <?= $this->Html->link(__('전체'), ['action' => 'userQuestionsByCategory']) ?>
        <?= $this->Html->link(__('회원'), ['action' => 'userQuestionsByCategory', '1']) ?>
        <?= $this->Html->link(__('환불'), ['action' => 'userQuestionsByCategory', '2']) ?>
        <?= $this->Html->link(__('결제'), ['action' => 'userQuestionsByCategory', '3']) ?>
        <?= $this->Html->link(__('행사 참여'), ['action' => 'userQuestionsByCategory', '4']) ?>
        <?= $this->Html->link(__('행사 개설'), ['action' => 'userQuestionsByCategory', '5']) ?>
        <?= $this->Html->link(__('웨비나'), ['action' => 'userQuestionsByCategory', '6']) ?>
        <?= $this->Html->link(__('기타'), ['action' => 'userQuestionsByCategory', '7']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php foreach ($userQuestions as $userQuestion): ?>
                <tr>
                    <td><?= $this->Number->format($userQuestion->id) ?></td>
                    <td><?= h($userQuestion->title) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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