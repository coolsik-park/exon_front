<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionSurveyUsersAnswer Model
 *
 * @property \App\Model\Table\ExhibitionSurveyTable&\Cake\ORM\Association\BelongsTo $ExhibitionSurvey
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ExhibitionSurveyUsersAnswerTable&\Cake\ORM\Association\BelongsTo $ParentExhibitionSurveyUsersAnswer
 * @property \App\Model\Table\ExhibitionSurveyUsersAnswerTable&\Cake\ORM\Association\HasMany $ChildExhibitionSurveyUsersAnswer
 *
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurveyUsersAnswer[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionSurveyUsersAnswerTable extends Table
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

        $this->setTable('exhibition_survey_users_answer');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ExhibitionSurvey', [
            'foreignKey' => 'exhibition_survey_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ExhibitionUsers', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentExhibitionSurveyUsersAnswer', [
            'className' => 'ExhibitionSurveyUsersAnswer',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildExhibitionSurveyUsersAnswer', [
            'className' => 'ExhibitionSurveyUsersAnswer',
            'foreignKey' => 'parent_id',
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
            ->scalar('text')
            ->maxLength('text', 2048)
            ->requirePresence('text', 'create')
            ->allowEmptyString('text');
        
        $validator
            ->scalar('is_multiple')
            ->maxLength('is_multiple', 2)
            ->allowEmptyString('is_multiple');

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
        $rules->add($rules->existsIn(['exhibition_survey_id'], 'ExhibitionSurvey'), ['errorField' => 'exhibition_survey_id']);
        $rules->add($rules->existsIn(['users_id'], 'Users'), ['errorField' => 'users_id']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentExhibitionSurveyUsersAnswer'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
