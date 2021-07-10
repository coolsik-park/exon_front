<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionUsers Model
 *
 * @property \App\Model\Table\ExhibitionTable&\Cake\ORM\Association\BelongsTo $Exhibition
 * @property \App\Model\Table\ExhibitionGroupTable&\Cake\ORM\Association\BelongsTo $ExhibitionGroup
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\PayTable&\Cake\ORM\Association\BelongsTo $Pay
 *
 * @method \App\Model\Entity\ExhibitionUser newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionUser findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionUser[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionUser[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionUser[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionUser[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionUsersTable extends Table
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

        $this->setTable('exhibition_users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Exhibition', [
            'foreignKey' => 'exhibition_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ExhibitionGroup', [
            'foreignKey' => 'exhibition_group_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
        ]);
        $this->belongsTo('Pay', [
            'foreignKey' => 'pay_id',
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
            ->scalar('users_email')
            ->maxLength('users_email', 255)
            ->allowEmptyString('users_email');

        $validator
            ->scalar('users_name')
            ->maxLength('users_name', 45)
            ->requirePresence('users_name', 'create')
            ->notEmptyString('users_name');

        $validator
            ->scalar('users_hp')
            ->maxLength('users_hp', 16)
            ->allowEmptyString('users_hp');

        $validator
            ->scalar('users_group')
            ->maxLength('users_group', 45)
            ->allowEmptyString('users_group');

        $validator
            ->scalar('users_sex')
            ->maxLength('users_sex', 1)
            ->allowEmptyString('users_sex');

        $validator
            ->integer('pay_amount')
            ->allowEmptyString('pay_amount');

        $validator
            ->integer('status')
            ->notEmptyString('status');

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
        $rules->add($rules->existsIn(['exhibition_group_id'], 'ExhibitionGroup'), ['errorField' => 'exhibition_group_id']);
        $rules->add($rules->existsIn(['users_id'], 'Users'), ['errorField' => 'users_id']);
        $rules->add($rules->existsIn(['pay_id'], 'Pay'), ['errorField' => 'pay_id']);

        return $rules;
    }
}
