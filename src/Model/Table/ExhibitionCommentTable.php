<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ExhibitionComment Model
 *
 * @property \App\Model\Table\ExhibitionStreamTable&\Cake\ORM\Association\BelongsTo $ExhibitionStream
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ExhibitionCommentTable&\Cake\ORM\Association\BelongsTo $ParentExhibitionComment
 * @property \App\Model\Table\ExhibitionCommentTable&\Cake\ORM\Association\HasMany $ChildExhibitionComment
 *
 * @method \App\Model\Entity\ExhibitionComment newEmptyEntity()
 * @method \App\Model\Entity\ExhibitionComment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionComment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionComment get($primaryKey, $options = [])
 * @method \App\Model\Entity\ExhibitionComment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\ExhibitionComment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionComment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ExhibitionComment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionComment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ExhibitionComment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionComment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionComment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\ExhibitionComment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ExhibitionCommentTable extends Table
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

        $this->setTable('exhibition_comment');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ExhibitionStream', [
            'foreignKey' => 'exhibition_stream_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'users_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ParentExhibitionComment', [
            'className' => 'ExhibitionComment',
            'foreignKey' => 'parent_id',
        ]);
        $this->hasMany('ChildExhibitionComment', [
            'className' => 'ExhibitionComment',
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
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        $validator
            ->integer('liked')
            ->allowEmptyString('liked');

        $validator
            ->scalar('user_name')
            ->maxLength('user_name', 45)
            ->requirePresence('user_name', 'create')
            ->notEmptyString('user_name');

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
        $rules->add($rules->existsIn(['exhibition_stream_id'], 'ExhibitionStream'), ['errorField' => 'exhibition_stream_id']);
        $rules->add($rules->existsIn(['users_id'], 'Users'), ['errorField' => 'users_id']);
        $rules->add($rules->existsIn(['parent_id'], 'ParentExhibitionComment'), ['errorField' => 'parent_id']);

        return $rules;
    }
}
