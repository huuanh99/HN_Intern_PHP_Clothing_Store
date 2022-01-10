<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Willvincent\Rateable\Rating;

class RatingController extends Controller
{
    protected $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    public function ratingProduct(RatingRequest $request)
    {
        $productId = $request->productId;
        $product = $this->productRepo->find($productId);
        if ($product == null) {
            return redirect()->back();
        }
        $rating = new Rating;
        $rating->user_id = Auth::id();
        $rating->rating = $request->input('star');
        $product->ratings()->save($rating);

        return redirect()->back();
    }
}
