<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionStreamChatLogTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionStreamChatLogTable Test Case
 */
class ExhibitionStreamChatLogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionStreamChatLogTable
     */
    protected $ExhibitionStreamChatLog;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionStreamChatLog',
        'app.ExhibitionStream',
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
        $config = $this->getTableLocator()->exists('ExhibitionStreamChatLog') ? [] : ['className' => ExhibitionStreamChatLogTable::class];
        $this->ExhibitionStreamChatLog = $this->getTableLocator()->get('ExhibitionStreamChatLog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionStreamChatLog);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionStreamChatLogTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionStreamChatLogTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
