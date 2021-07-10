<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionTable Test Case
 */
class ExhibitionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionTable
     */
    protected $Exhibition;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Exhibition',
        'app.Users',
        'app.Banner',
        'app.ExhibitionFile',
        'app.ExhibitionGroup',
        'app.ExhibitionSurvey',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Exhibition') ? [] : ['className' => ExhibitionTable::class];
        $this->Exhibition = $this->getTableLocator()->get('Exhibition', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Exhibition);

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
