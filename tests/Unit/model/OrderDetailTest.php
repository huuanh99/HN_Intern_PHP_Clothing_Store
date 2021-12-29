<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderDetailTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $orderdetail;

    public function setup() : void
    {
        parent::setUp();
        $this->orderdetail = new OrderDetail();
    }

    public function tearDown() : void
    {
        unset($this->orderdetail);
        parent::tearDown();
    }

    public function testOrderDetailBelongToOrder()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->orderdetail->order());
    }

    public function testOrderDetailBelongToProduct()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->orderdetail->product());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'order_id',
            'product_id',
            'price',
            'quantity',
        ];

        $this->assertEquals($inputs, $this->orderdetail->getFillable());
    }
}
