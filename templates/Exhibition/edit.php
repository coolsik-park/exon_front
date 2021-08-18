<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>
<?= $this->Html->link(__('행사 설정 수정'), ['controller' => 'Exhibition', 'action' => 'edit', $exhibition->id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('설문 데이터'), ['controller' => '', 'action' => '', $exhibition->id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('참가자 관리'), ['controller' => 'Exhibition', 'action' => 'managerPerson', $exhibition->id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('웨비나 송출 설정'), ['controller' => 'ExhibitionStream', 'action' => 'setExhibitionStream', $exhibition->id, 'class' => 'side-nav-item']) ?> 
<?= $this->Html->link(__('행사 통계'), ['controller' => '', 'action' => '', $exhibition->id, 'class' => 'side-nav-item']) ?>

<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $exhibition->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Exhibition'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibition, ['enctype' => 'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('Edit Exhibition') ?></legend>
                <?php
                    echo $this->Form->control('image', ['type' => 'file']);
                    echo $this->Form->control('users_id');
                    echo $this->Form->control('title');
                    echo $this->Form->control('description');
                    echo $this->Form->control('category');
                    echo $this->Form->control('type');
                    echo $this->Form->control('detail_html');
                    echo $this->Form->control('apply_sdate', ['empty' => true]);
                    echo $this->Form->control('apply_edate', ['empty' => true]);
                    echo $this->Form->control('sdate', ['empty' => true]);
                    echo $this->Form->control('edate', ['empty' => true]);
                    echo $this->Form->control('private');
                    echo $this->Form->control('auto_approval');
                    echo $this->Form->control('name');
                    echo $this->Form->control('tel');
                    echo $this->Form->control('email');
                    echo $this->Form->control('require_name');
                    echo $this->Form->control('require_email');
                    echo $this->Form->control('require_tel');
                    echo $this->Form->control('require_age');
                    echo $this->Form->control('require_group');
                    echo $this->Form->control('require_sex');
                    echo $this->Form->control('require_cert');
                    echo $this->Form->control('email_notice');
                    echo $this->Form->control('additional');
                    echo $this->Form->control('status');
                ?>
                <br>

                <?php  if (!empty($exhibitionGroups)) : ?>
                <div class="table-responsive">
                    <table>
                        <?php $i = 0; ?>
                        <?php foreach ($exhibitionGroups as $exhibitionGroup) : ?>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_group.' . $i . '.id', ['value' => $exhibitionGroup->id, 'type' => 'hidden']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_group.' . $i . '.name', ['value' => $exhibitionGroup->name]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_group.' . $i . '.people', ['value' => $exhibitionGroup->people]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_group.' . $i . '.amount', ['value' => $exhibitionGroup->amount]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_group.' . $i . '.is_delete', ['value' => 'N']); ?>
                            </td>
                        </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
                <br>

                <?php  if (!empty($exhibitionSurveys)) : ?>
                <div class="table-responsive">
                    <table>
                        <?php $i = 0; ?>
                        <?php foreach ($exhibitionSurveys as $exhibitionSurvey) : ?>
                        <?php
                            if ($exhibitionSurvey->parent_id == null) {
                        ?>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.id', ['value' => $exhibitionSurvey->id, 'type' => 'hidden']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.survey_type', ['value' => $exhibitionSurvey->survey_type]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.text', ['value' => $exhibitionSurvey->text]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.is_duplicate', ['value' => $exhibitionSurvey->is_duplicate]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i .'.is_multiple', ['value' => $exhibitionSurvey->is_multiple]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.is_delete', ['value' => 'N']); ?>
                            </td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.id', ['value' => $exhibitionSurvey->id, 'type' => 'hidden']); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.text', ['value' => $exhibitionSurvey->text]); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <?php echo $this->Form->control('exhibition_survey.' . $i . '.is_delete', ['value' => 'multiple view', 'type' => 'hidden']); ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </fieldset>
            <script>
                CKEDITOR.replace('detail_html');
            </script>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('detail_html');
</script>
