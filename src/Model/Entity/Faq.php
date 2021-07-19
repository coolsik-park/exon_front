<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Faq Entity
 *
 * @property int $id
 * @property int $faq_category_id
 * @property string $title
 * @property string $content
 * @property string|null $file_path
 * @property int|null $type
 * @property int $is_main
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $ip
 *
 * @property \App\Model\Entity\FaqCategory $faq_category
 */
class Faq extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'faq_category_id' => true,
        'title' => true,
        'content' => true,
        'file_path' => true,
        'type' => true,
        'is_main' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'ip' => true,
        'faq_category' => true,
    ];
}
