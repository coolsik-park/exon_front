<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSurvey $exhibitionSurvey
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="exhibitionSurvey view content">
            <?php foreach($exhibition_survey_users as $exhibition_survey_user): ?>
                <?php if($exhibition_survey_user->parent_id == null): ?>
                    <h3><?= h($exhibition_survey_user->id) ?></h3>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
