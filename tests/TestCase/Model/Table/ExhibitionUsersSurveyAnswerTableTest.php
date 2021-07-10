<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionUsersSurveyAnswerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionUsersSurveyAnswerTable Test Case
 */
class ExhibitionUsersSurveyAnswerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionUsersSurveyAnswerTable
     */
    protected $ExhibitionUsersSurveyAnswer;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionUsersSurveyAnswer',
        'app.ExhibitionUsers',
        'app.ExhibitionSurveyQuestion',
        'app.ExhibitionSurveyChoice',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionUsersSurveyAnswer') ? [] : ['className' => ExhibitionUsersSurveyAnswerTable::class];
        $this->ExhibitionUsersSurveyAnswer = $this->getTableLocator()->get('ExhibitionUsersSurveyAnswer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionUsersSurveyAnswer);

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
