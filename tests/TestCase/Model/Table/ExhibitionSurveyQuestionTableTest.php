<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionSurveyQuestionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionSurveyQuestionTable Test Case
 */
class ExhibitionSurveyQuestionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionSurveyQuestionTable
     */
    protected $ExhibitionSurveyQuestion;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionSurveyQuestion',
        'app.Exhibition',
        'app.ExhibitionSurveyAnswer',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionSurveyQuestion') ? [] : ['className' => ExhibitionSurveyQuestionTable::class];
        $this->ExhibitionSurveyQuestion = $this->getTableLocator()->get('ExhibitionSurveyQuestion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionSurveyQuestion);

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
