<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 * 
 */
?>
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript" src="https://service.iamport.kr/js/iamport.payment-1.1.5.js"></script>
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
                    
                    <fieldset>
                        <?php 
                            echo $this->Form->select('exhibition_survey.0.is_multiple', [['value' => 'Y', 'text' => '객관식'], ['value' => 'N', 'text' => '주관식']], ['default' => 'Y', 'id' => 'multiple', 'name' => 'multiple']);
                            echo $this->Form->select('exhibition_survey.0.survey_type', [['value' => 'Y', 'text' => '사전설문'], ['value' => 'N', 'text' => '일반설문']], ['default' => 'N', 'id' => 'surveyType', 'name' => 'surveyType']);
                            echo $this->Form->radio('exhibition_survey.0.is_duplicate', [['value' => 'Y', 'text' => '보기 중복 선택 가능']], ['id' => 'duplicate', 'name' => 'duplicate']);
                            // echo $this->Form->radio('exhibition_survey.0.is_duplicate', [['value' => '', 'text' => '필수']]);  //필수 라디오 버튼
                            echo $this->Form->control('exhibition_survey.0.text', ['value' => '질문', 'label' => false]);
                            // echo $this->Form->control('exhibition_survey.'.$a.'.text', ['value' => '보기', 'label' => false]);
                            echo $this->Form->control('exhibition_survey.1.text', ['value' => '보기', 'label' => false]);
                            echo $this->Form->button('보기 추가', ['id' => 'textAdd', 'name' => 'textAdd']);
                            echo $this->Form->button('보기 삭제', ['id' => 'textDelete', 'name' => 'textDelete']);
                        ?>
                    </fieldset>

            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('detail_html');
    
    $(function() {
        <?php $a=1; ?>
        $('button[name=textAdd]').on('click', function() {
            $('button[name=textAdd]').before('<?php echo $this->Form->control('exhibition_survey.'.++$a.'.text', ['value' => '보기', 'label' => false]) ?>');
        })
    });
</script>  