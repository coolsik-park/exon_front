<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSurvey $exhibitionSurvey
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition Survey'), ['action' => 'edit', $exhibitionSurvey->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition Survey'), ['action' => 'delete', $exhibitionSurvey->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSurvey->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition Survey'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition Survey'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionSurvey view content">
            <h3><?= h($exhibitionSurvey->text) ?></h3>
            <table>
                <tr>
                    <th><?= __('Exhibition') ?></th>
                    <td><?= $exhibitionSurvey->has('exhibition') ? $this->Html->link($exhibitionSurvey->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionSurvey->exhibition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Survey Type') ?></th>
                    <td><?= h($exhibitionSurvey->survey_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Parent Exhibition Survey') ?></th>
                    <td><?= $exhibitionSurvey->has('parent_exhibition_survey') ? $this->Html->link($exhibitionSurvey->parent_exhibition_survey->text, ['controller' => 'ExhibitionSurvey', 'action' => 'view', $exhibitionSurvey->parent_exhibition_survey->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Text') ?></th>
                    <td><?= h($exhibitionSurvey->text) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Duplicate') ?></th>
                    <td><?= h($exhibitionSurvey->is_duplicate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Multiple') ?></th>
                    <td><?= h($exhibitionSurvey->is_multiple) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibitionSurvey->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibitionSurvey->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exhibitionSurvey->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Exhibition Survey') ?></h4>
                <?php if (!empty($exhibitionSurvey->child_exhibition_survey)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Survey Type') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Is Duplicate') ?></th>
                            <th><?= __('Is Multiple') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibitionSurvey->child_exhibition_survey as $childExhibitionSurvey) : ?>
                        <tr>
                            <td><?= h($childExhibitionSurvey->id) ?></td>
                            <td><?= h($childExhibitionSurvey->exhibition_id) ?></td>
                            <td><?= h($childExhibitionSurvey->survey_type) ?></td>
                            <td><?= h($childExhibitionSurvey->parent_id) ?></td>
                            <td><?= h($childExhibitionSurvey->text) ?></td>
                            <td><?= h($childExhibitionSurvey->is_duplicate) ?></td>
                            <td><?= h($childExhibitionSurvey->is_multiple) ?></td>
                            <td><?= h($childExhibitionSurvey->created) ?></td>
                            <td><?= h($childExhibitionSurvey->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionSurvey', 'action' => 'view', $childExhibitionSurvey->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionSurvey', 'action' => 'edit', $childExhibitionSurvey->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionSurvey', 'action' => 'delete', $childExhibitionSurvey->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childExhibitionSurvey->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Exhibition Survey Users Answer') ?></h4>
                <?php if (!empty($exhibitionSurvey->exhibition_survey_users_answer)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Survey Id') ?></th>
                            <th><?= __('Users Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Is Multiple') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibitionSurvey->exhibition_survey_users_answer as $exhibitionSurveyUsersAnswer) : ?>
                        <tr>
                            <td><?= h($exhibitionSurveyUsersAnswer->id) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->exhibition_survey_id) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->users_id) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->text) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->parent_id) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->is_multiple) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->created) ?></td>
                            <td><?= h($exhibitionSurveyUsersAnswer->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionSurveyUsersAnswer', 'action' => 'view', $exhibitionSurveyUsersAnswer->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionSurveyUsersAnswer', 'action' => 'edit', $exhibitionSurveyUsersAnswer->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionSurveyUsersAnswer', 'action' => 'delete', $exhibitionSurveyUsersAnswer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSurveyUsersAnswer->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
