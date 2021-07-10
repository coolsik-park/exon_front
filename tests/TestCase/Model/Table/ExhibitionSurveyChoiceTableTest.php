<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionSurveyChoiceTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionSurveyChoiceTable Test Case
 */
class ExhibitionSurveyChoiceTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionSurveyChoiceTable
     */
    protected $ExhibitionSurveyChoice;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionSurveyChoice',
        'app.ExhibitionSurveyQuestion',
        'app.Binaries',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionSurveyChoice') ? [] : ['className' => ExhibitionSurveyChoiceTable::class];
        $this->ExhibitionSurveyChoice = $this->getTableLocator()->get('ExhibitionSurveyChoice', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionSurveyChoice);

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
