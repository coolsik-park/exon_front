<?php

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Question'), ['action' => 'edit', $board->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Question'), ['action' => 'delete', $board->id], ['confirm' => __('Are you sure you want to delete # {0}?', $board->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Question'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Question'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
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
                    <th><?= __('Name') ?></th>
                    <td><?= h($board->users_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone Number') ?></th>
                    <td><?= h($board->users_hp) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($board->users_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Faq Category') ?></th>
                    <td><?= h($board->faq_category_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Question') ?></th>
                    <td><?= h($board->question) ?></td>
                </tr>
                <?php if($board->answer != null) { ?>
                <tr>
                    <th><?= __('Answer') ?></th>
                    <td><?= h($board->answer) ?></td>
                </tr>
                <?php } ?>
                <?php if($board->user_question_files[0]->id != null) { ?>
                <tr>
                    <td colspan='2'><?php echo $this->Html->image(DS . $board->user_question_files[0]->file_path . DS . $board->user_question_files[0]->file_name); ?></td>
                </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>