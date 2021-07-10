<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExhibitionUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExhibitionUsersTable Test Case
 */
class ExhibitionUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ExhibitionUsersTable
     */
    protected $ExhibitionUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ExhibitionUsers',
        'app.Exhibition',
        'app.ExhibitionGroup',
        'app.Users',
        'app.Pay',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ExhibitionUsers') ? [] : ['className' => ExhibitionUsersTable::class];
        $this->ExhibitionUsers = $this->getTableLocator()->get('ExhibitionUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ExhibitionUsers);

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
