<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserQuestionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserQuestionTable Test Case
 */
class UserQuestionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserQuestionTable
     */
    protected $UserQuestion;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.UserQuestion',
        'app.Users',
        'app.FaqCategory',
        'app.Managers',
        'app.UserQuestionFiles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserQuestion') ? [] : ['className' => UserQuestionTable::class];
        $this->UserQuestion = $this->getTableLocator()->get('UserQuestion', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->UserQuestion);

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
