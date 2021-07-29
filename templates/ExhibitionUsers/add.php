<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionUser $exhibitionUser
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionUsers form content">
            <?= $this->Form->create($exhibitionUser) ?>
            <fieldset>
                <legend><?= __('Add Exhibition User') ?></legend>
                <?php
                    echo $this->Form->control('exhibition_group_id', ['options' => $exhibitionGroup]);
                    echo $this->Form->control('users_email');
                    echo $this->Form->control('users_name');
                    echo $this->Form->control('users_hp');
                    echo $this->Form->control('users_group');
                    echo $this->Form->control('users_sex');
                    echo $this->Form->control('pay_id', ['options' => $pay, 'empty' => true]);
                    echo $this->Form->control('pay_amount');
                    echo $this->Form->control('status');
                ?>
                 <div class="related">
                <h4><?= __('Exhibition Survey') ?></h4>
                <?php if (!empty($exhibitionSurveys)) : ?>
                <div class="table-responsive">
                    <table>
                        <?php $i = 0; ?>
                        <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
                        <?php 
                            $data = Cake\Utility\Text::tokenize($exhibitionSurvey, ';');
                        ?>
                        <tr>
                            <td><?= h($data[0]) ?></td>
                            <td>
                                <?php
                                    if ($data[1] == 'N' || $data[2] != null) {
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
                </div>
                <?php endif; ?>
            </div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
