<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NoticeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NoticeTable Test Case
 */
class NoticeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\NoticeTable
     */
    protected $Notice;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Notice',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Notice') ? [] : ['className' => NoticeTable::class];
        $this->Notice = $this->getTableLocator()->get('Notice', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Notice);

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
