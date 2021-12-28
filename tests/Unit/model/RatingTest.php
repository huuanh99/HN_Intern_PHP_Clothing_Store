<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RatingTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $rating;

    public function setup() : void
    {
        parent::setUp();
        $this->rating = new Rating();
    }

    public function tearDown() : void
    {
        unset($this->rating);
        parent::tearDown();
    }

    public function testRatingBelongToUser()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->rating->user());
    }

    public function testRatingBelongToProduct()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->rating->product());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'user_id',
            'product_id',
            'star',
        ];

        $this->assertEquals($inputs, $this->rating->getFillable());
    }
}
