<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductImageTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $productimage;

    public function setup() : void
    {
        parent::setUp();
        $this->productimage = new ProductImage();
    }

    public function tearDown() : void
    {
        unset($this->productimage);
        parent::tearDown();
    }

    public function testProductImageBelongToProduct()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->productimage->product());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'product_id',
            'path',
        ];

        $this->assertEquals($inputs, $this->productimage->getFillable());
    }
}
