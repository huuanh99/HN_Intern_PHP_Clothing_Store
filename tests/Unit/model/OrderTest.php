<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $order;

    public function setup() : void
    {
        parent::setUp();
        $this->order = new Order();
    }

    public function tearDown() : void
    {
        unset($this->order);
        parent::tearDown();
    }

    public function testOrderBelongToUser()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->order->user());
    }

    public function testOrderHasManyOrderDetails()
    {
        $this->assertInstanceOf(HasMany::class, $this->order->orderDetails());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'user_id',
            'address',
            'phone',
            'status',
            'total',
        ];

        $this->assertEquals($inputs, $this->order->getFillable());
    }
}
