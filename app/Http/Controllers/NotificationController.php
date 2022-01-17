<?php

namespace App\Http\Controllers;

use App\Repositories\Notification\NotificationRepositoryInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationRepo;

    public function __construct(NotificationRepositoryInterface $notificationRepo)
    {
        $this->notificationRepo = $notificationRepo;
    }

    public function readNotification($id)
    {
        $data = [];
        $data['click'] = true;
        $this->notificationRepo->update($id, $data);

        return redirect()->route('showOrderPendingView');
    }

    public function readAllNotification()
    {
        $this->notificationRepo->markAllAsRead();

        return redirect()->back();
    }
}
