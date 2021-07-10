<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionSurveyTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionSurveyTable Test Case
 */
class ExhibitionSurveyTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionSurveyTable
     */
    protected $ExhibitionSurvey;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionSurvey',
        'app.Exhibition',
        'app.ExhibitionSurveyUsersAnswer',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionSurvey') ? [] : ['className' => ExhibitionSurveyTable::class];
        $this->ExhibitionSurvey = $this->getTableLocator()->get('ExhibitionSurvey', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionSurvey);

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
