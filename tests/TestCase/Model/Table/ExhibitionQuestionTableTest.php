<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionQuestionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionQuestionTable Test Case
 */
class ExhibitionQuestionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionQuestionTable
     */
    protected $ExhibitionQuestion;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionQuestion',
        'app.ExhibitionUsers',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionQuestion') ? [] : ['className' => ExhibitionQuestionTable::class];
        $this->ExhibitionQuestion = $this->getTableLocator()->get('ExhibitionQuestion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionQuestion);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionQuestionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionQuestionTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
