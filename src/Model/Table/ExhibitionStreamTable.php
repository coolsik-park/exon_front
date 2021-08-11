<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionStream Model
 *
 * @property \App\Model\Table\ExhibitionTable&\Cake\ORM\Association\BelongsTo $Exhibition
 * @property \App\Model\Table\PayTable&\Cake\ORM\Association\BelongsTo $Pay
 * @property \App\Model\Table\CouponTable&\Cake\ORM\Association\BelongsTo $Coupon
 * @property \App\Model\Table\ExhibitionStreamChatLogTable&\Cake\ORM\Association\HasMany $ExhibitionStreamChatLog
 *
 * @method \App\Model\Entity\ExhibitionStream newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionStream newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStream[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStream get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionStream findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionStream patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStream[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStream|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionStream saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionStream[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStream[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStream[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStream[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionStreamTable extends Table
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

        $this->setTable('exhibition_stream');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Exhibition', [
            'foreignKey' => 'exhibition_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Pay', [
            'foreignKey' => 'pay_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Coupon', [
            'foreignKey' => 'coupon_id',
        ]);
        $this->hasMany('ExhibitionStreamChatLog', [
            'foreignKey' => 'exhibition_stream_id',
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
            ->scalar('title')
            ->maxLength('title', 100)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 100)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('stream_key')
            ->maxLength('stream_key', 64)
            ->notEmptyString('stream_key');

        $validator
            ->integer('time')
            ->notEmptyString('time');

        $validator
            ->integer('people')
            ->notEmptyString('people');

        $validator
            ->integer('amount')
            ->notEmptyString('amount');

        $validator
            ->integer('coupon_amount')
            ->notEmptyString('coupon_amount');

        $validator
            ->scalar('url')
            ->maxLength('url', 2048)
            ->allowEmptyString('url');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 32)
            ->requirePresence('ip', 'create')
            ->notEmptyString('ip');

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
        // $rules->add($rules->existsIn(['exhibition_id'], 'Exhibition'), ['errorField' => 'exhibition_id']);
        // $rules->add($rules->existsIn(['pay_id'], 'Pay'), ['errorField' => 'pay_id']);
        // $rules->add($rules->existsIn(['coupon_id'], 'Coupon'), ['errorField' => 'coupon_id']);

        return $rules;
    }
}
