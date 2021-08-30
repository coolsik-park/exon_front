<div class="userquestion index content">
<h3><?= __('개설 생사 관리') ?></h3>
    <div>
        <?php echo $this->Html->link(__('개설행사'), ['action' => 'exhibition_supervise', $id]) ?>
        <?php echo $this->Html->link(__('진행중 행사'), ['action' => 'exhibition_supervise', $id, '1']) ?>
        <?php echo $this->Html->link(__('임시저장 행사'), ['action' => 'exhibition_supervise', $id, '2']) ?>
        <?php echo $this->Html->link(__('종료 행사'), ['action' => 'exhibition_supervise', $id, '3']) ?>
    </div>
    <div class="table-responsive">
        <table>
            <tbody>
                <?php foreach ($exhibitions as $exhibition): ?>
                <tr>
                    <td rowspan='2'><?php echo $this->Html->image(DS.$exhibition->image_path.DS.$exhibition->image_name) ?></td>
                    <td><?php echo($exhibition->title) ?></td>
                    <td>
                        <?php 
                            if ($exhibition->private == 1) {
                                echo('임시저장');
                            } else {
                                if ($exhibition->edate < new \Datetime()) {
                                    echo('종료');
                                } else {
                                    echo('진행중');
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo($exhibition->sdate.'~'.$exhibition->edate) ?></td>
                    <td rowspan='2'><?php echo $this->Html->link('행사관리', ['action' => 'edit', $exhibition->id]) ?></td>
                    <td rowspan='2'><?php echo $this->Form->button('메뉴') ?></td>
                </tr>
                <tr>
                    <td><?php echo($exhibition->description) ?></td>
                    <td><?php echo('유료/무료') ?></td>
                    <td><?php echo($exhibition->apply_sdate.'~'.$exhibition->apply_edate) ?></td>
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