<?php

namespace App\Http\Controllers;

use App\Charts\OrderChart;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class OrderChartController extends Controller
{
    protected $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

    public function showOrderChartView()
    {
        $orders = $this->orderRepo->showOrderSaleInMonth();
        $dates = $this->orderRepo->showOrderDayInMonth();
        $chart = new OrderChart;
        $chart->labels($dates);
        $chart->dataset('Order sale', 'line', $orders)->options([
            'fill' => 'true',
            'borderColor' => '#51C1C0'
        ]);

        return view('admin.chart.orderchart', compact('chart'));
    }
}
