<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ExhibitionSpeaker $exhibitionSpeaker
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition Speaker'), ['action' => 'edit', $exhibitionSpeaker->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition Speaker'), ['action' => 'delete', $exhibitionSpeaker->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSpeaker->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition Speaker'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition Speaker'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibitionSpeaker view content">
            <h3><?= h($exhibitionSpeaker->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Exhibition') ?></th>
                    <td><?= $exhibitionSpeaker->has('exhibition') ? $this->Html->link($exhibitionSpeaker->exhibition->name, ['controller' => 'Exhibition', 'action' => 'view', $exhibitionSpeaker->exhibition->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($exhibitionSpeaker->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Path') ?></th>
                    <td><?= h($exhibitionSpeaker->image_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Name') ?></th>
                    <td><?= h($exhibitionSpeaker->image_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibitionSpeaker->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibitionSpeaker->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
