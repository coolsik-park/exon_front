<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionStreamDefaultPriceTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionStreamDefaultPriceTable Test Case
 */
class ExhibitionStreamDefaultPriceTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionStreamDefaultPriceTable
     */
    protected $ExhibitionStreamDefaultPrice;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionStreamDefaultPrice',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionStreamDefaultPrice') ? [] : ['className' => ExhibitionStreamDefaultPriceTable::class];
        $this->ExhibitionStreamDefaultPrice = $this->getTableLocator()->get('ExhibitionStreamDefaultPrice', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionStreamDefaultPrice);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionStreamDefaultPriceTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
