<?php
namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function getModel()
    {
        return Notification::class;
    }

    public function getAll()
    {
        return Notification::orderBy('id', 'desc')->take(10)->get();
    }
}
