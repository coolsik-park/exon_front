<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php
                if (count($exhibitionUsers) > 0 ) { 
                    echo $this->Html->link(__('참가자리스트'), ['action' => 'participantList', $exhibitionUsers[0]['exhibition_id'], 'email', 'class' => 'side-nav-item']);
                } else {
                    echo $this->Html->link(__('참가자리스트'), ['action' => 'participantList', 0, 'email', 'class' => 'side-nav-item']);
                } 
            ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition form content">
            <?= $this->Form->create($exhibitionUsers)?>
            <fieldset>
                <legend><?= __('Send Emails') ?></legend>
                <?php 
                    echo $this->Form->control('name');
                    echo $this->Form->control('email_content', ['type' => 'textarea']);
                ?>
                <?php
                    $data[] = '';
                    $count = count($exhibitionUsers);
                    
                    if (count($exhibitionUsers) > 0 && $exhibitionUsers[0]['users_email']) {
                        for ($i = 0; $i < $count; $i++) {
                            $data[$i] = $exhibitionUsers[$i]['users_email'];
                        }
                        echo $this->Form->select('users_email', $data, ['multiple' => 'checkbox']);
                    }
                ?>
            </fieldset>
            <?= $this->Form->button(__('Send')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('email_content');
</script>  