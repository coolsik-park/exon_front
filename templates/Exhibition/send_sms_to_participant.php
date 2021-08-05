<script src="//cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?php
                if (count($exhibitionUsers) > 0 ) { 
                    echo $this->Html->link(__('참가자리스트'), ['action' => 'participantList', $exhibitionUsers[0]['exhibition_id'], 'sms', 'class' => 'side-nav-item']);
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
                <legend><?= __('Send SMS') ?></legend>
                <?php echo $this->Form->control('sms_content', ['type' => 'textarea']); ?>
                <?php
                    $data[] = '';
                    $count = count($exhibitionUsers);
                    
                    if (count($exhibitionUsers) > 0 && $exhibitionUsers[0]['users_hp']) {
                        for ($i = 0; $i < $count; $i++) {
                            $data[$i] = $exhibitionUsers[$i]['users_hp'];
                        }
                        echo $this->Form->select('users_hp', $data, ['multiple' => 'checkbox']);
                    }
                ?>
            </fieldset>
            <?= $this->Form->button(__('Send'), ['controller' => 'Exhibition', 'action' => 'sendSmsToParticipant']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>
    CKEDITOR.replace('sms_content');
</script>