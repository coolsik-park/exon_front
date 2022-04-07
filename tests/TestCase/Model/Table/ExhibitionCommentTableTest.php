<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionCommentTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionCommentTable Test Case
 */
class ExhibitionCommentTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionCommentTable
     */
    protected $ExhibitionComment;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionComment',
        'app.ExhibitionStream',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionComment') ? [] : ['className' => ExhibitionCommentTable::class];
        $this->ExhibitionComment = $this->getTableLocator()->get('ExhibitionComment', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionComment);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionCommentTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ExhibitionCommentTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
