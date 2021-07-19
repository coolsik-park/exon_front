<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserQuestion Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\FaqCategoryTable&\Cake\ORM\Association\BelongsTo $FaqCategory
 * @property \App\Model\Table\ManagersTable&\Cake\ORM\Association\BelongsTo $Managers
 * @property \App\Model\Table\UserQuestionFilesTable&\Cake\ORM\Association\HasMany $UserQuestionFiles
 *
 * @method \App\Model\Entity\UserQuestion newEmptyEntity()
 * @method \App\Model\Entity\UserQuestion newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestion[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestion get($primaryKey, $options = [])
 * @method \App\Model\Entity\UserQuestion findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\UserQuestion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestion[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserQuestion|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserQuestion saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\UserQuestion[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestion[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestion[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\UserQuestion[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UserQuestionTable extends Table
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

        $this->setTable('user_question');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
        ]);
        $this->belongsTo('FaqCategory', [
            'foreignKey' => 'faq_category_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Managers', [
            'foreignKey' => 'managers_id',
        ]);
        $this->hasMany('UserQuestionFiles', [
            'foreignKey' => 'user_question_id',
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
            ->scalar('users_name')
            ->maxLength('users_name', 45)
            ->allowEmptyString('users_name');

        $validator
            ->scalar('title')
            ->maxLength('title', 128)
            ->allowEmptyString('title');

        $validator
            ->scalar('users_hp')
            ->maxLength('users_hp', 16)
            ->allowEmptyString('users_hp');

        $validator
            ->scalar('users_email')
            ->maxLength('users_email', 255)
            ->allowEmptyString('users_email');

        $validator
            ->scalar('question')
            ->requirePresence('question', 'create')
            ->notEmptyString('question');

        $validator
            ->scalar('answer')
            ->allowEmptyString('answer');

        $validator
            ->scalar('ip')
            ->maxLength('ip', 18)
            ->allowEmptyString('ip');

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
        $rules->add($rules->existsIn(['users_id'], 'Users'), ['errorField' => 'users_id']);
        $rules->add($rules->existsIn(['faq_category_id'], 'FaqCategory'), ['errorField' => 'faq_category_id']);
        $rules->add($rules->existsIn(['managers_id'], 'Managers'), ['errorField' => 'managers_id']);

        return $rules;
    }
}
