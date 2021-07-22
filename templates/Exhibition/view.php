<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Exhibition $exhibition
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Exhibition'), ['action' => 'edit', $exhibition->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Exhibition'), ['action' => 'delete', $exhibition->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibition->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Exhibition'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Exhibition'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="exhibition view content">
            <h3><?= h($exhibition->name) ?></h3>
            <table>
                <tr>
                    <?php echo $this->Html->image('/upload/exhibition/2021/07' . DS . $exhibition->image_name, ['alt' => 'abc']); ?>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($exhibition->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($exhibition->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($exhibition->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= h($exhibition->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Path') ?></th>
                    <td><?= h($exhibition->image_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Image Name') ?></th>
                    <td><?= h($exhibition->image_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($exhibition->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tel') ?></th>
                    <td><?= h($exhibition->tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($exhibition->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($exhibition->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Users Id') ?></th>
                    <td><?= $this->Number->format($exhibition->users_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Private') ?></th>
                    <td><?= $this->Number->format($exhibition->private) ?></td>
                </tr>
                <tr>
                    <th><?= __('Auto Approval') ?></th>
                    <td><?= $this->Number->format($exhibition->auto_approval) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Name') ?></th>
                    <td><?= $this->Number->format($exhibition->require_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Email') ?></th>
                    <td><?= $this->Number->format($exhibition->require_email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Tel') ?></th>
                    <td><?= $this->Number->format($exhibition->require_tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Age') ?></th>
                    <td><?= $this->Number->format($exhibition->require_age) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Group') ?></th>
                    <td><?= $this->Number->format($exhibition->require_group) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Sex') ?></th>
                    <td><?= $this->Number->format($exhibition->require_sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('Require Cert') ?></th>
                    <td><?= $this->Number->format($exhibition->require_cert) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email Notice') ?></th>
                    <td><?= $this->Number->format($exhibition->email_notice) ?></td>
                </tr>
                <tr>
                    <th><?= __('Additional') ?></th>
                    <td><?= $this->Number->format($exhibition->additional) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($exhibition->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apply Sdate') ?></th>
                    <td><?= h($exhibition->apply_sdate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Apply Edate') ?></th>
                    <td><?= h($exhibition->apply_edate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sdate') ?></th>
                    <td><?= h($exhibition->sdate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Edate') ?></th>
                    <td><?= h($exhibition->edate) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($exhibition->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($exhibition->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Detail Html') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($exhibition->detail_html)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($exhibition->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Password') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Hp') ?></th>
                            <th><?= __('Hp Cert') ?></th>
                            <th><?= __('Birthday') ?></th>
                            <th><?= __('Sex') ?></th>
                            <th><?= __('Company') ?></th>
                            <th><?= __('Title') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Refer') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->email) ?></td>
                            <td><?= h($users->password) ?></td>
                            <td><?= h($users->name) ?></td>
                            <td><?= h($users->hp) ?></td>
                            <td><?= h($users->hp_cert) ?></td>
                            <td><?= h($users->birthday) ?></td>
                            <td><?= h($users->sex) ?></td>
                            <td><?= h($users->company) ?></td>
                            <td><?= h($users->title) ?></td>
                            <td><?= h($users->status) ?></td>
                            <td><?= h($users->refer) ?></td>
                            <td><?= h($users->created) ?></td>
                            <td><?= h($users->modified) ?></td>
                            <td><?= h($users->ip) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Banner') ?></h4>
                <?php if (!empty($exhibition->banner)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Type') ?></th>
                            <th><?= __('Sdate') ?></th>
                            <th><?= __('Edate') ?></th>
                            <th><?= __('Img Path') ?></th>
                            <th><?= __('Img Name') ?></th>
                            <th><?= __('Sort') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->banner as $banner) : ?>
                        <tr>
                            <td><?= h($banner->id) ?></td>
                            <td><?= h($banner->exhibition_id) ?></td>
                            <td><?= h($banner->type) ?></td>
                            <td><?= h($banner->sdate) ?></td>
                            <td><?= h($banner->edate) ?></td>
                            <td><?= h($banner->img_path) ?></td>
                            <td><?= h($banner->img_name) ?></td>
                            <td><?= h($banner->sort) ?></td>
                            <td><?= h($banner->status) ?></td>
                            <td><?= h($banner->created) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Banner', 'action' => 'view', $banner->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Banner', 'action' => 'edit', $banner->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Banner', 'action' => 'delete', $banner->id], ['confirm' => __('Are you sure you want to delete # {0}?', $banner->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Exhibition File') ?></h4>
                <?php if (!empty($exhibition->exhibition_file)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('File Path') ?></th>
                            <th><?= __('File Name') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->exhibition_file as $exhibitionFile) : ?>
                        <tr>
                            <td><?= h($exhibitionFile->id) ?></td>
                            <td><?= h($exhibitionFile->exhibition_id) ?></td>
                            <td><?= h($exhibitionFile->name) ?></td>
                            <td><?= h($exhibitionFile->file_path) ?></td>
                            <td><?= h($exhibitionFile->file_name) ?></td>
                            <td><?= h($exhibitionFile->status) ?></td>
                            <td><?= h($exhibitionFile->created) ?></td>
                            <td><?= h($exhibitionFile->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionFile', 'action' => 'view', $exhibitionFile->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionFile', 'action' => 'edit', $exhibitionFile->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionFile', 'action' => 'delete', $exhibitionFile->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionFile->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Exhibition Group') ?></h4>
                <?php if (!empty($exhibition->exhibition_group)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('People') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->exhibition_group as $exhibitionGroup) : ?>
                        <tr>
                            <td><?= h($exhibitionGroup->id) ?></td>
                            <td><?= h($exhibitionGroup->exhibition_id) ?></td>
                            <td><?= h($exhibitionGroup->name) ?></td>
                            <td><?= h($exhibitionGroup->people) ?></td>
                            <td><?= h($exhibitionGroup->amount) ?></td>
                            <td><?= h($exhibitionGroup->created) ?></td>
                            <td><?= h($exhibitionGroup->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionGroup', 'action' => 'view', $exhibitionGroup->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionGroup', 'action' => 'edit', $exhibitionGroup->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionGroup', 'action' => 'delete', $exhibitionGroup->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionGroup->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Exhibition Stream') ?></h4>
                <?php if (!empty($exhibition->exhibition_stream)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Pay Id') ?></th>
                            <th><?= __('Coupon Id') ?></th>
                            <th><?= __('Time') ?></th>
                            <th><?= __('People') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Coupon Amount') ?></th>
                            <th><?= __('Url') ?></th>
                            <th><?= __('Ip') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->exhibition_stream as $exhibitionStream) : ?>
                        <tr>
                            <td><?= h($exhibitionStream->id) ?></td>
                            <td><?= h($exhibitionStream->exhibition_id) ?></td>
                            <td><?= h($exhibitionStream->pay_id) ?></td>
                            <td><?= h($exhibitionStream->coupon_id) ?></td>
                            <td><?= h($exhibitionStream->time) ?></td>
                            <td><?= h($exhibitionStream->people) ?></td>
                            <td><?= h($exhibitionStream->amount) ?></td>
                            <td><?= h($exhibitionStream->coupon_amount) ?></td>
                            <td><?= h($exhibitionStream->url) ?></td>
                            <td><?= h($exhibitionStream->ip) ?></td>
                            <td><?= h($exhibitionStream->created) ?></td>
                            <td><?= h($exhibitionStream->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionStream', 'action' => 'view', $exhibitionStream->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionStream', 'action' => 'edit', $exhibitionStream->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionStream', 'action' => 'delete', $exhibitionStream->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionStream->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Exhibition Survey') ?></h4>
                <?php if (!empty($exhibition->exhibition_survey)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Exhibition Id') ?></th>
                            <th><?= __('Survey Type') ?></th>
                            <th><?= __('Parent Id') ?></th>
                            <th><?= __('Text') ?></th>
                            <th><?= __('Is Duplicate') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($exhibition->exhibition_survey as $exhibitionSurvey) : ?>
                        <tr>
                            <td><?= h($exhibitionSurvey->id) ?></td>
                            <td><?= h($exhibitionSurvey->exhibition_id) ?></td>
                            <td><?= h($exhibitionSurvey->survey_type) ?></td>
                            <td><?= h($exhibitionSurvey->parent_id) ?></td>
                            <td><?= h($exhibitionSurvey->text) ?></td>
                            <td><?= h($exhibitionSurvey->is_duplicate) ?></td>
                            <td><?= h($exhibitionSurvey->created) ?></td>
                            <td><?= h($exhibitionSurvey->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ExhibitionSurvey', 'action' => 'view', $exhibitionSurvey->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ExhibitionSurvey', 'action' => 'edit', $exhibitionSurvey->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ExhibitionSurvey', 'action' => 'delete', $exhibitionSurvey->id], ['confirm' => __('Are you sure you want to delete # {0}?', $exhibitionSurvey->id)]) ?>
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
