<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $category;

    public function setup() : void
    {
        parent::setUp();
        $this->category = new Category();
    }

    public function tearDown() : void
    {
        unset($this->category);
        parent::tearDown();
    }

    public function testCategoryHasManyChildCategories()
    {
        $this->assertInstanceOf(HasMany::class, $this->category->childCategories());
    }

    public function testCategoryHasParentCategory()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->category->parentCategory());
    }

    public function testCategoryHasManyChildProducts()
    {
        $this->assertInstanceOf(HasMany::class, $this->category->childproducts());
    }

    public function testCategoryHasManyGrandChildProducts()
    {
        $this->assertInstanceOf(HasManyThrough::class, $this->category->grandchildproducts());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'name',
            'slug',
            'status',
            'parent_id',
        ];

        $this->assertEquals($inputs, $this->category->getFillable());
    }
}
