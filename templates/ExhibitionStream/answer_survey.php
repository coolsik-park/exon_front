<?php if (!empty($exhibitionSurveys)) : ?>
<div class="table-responsive">
    <?= $this->Form->create() ?>
    <table>
        <?php $i = 0; ?>
        <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
        <tr>
            <td><?= h($exhibitionSurvey->text) ?></td>
            <td>
                <?php
                    if ($exhibitionSurvey->is_multiple == 'N' || $exhibitionSurvey->parent_id != null) {
                        echo $this->Form->control('exhibition_survey_users_answer.' . $i . '.text');
                        $i++; 
                    } else {
                        echo $this->Form->control('exhibition_survey_users_answer.' . $i . '.text', ['type' => 'hidden', 'value' => 'question']);
                        $i++;
                    }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
<?php endif; ?>