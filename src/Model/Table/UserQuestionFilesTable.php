<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserQuestionFiles Model
 *
 * @property \App\Model\Table\UserQuestionTable&\Cake\ORM\Association\BelongsTo $UserQuestion
 *
 * @method \App\Model\Entity\UserQuestionFile newEmptyEntity()
 * @method \App\Model\Entity\UserQuestionFile newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestionFile[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestionFile get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserQuestionFile findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UserQuestionFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestionFile[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestionFile|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserQuestionFile saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserQuestionFile[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestionFile[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestionFile[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestionFile[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserQuestionFilesTable extends Table
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

        $this->setTable('user_question_files');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('UserQuestion', [
            'foreignKey' => 'user_question_id',
            'joinType' => 'INNER',
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
            ->scalar('file_path')
            ->maxLength('file_path', 2048)
            ->requirePresence('file_path', 'create')
            ->notEmptyFile('file_path');

        $validator
            ->scalar('file_name')
            ->maxLength('file_name', 255)
            ->allowEmptyFile('file_name');

        $validator
            ->scalar('type')
            ->maxLength('type', 2)
            ->allowEmptyString('type');

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
        $rules->add($rules->existsIn(['user_question_id'], 'UserQuestion'), ['errorField' => 'user_question_id']);

        return $rules;
    }
}
