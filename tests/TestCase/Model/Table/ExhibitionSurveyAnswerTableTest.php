<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionSurveyAnswerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionSurveyAnswerTable Test Case
 */
class ExhibitionSurveyAnswerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionSurveyAnswerTable
     */
    protected $ExhibitionSurveyAnswer;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionSurveyAnswer',
        'app.ExhibitionSurveyQuestion',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionSurveyAnswer') ? [] : ['className' => ExhibitionSurveyAnswerTable::class];
        $this->ExhibitionSurveyAnswer = $this->getTableLocator()->get('ExhibitionSurveyAnswer', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionSurveyAnswer);

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
