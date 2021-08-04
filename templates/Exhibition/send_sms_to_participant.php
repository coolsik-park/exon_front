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
            <?= $this->Form->create($exhibitionUsers)?>
            <fieldset>
                <legend><?= __('Send SMS') ?></legend>
                <?php echo $this->Form->control('sms_content', ['type' => 'textarea']); ?>
                <?php
                    $data[] = '';
                    $count = count($exhibitionUsers);
                    
                    for ($i = 0; $i < $count; $i++) {
                        $data[$i] = $exhibitionUsers[$i]['users_hp'];   
                    }
                    echo $this->Form->select('users_hp', $data, ['multiple' => 'checkbox']);
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