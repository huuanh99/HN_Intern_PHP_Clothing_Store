<?php
namespace App\Repositories\Orderdetail;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class OrderdetailRepository extends BaseRepository implements OrderdetailRepositoryInterface
{
    public function getModel()
    {
        return OrderDetail::class;
    }
}
