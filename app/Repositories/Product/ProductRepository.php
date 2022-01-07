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

    public function showProductPrice($begin, $end)
    {
        return Product::where('price', '>=', $begin)->where('price', '<=', $end)->get();
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
