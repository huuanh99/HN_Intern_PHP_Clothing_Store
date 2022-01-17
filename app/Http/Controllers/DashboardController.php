<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
        $notifications = $this->notificationRepo->getAll();
        $notificationNotClick = $this->notificationRepo->getNotificationNotClick();
        view()->share('notifications', $notifications);
        view()->share('notificationNotClick', $notificationNotClick);
    }

    public function dashboard()
    {
        return view('admin.index');
    }
}
