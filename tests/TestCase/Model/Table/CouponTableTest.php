<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CouponTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CouponTable Test Case
 */
class CouponTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CouponTable
     */
    protected $Coupon;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Coupon',
        'app.Users',
        'app.ExhibitionStream',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Coupon') ? [] : ['className' => CouponTable::class];
        $this->Coupon = $this->getTableLocator()->get('Coupon', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Coupon);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CouponTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CouponTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
