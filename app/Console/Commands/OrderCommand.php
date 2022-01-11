<?php

namespace App\Console\Commands;

use App\Mail\MailOrderReport;
use App\Models\Order;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class OrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:report';
    protected $orderRepo;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        parent::__construct();
        $this->orderRepo = $orderRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $orders = $this->orderRepo->showOrderSaleToday();
        Mail::to(config('const.adminmail'))->send(new MailOrderReport($orders));
    }
}
