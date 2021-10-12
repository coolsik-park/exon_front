<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionStreamDefaultPrice Model
 *
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionStreamDefaultPrice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionStreamDefaultPriceTable extends Table
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

        $this->setTable('exhibition_stream_default_price');
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
            ->integer('people')
            ->allowEmptyString('people');

        $validator
            ->integer('halfday_price')
            ->allowEmptyString('halfday_price');

        $validator
            ->integer('allday_price')
            ->allowEmptyString('allday_price');

        $validator
            ->dateTime('create')
            ->notEmptyDateTime('create');

        return $validator;
    }
}
