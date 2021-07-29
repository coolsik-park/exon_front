<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 * 
 */
?>
<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Exhibition'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibition, ['enctype' => 'multipart/form-data'])?>
            <fieldset>
                <legend><?= __('Add Exhibition') ?></legend>
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
                    <legend><?= __('ExhibitionGroup 1') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_group.0.name');
                    echo $this->Form->control('exhibition_group.0.people');
                    echo $this->Form->control('exhibition_group.0.amount');
                    ?>
                    <br>
                    <legend><?= __('ExhibitionGroup 2') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_group.1.name');
                    echo $this->Form->control('exhibition_group.1.people');
                    echo $this->Form->control('exhibition_group.1.amount');
                    ?>
                    <br>
                    <legend><?= __('ExhibitionSurvey 1') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_survey.0.survey_type');
                    echo $this->Form->control('exhibition_survey.0.text');
                    echo $this->Form->control('exhibition_survey.0.is_duplicate');
                    echo $this->Form->control('exhibition_survey.0.is_multiple');
                    ?>
                    <br>
                    
                    <?php
                    echo $this->Form->control('exhibition_survey.1.text');
                    ?>
                    <br>
                   
                    <?php
                    echo $this->Form->control('exhibition_survey.2.text');
                    ?>
                    <br>
                   
                    <?php
                    echo $this->Form->control('exhibition_survey.3.text');
                    ?>
                    <br>
                   
                    <?php
                    echo $this->Form->control('exhibition_survey.4.text');
                    ?>
                    <br>
                    
                    <?php
                    echo $this->Form->control('exhibition_survey.5.text');
                    ?>
                    <br>

                    <legend><?= __('ExhibitionSurvey 2') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_survey.6.survey_type');
                    echo $this->Form->control('exhibition_survey.6.text');
                    echo $this->Form->control('exhibition_survey.6.is_duplicate');
                    echo $this->Form->control('exhibition_survey.6.is_multiple');
                    ?>
                    <br>

                    <legend><?= __('ExhibitionSurvey 3') ?></legend>
                    <?php
                    echo $this->Form->control('exhibition_survey.7.survey_type');
                    echo $this->Form->control('exhibition_survey.7.text');
                    echo $this->Form->control('exhibition_survey.7.is_duplicate');
                    echo $this->Form->control('exhibition_survey.7.is_multiple');
                    ?>
                    <br>

                    <?php
                    echo $this->Form->control('exhibition_survey.8.text');
                    ?>
                    <br>

                    <?php
                    echo $this->Form->control('exhibition_survey.9.text');
                    ?>
                    <br>

                    <?php
                    echo $this->Form->control('exhibition_survey.10.text');
                    ?>
                    <br>
                    
                    <?php
                    echo $this->Form->control('exhibition_survey.11.text'); 
                ?>
            </fieldset>
            <script>
                CKEDITOR.replace('detail_html');
            </script>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>  




