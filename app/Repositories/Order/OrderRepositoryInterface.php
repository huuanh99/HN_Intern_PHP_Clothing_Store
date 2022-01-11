<?php
namespace App\Repositories\Order;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function showOrderUser();

    public function approveOrder($id);

    public function denyOrder($id);
    
    public function showOrderSuccess();

    public function showOrderFail();

    public function showOrderPending();

    public function showOrderSaleInMonth();

    public function showOrderDayInMonth();

    public function showOrderSaleToday();
}
