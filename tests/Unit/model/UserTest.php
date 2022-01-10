<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $user;

    public function setup() : void
    {
        parent::setUp();
        $this->user = new User();
    }

    public function tearDown() : void
    {
        unset($this->user);
        parent::tearDown();
    }

    public function testUserHasManyOrders()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->orders());
    }

    public function testUserHasManyComments()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->comments());
    }

    public function testUserHasManyRatings()
    {
        $this->assertInstanceOf(HasMany::class, $this->user->ratings());
    }

    public function testUserBelongToRole()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->user->role());
    }

    public function testFieldAreFillable()
    {
        $fillable = [
            'role_id',
            'name',
            'email',
            'phone',
            'image',
            'address',
            'status',
            'password',
        ];

        $this->assertEquals($fillable, $this->user->getFillable());
    }

    public function testFieldAreHidden()
    {
        $hidden = [
            'remember_token',
        ];

        $this->assertEquals($hidden, $this->user->getHidden());
    }
}
