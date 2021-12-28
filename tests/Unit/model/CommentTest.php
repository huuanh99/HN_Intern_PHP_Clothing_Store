<?php

namespace Tests\Unit\Model;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $comment;

    public function setup() : void
    {
        parent::setUp();
        $this->comment = new Comment();
    }

    public function tearDown() : void
    {
        unset($this->comment);
        parent::tearDown();
    }

    public function testCommentBelongToUser()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->user());
    }

    public function testCommentBelongToProduct()
    {
        $this->assertInstanceOf(BelongsTo::class, $this->comment->product());
    }

    public function testFieldAreFillable()
    {
        $inputs = [
            'user_id',
            'product_id',
            'content',
        ];

        $this->assertEquals($inputs, $this->comment->getFillable());
    }
}
