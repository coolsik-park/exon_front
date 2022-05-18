<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionVodViewer Model
 *
 * @property \App\Model\Table\ExhibitionVodTable&\Cake\ORM\Association\BelongsTo $ExhibitionVod
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\ExhibitionVodViewer newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionVodViewer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionVodViewer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionVodViewerTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('exhibition_vod_viewer');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Exhibition', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->belongsTo('ExhibitionVod', [
            'foreignKey' => 'exhibition_vod_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->integer('watching_duration')
            ->allowEmptyString('watching_duration');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['exhibition_id'], 'Exhibition'), ['errorField' => 'exhibition_id']);
        $rules->add($rules->existsIn(['exhibition_vod_id'], 'ExhibitionVod'), ['errorField' => 'exhibition_vod_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
