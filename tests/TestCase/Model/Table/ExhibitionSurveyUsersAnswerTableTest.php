<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionSurveyUsersAnswerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionSurveyUsersAnswerTable Test Case
 */
class ExhibitionSurveyUsersAnswerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionSurveyUsersAnswerTable
     */
    protected $ExhibitionSurveyUsersAnswer;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionSurveyUsersAnswer',
        'app.ExhibitionSurvey',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionSurveyUsersAnswer') ? [] : ['className' => ExhibitionSurveyUsersAnswerTable::class];
        $this->ExhibitionSurveyUsersAnswer = $this->getTableLocator()->get('ExhibitionSurveyUsersAnswer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionSurveyUsersAnswer);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
