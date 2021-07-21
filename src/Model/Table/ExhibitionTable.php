<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Exhibition Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\BannerTable&\Cake\ORM\Association\HasMany $Banner
 * @property \App\Model\Table\ExhibitionFileTable&\Cake\ORM\Association\HasMany $ExhibitionFile
 * @property \App\Model\Table\ExhibitionGroupTable&\Cake\ORM\Association\HasMany $ExhibitionGroup
 * @property \App\Model\Table\ExhibitionStreamTable&\Cake\ORM\Association\HasMany $ExhibitionStream
 * @property \App\Model\Table\ExhibitionSurveyTable&\Cake\ORM\Association\HasMany $ExhibitionSurvey
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsToMany $Users
 *
 * @method \App\Model\Entity\Exhibition newEmptyEntity()
 * @method \App\Model\Entity\Exhibition newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Exhibition[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Exhibition get($primaryKey, $options = [])
 * @method \App\Model\Entity\Exhibition findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Exhibition patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Exhibition[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Exhibition|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Exhibition saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Exhibition[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionTable extends Table
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

        $this->setTable('exhibition');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
        ]);
        $this->hasMany('Banner', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->hasMany('ExhibitionFile', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->hasMany('ExhibitionGroup', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->hasMany('ExhibitionStream', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->hasMany('ExhibitionSurvey', [
            'foreignKey' => 'exhibition_id',
        ]);
        $this->belongsTo('CommonCategory', [
            'foreignKey' => 'common_category_id'
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'exhibition_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'exhibition_users',
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
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->allowEmptyString('description');

        $validator
            ->scalar('category')
            ->maxLength('category', 64)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        $validator
            ->scalar('type')
            ->maxLength('type', 64)
            ->allowEmptyString('type');

        $validator
            ->scalar('detail_html')
            ->allowEmptyString('detail_html');

        $validator
            ->dateTime('apply_sdate')
            ->allowEmptyDateTime('apply_sdate');

        $validator
            ->dateTime('apply_edate')
            ->allowEmptyDateTime('apply_edate');

        $validator
            ->dateTime('sdate')
            ->allowEmptyDateTime('sdate');

        $validator
            ->dateTime('edate')
            ->allowEmptyDateTime('edate');

        $validator
            ->scalar('image_path')
            ->maxLength('image_path', 255)
            ->allowEmptyFile('image_path');

        $validator
            ->scalar('image_name')
            ->maxLength('image_name', 128)
            ->allowEmptyFile('image_name');

        $validator
            ->integer('private')
            ->notEmptyString('private');

        $validator
            ->integer('auto_approval')
            ->notEmptyString('auto_approval');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 16)
            ->requirePresence('tel', 'create')
            ->notEmptyString('tel');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->integer('require_name')
            ->notEmptyString('require_name');

        $validator
            ->integer('require_email')
            ->notEmptyString('require_email');

        $validator
            ->integer('require_tel')
            ->notEmptyString('require_tel');

        $validator
            ->integer('require_age')
            ->notEmptyString('require_age');

        $validator
            ->integer('require_group')
            ->notEmptyString('require_group');

        $validator
            ->integer('require_sex')
            ->notEmptyString('require_sex');

        $validator
            ->integer('require_cert')
            ->notEmptyString('require_cert');

        $validator
            ->integer('email_notice')
            ->notEmptyString('email_notice');

        $validator
            ->integer('additional')
            ->notEmptyString('additional');

        $validator
            ->integer('status')
            ->notEmptyString('status');

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

        return $rules;
    }
}
