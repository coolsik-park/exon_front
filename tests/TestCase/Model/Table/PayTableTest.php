<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayTable Test Case
 */
class PayTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PayTable
     */
    protected $Pay;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Pay',
        'app.Users',
        'app.Managers',
        'app.ExhibitionStream',
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
        $config = $this->getTableLocator()->exists('Pay') ? [] : ['className' => PayTable::class];
        $this->Pay = $this->getTableLocator()->get('Pay', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Pay);

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
