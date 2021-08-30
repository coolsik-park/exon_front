<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CommonCategory Model
 *
 * @method \App\Model\Entity\CommonCategory newEmptyEntity()
 * @method \App\Model\Entity\CommonCategory newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\CommonCategory[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CommonCategory get($primaryKey, $options = [])
 * @method \App\Model\Entity\CommonCategory findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\CommonCategory patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CommonCategory[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CommonCategory|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommonCategory saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CommonCategory[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonCategory[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonCategory[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\CommonCategory[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CommonCategoryTable extends Table
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

        $this->setTable('common_category');
        $this->setDisplayField('title');
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
            ->scalar('table')
            ->maxLength('table', 45)
            ->requirePresence('table', 'create')
            ->notEmptyString('table');

        $validator
            ->scalar('type')
            ->maxLength('type', 45)
            ->requirePresence('type', 'create')
            ->notEmptyString('type');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');
        
        $validator
            ->integer('code')
            ->maxLength('code', 11)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        return $validator;
    }
}
