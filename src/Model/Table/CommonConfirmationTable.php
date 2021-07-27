<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommonConfirmation Model
 *
 * @method \App\Model\Entity\CommonConfirmation newEmptyEntity()
 * @method \App\Model\Entity\CommonConfirmation newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CommonConfirmation[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CommonConfirmation get($primaryKey, $options = [])
 * @method \App\Model\Entity\CommonConfirmation findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CommonConfirmation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CommonConfirmation[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CommonConfirmation|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommonConfirmation saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommonConfirmation[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonConfirmation[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonConfirmation[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonConfirmation[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommonConfirmationTable extends Table
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

        $this->setTable('common_confirmation');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('confirmation_code')
            ->maxLength('confirmation_code', 6)
            ->requirePresence('confirmation_code', 'create')
            ->notEmptyString('confirmation_code');

        $validator
            ->scalar('types')
            ->maxLength('types', 45)
            ->requirePresence('types', 'create')
            ->notEmptyString('types');

        $validator
            ->dateTime('expired')
            ->notEmptyDateTime('expired');

        return $validator;
    }
}
