<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionStreamTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionStreamTable Test Case
 */
class ExhibitionStreamTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionStreamTable
     */
    protected $ExhibitionStream;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionStream',
        'app.Exhibition',
        'app.Pay',
        'app.Coupon',
        'app.ExhibitionStreamChatLog',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionStream') ? [] : ['className' => ExhibitionStreamTable::class];
        $this->ExhibitionStream = $this->getTableLocator()->get('ExhibitionStream', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionStream);

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
