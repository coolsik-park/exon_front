<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqCategoryTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqCategoryTable Test Case
 */
class FaqCategoryTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqCategoryTable
     */
    protected $FaqCategory;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.FaqCategory',
        'app.Managers',
        'app.UserQuestion',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FaqCategory') ? [] : ['className' => FaqCategoryTable::class];
        $this->FaqCategory = $this->getTableLocator()->get('FaqCategory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->FaqCategory);

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
