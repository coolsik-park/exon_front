<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pay Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ManagersTable&\Cake\ORM\Association\BelongsTo $Managers
 * @property \App\Model\Table\ExhibitionStreamTable&\Cake\ORM\Association\HasMany $ExhibitionStream
 * @property \App\Model\Table\ExhibitionUsersTable&\Cake\ORM\Association\HasMany $ExhibitionUsers
 *
 * @method \App\Model\Entity\Pay newEmptyEntity()
 * @method \App\Model\Entity\Pay newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Pay[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pay get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pay findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Pay patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pay[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pay|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pay saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pay[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pay[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pay[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Pay[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PayTable extends Table
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

        $this->setTable('pay');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
        ]);
        $this->belongsTo('Managers', [
            'foreignKey' => 'managers_id',
        ]);
        $this->hasMany('ExhibitionStream', [
            'foreignKey' => 'pay_id',
        ]);
        $this->hasMany('ExhibitionUsers', [
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
            ->scalar('product_type')
            ->maxLength('product_type', 2)
            ->notEmptyString('product_type');

        $validator
            ->scalar('merchant_uid')
            ->maxLength('merchant_uid', 128)
            ->allowEmptyString('merchant_uid');

        $validator
            ->scalar('pg_tid')
            ->maxLength('pg_tid', 128)
            ->allowEmptyString('pg_tid');

        $validator
            ->scalar('pay_method')
            ->maxLength('pay_method', 16)
            ->allowEmptyString('pay_method');

        $validator
            ->integer('amount')
            ->notEmptyString('amount');

        $validator
            ->integer('pay_amount')
            ->notEmptyString('pay_amount');

        $validator
            ->integer('coupon_amount')
            ->notEmptyString('coupon_amount');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->scalar('receipt_url')
            ->maxLength('receipt_url', 1024)
            ->allowEmptyString('receipt_url');

        $validator
            ->dateTime('pay_date')
            ->allowEmptyDateTime('pay_date');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 16)
            ->allowEmptyString('ip');

        $validator
            ->integer('cancel_amount')
            ->notEmptyString('cancel_amount');

        $validator
            ->dateTime('cancel_date')
            ->allowEmptyDateTime('cancel_date');

        $validator
            ->scalar('cancel_reason')
            ->maxLength('cancel_reason', 512)
            ->allowEmptyString('cancel_reason');

        $validator
            ->dateTime('fail_date')
            ->allowEmptyDateTime('fail_date');

        $validator
            ->scalar('fail_reason')
            ->maxLength('fail_reason', 512)
            ->allowEmptyString('fail_reason');

        $validator
            ->scalar('manager_ip')
            ->maxLength('manager_ip', 16)
            ->allowEmptyString('manager_ip');

        $validator
            ->scalar('imp_uid')
            ->maxLength('imp_uid', 128)
            ->allowEmptyString('imp_uid');

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
        // $rules->add($rules->existsIn(['users_id'], 'Users'), ['errorField' => 'users_id']);
        // $rules->add($rules->existsIn(['managers_id'], 'Managers'), ['errorField' => 'managers_id']);

        return $rules;
    }
}
