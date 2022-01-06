<?php
namespace App\Repositories\Product;

use App\Models\Order;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return Product::class;
    }

    public function updateQuantity($id, $quantity)
    {
        $product = $this->find($id);
        $product->quantity -= $quantity;
        $product->save();

        return true;
    }

    public function restoreQuantity($id, $quantity)
    {
        $product = $this->find($id);
        $product->quantity += $quantity;
        $product->save();
        
        return true;
    }

    public function showProductPriceLessThan200000()
    {
        return Product::where('price', '<', '200000')->get();
    }

    public function showProductPriceBetween200000And500000()
    {
        return Product::where('price', '>=', '200000')->where('price', '<=', '500000')->get();
    }

    public function showProductPriceMoreThan500000()
    {
        return Product::where('price', '>=', '500000')->get();
    }

    public function showDetailProduct($id)
    {
        $product = Product::with('comments')->find($id);

        return $product;
    }

    public function searchProduct($request)
    {
        return Product::where('name', 'like', '%' . $request->keyword . '%')->get();
    }
}
