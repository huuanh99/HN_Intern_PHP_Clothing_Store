<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $product;

    public function setup() : void
    {
        parent::setUp();
        $this->product = new Product();
    }

    public function tearDown() : void
    {
        unset($this->product);
        parent::tearDown();
    }

    public function testProductBelongToCategory()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->product->category());
    }

    public function testProductHasManyProductImages()
    {
        $this->assertInstanceOf(HasMany::class, $this->product->productImages());
    }

    public function testProductHasManyComments()
    {
        $this->assertInstanceOf(HasMany::class, $this->product->comments());
    }

    public function testProductHasManyRatings()
    {
        $this->assertInstanceOf(HasMany::class, $this->product->ratings());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'category_id',
            'name',
            'description',
            'price',
            'quantity',
        ];

        $this->assertEquals($inputs, $this->product->getFillable());
    }
}
