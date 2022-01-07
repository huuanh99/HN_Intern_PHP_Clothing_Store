<?php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return Order::class;
    }

    public function showOrderUser()
    {
        return Order::where('user_id', Auth::id())->get();
    }

    public function approveOrder($id)
    {
        $data = [];
        $data['status'] = config('const.approve');
        return $this->update($id, $data);
    }

    public function denyOrder($id)
    {
        $data = [];
        $data['status'] = config('const.deny');
        return $this->update($id, $data);
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return $result;
        }

        return redirect()->route('showOrderPendingView');
    }

    public function showOrderSuccess()
    {
        return Order::where('status', config('const.approve'))->orderBy('id', 'desc')->get();
    }

    public function showOrderFail()
    {
        return Order::where('status', config('const.deny'))->orderBy('id', 'desc')->get();
    }

    public function showOrderPending()
    {
        return Order::where('status', config('const.pending'))->orderBy('id', 'desc')->get();
    }

    public function showOrderSaleInMonth()
    {
        return Order::whereMonth('created_at', today())->where('status', 'approve')
            ->selectRaw('sum(total) as sum')
            ->groupBy(DB::raw('Date(created_at)'))
            ->pluck('sum');
    }

    public function showOrderDayInMonth()
    {
        return Order::whereMonth('created_at', today())->where('status', 'approve')
            ->selectRaw(DB::raw('Date(created_at) as date'))
            ->groupBy(DB::raw('Date(created_at)'))
            ->pluck('date');
    }
}
