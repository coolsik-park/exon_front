<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionQuestion Model
 *
 * @property \App\Model\Table\ExhibitionUsersTable&\Cake\ORM\Association\BelongsTo $ExhibitionUsers
 * @property \App\Model\Table\ExhibitionUsersTable&\Cake\ORM\Association\BelongsTo $ExhibitionUsers
 * @property \App\Model\Table\ExhibitionQuestionTable&\Cake\ORM\Association\BelongsTo $ParentExhibitionQuestion
 * @property \App\Model\Table\ExhibitionQuestionTable&\Cake\ORM\Association\HasMany $ChildExhibitionQuestion
 *
 * @method \App\Model\Entity\ExhibitionQuestion newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionQuestion newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionQuestion[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionQuestionTable extends Table
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

        $this->setTable('exhibition_question');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ExhibitionUsers', [
            'foreignKey' => 'exhibition_users_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ExhibitionUsers', [
            'foreignKey' => 'exhibition_users_id',
        ]);
        $this->belongsTo('ParentExhibitionQuestion', [
            'className' => 'ExhibitionQuestion',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildExhibitionQuestion', [
            'className' => 'ExhibitionQuestion',
            'foreignKey' => 'parent_id',
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
            ->scalar('target_users_name')
            ->maxLength('target_users_name', 45)
            ->allowEmptyString('target_users_name');

        $validator
            ->scalar('contents')
            ->requirePresence('contents', 'create')
            ->notEmptyString('contents');

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
        $rules->add($rules->existsIn(['exhibition_users_id'], 'ExhibitionUsers'), ['errorField' => 'exhibition_users_id']);
        $rules->add($rules->existsIn(['target_users_id'], 'ExhibitionUsers'), ['errorField' => 'target_users_id']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentExhibitionQuestion'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
