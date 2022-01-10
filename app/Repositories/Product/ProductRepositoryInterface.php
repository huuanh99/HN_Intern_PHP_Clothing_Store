<?php
namespace App\Repositories\Product;

use App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function updateQuantity($id, $quantity);

    public function restoreQuantity($id, $quantity);

    public function showProductPrice($begin, $end);

    public function showDetailProduct($id);

    public function searchProduct($request);
}
