<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function updateQuantity($id, $quantity);

    public function restoreQuantity($id, $quantity);

    public function showProductPriceLessThan200000();

    public function showProductPriceBetween200000And500000();

    public function showProductPriceMoreThan500000();

    public function showDetailProduct($id);

    public function searchProduct($request);
}
