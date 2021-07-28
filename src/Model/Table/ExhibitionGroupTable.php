<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionGroup Model
 *
 * @property \App\Model\Table\ExhibitionTable&\Cake\ORM\Association\BelongsTo $Exhibition
 * @property \App\Model\Table\ExhibitionUsersTable&\Cake\ORM\Association\HasMany $ExhibitionUsers
 *
 * @method \App\Model\Entity\ExhibitionGroup newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionGroupTable extends Table
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

        $this->setTable('exhibition_group');
        $this->setDisplayField(['name', 'amount']);
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Exhibition', [
            'foreignKey' => 'exhibition_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('ExhibitionUsers', [
            'foreignKey' => 'exhibition_group_id',
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
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('people')
            ->notEmptyString('people');

        $validator
            ->integer('amount')
            ->notEmptyString('amount');

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

        return $rules;
    }
}
