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
            ->requirePresence('product_type', 'create')
            ->notEmptyString('product_type');

        return $validator;
    }
}
