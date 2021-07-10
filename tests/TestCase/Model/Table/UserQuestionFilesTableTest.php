<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserQuestionFilesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserQuestionFilesTable Test Case
 */
class UserQuestionFilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserQuestionFilesTable
     */
    protected $UserQuestionFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserQuestionFiles',
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
        $config = $this->getTableLocator()->exists('UserQuestionFiles') ? [] : ['className' => UserQuestionFilesTable::class];
        $this->UserQuestionFiles = $this->getTableLocator()->get('UserQuestionFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserQuestionFiles);

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
