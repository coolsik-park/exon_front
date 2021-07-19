<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommonCategoryTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommonCategoryTable Test Case
 */
class CommonCategoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommonCategoryTable
     */
    protected $CommonCategory;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CommonCategory',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CommonCategory') ? [] : ['className' => CommonCategoryTable::class];
        $this->CommonCategory = $this->getTableLocator()->get('CommonCategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CommonCategory);

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
