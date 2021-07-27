<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommonConfirmationTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommonConfirmationTable Test Case
 */
class CommonConfirmationTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommonConfirmationTable
     */
    protected $CommonConfirmation;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CommonConfirmation',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CommonConfirmation') ? [] : ['className' => CommonConfirmationTable::class];
        $this->CommonConfirmation = $this->getTableLocator()->get('CommonConfirmation', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CommonConfirmation);

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
}
