<?php

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Notice'), ['action' => 'notice_edit', $board->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Notice'), ['action' => 'notice_delete', $board->id], ['confirm' => __('Are you sure you want to delete # {0}?', $board->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Notice'), ['action' => 'notice_index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Notice'), ['action' => 'notice_add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="question view content">
            <h3><?= h($board->tile) ?></h3>
            <table>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($board->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Content') ?></th>
                    <td><?= h($board->content) ?></td>
                </tr>
                <tr>
                    <td colspan='2'><?php echo $this->Html->image(DS . $board->file_path . DS . $board->file_name); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>