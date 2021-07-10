<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BannerTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BannerTable Test Case
 */
class BannerTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BannerTable
     */
    protected $Banner;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Banner',
        'app.Exhibition',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Banner') ? [] : ['className' => BannerTable::class];
        $this->Banner = $this->getTableLocator()->get('Banner', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Banner);

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
