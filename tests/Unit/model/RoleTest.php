<?php

namespace Tests\Unit\Model;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RoleTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $role;

    public function setup() : void
    {
        parent::setUp();
        $this->role = new Role();
    }

    public function tearDown() : void
    {
        unset($this->role);
        parent::tearDown();
    }

    public function testRoleHasManyUser()
    {
        $this->assertInstanceOf(HasMany::class, $this->role->users());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'name',
        ];

        $this->assertEquals($inputs, $this->role->getFillable());
    }
}
