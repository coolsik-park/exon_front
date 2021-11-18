<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionSurvey Model
 *
 * @property \App\Model\Table\ExhibitionTable&\Cake\ORM\Association\BelongsTo $Exhibition
 * @property \App\Model\Table\ExhibitionSurveyTable&\Cake\ORM\Association\BelongsTo $ParentExhibitionSurvey
 * @property \App\Model\Table\ExhibitionSurveyTable&\Cake\ORM\Association\HasMany $ChildExhibitionSurvey
 * @property \App\Model\Table\ExhibitionSurveyUsersAnswerTable&\Cake\ORM\Association\HasMany $ExhibitionSurveyUsersAnswer
 *
 * @method \App\Model\Entity\ExhibitionSurvey newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionSurvey newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionSurvey[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionSurveyTable extends Table
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

        $this->setTable('exhibition_survey');
        $this->setDisplayField('text');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Exhibition', [
            'foreignKey' => 'exhibition_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentExhibitionSurvey', [
            'className' => 'ExhibitionSurvey',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildExhibitionSurvey', [
            'className' => 'ExhibitionSurvey',
            'foreignKey' => 'parent_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('ExhibitionSurveyUsersAnswer', [
            'foreignKey' => 'exhibition_survey_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->scalar('survey_type')
            ->maxLength('survey_type', 2)
            ->allowEmptyString('survey_type');

        $validator
            ->scalar('text')
            ->maxLength('text', 2048)
            ->requirePresence('text', 'create')
            ->notEmptyString('text');

        $validator
            ->scalar('is_duplicate')
            ->maxLength('is_duplicate', 2)
            ->allowEmptyString('is_duplicate');

        $validator
            ->scalar('is_required')
            ->maxLength('is_required', 2)
            ->allowEmptyString('is_required');
        
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
        $rules->add($rules->existsIn(['exhibition_id'], 'Exhibition'), ['errorField' => 'exhibition_id']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentExhibitionSurvey'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
