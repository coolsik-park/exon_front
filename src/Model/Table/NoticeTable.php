<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Notice Model
 *
 * @method \App\Model\Entity\Notice newEmptyEntity()
 * @method \App\Model\Entity\Notice newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Notice[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Notice get($primaryKey, $options = [])
 * @method \App\Model\Entity\Notice findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Notice patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Notice[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Notice|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notice saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Notice[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Notice[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Notice[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Notice[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class NoticeTable extends Table
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

        $this->setTable('notice');
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
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('content')
            ->requirePresence('content', 'create')
            ->notEmptyString('content');

        $validator
            ->scalar('file_path')
            ->maxLength('file_path', 255)
            ->allowEmptyFile('file_path');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyFile('file_name');

        $validator
            ->scalar('file_type')
            ->maxLength('file_type', 45)
            ->allowEmptyFile('file_type');

        $validator
            ->integer('status')
            ->notEmptyString('status');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 18)
            ->allowEmptyString('ip');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyFile('file_name');

        $validator
            ->scalar('file_type')
            ->maxLength('file_type', 45)
            ->allowEmptyFile('file_type');

        return $validator;
    }
}
