<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FaqTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FaqTable Test Case
 */
class FaqTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FaqTable
     */
    protected $Faq;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Faq',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Faq') ? [] : ['className' => FaqTable::class];
        $this->Faq = $this->getTableLocator()->get('Faq', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Faq);

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
