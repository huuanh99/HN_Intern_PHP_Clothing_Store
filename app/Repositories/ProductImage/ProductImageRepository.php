<?php
namespace App\Repositories\ProductImage;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class ProductImageRepository extends BaseRepository implements ProductImageRepositoryInterface
{
    public function getModel()
    {
        return ProductImage::class;
    }
}
