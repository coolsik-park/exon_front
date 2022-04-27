<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionVodTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionVodTable Test Case
 */
class ExhibitionVodTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionVodTable
     */
    protected $ExhibitionVod;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionVod',
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
        $config = $this->getTableLocator()->exists('ExhibitionVod') ? [] : ['className' => ExhibitionVodTable::class];
        $this->ExhibitionVod = $this->getTableLocator()->get('ExhibitionVod', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionVod);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionVodTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionVodTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
