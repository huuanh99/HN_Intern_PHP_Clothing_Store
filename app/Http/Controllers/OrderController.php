<?php

namespace App\Http\Controllers;

use App\Events\PusherEvent;
use App\Mail\MailOrderDetail;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Orderdetail\OrderdetailRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $categoryRepo;
    protected $orderdetailRepo;
    protected $productRepo;
    protected $notificationRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        CategoryRepositoryInterface $categoryRepo,
        OrderdetailRepositoryInterface $orderdetailRepo,
        ProductRepositoryInterface $productRepo,
        NotificationRepositoryInterface $notificationRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->categoryRepo = $categoryRepo;
        $this->orderdetailRepo = $orderdetailRepo;
        $this->productRepo = $productRepo;
        $this->notificationRepo = $notificationRepo;
        $notifications = $this->notificationRepo->getAll();
        view()->share('notifications', $notifications);
    }

    public function showOrderView(Request $request)
    {
        $orders = $this->orderRepo->showOrderUser();
        $categories = $this->categoryRepo->getAll();

        return view('user.order', compact('orders', 'categories'));
    }

    public function showOrderDetailView(Request $request, $id)
    {
        $order = $this->orderRepo->find($id);
        $categories = $this->categoryRepo->getAll();
        $orderdetails = $order->orderDetails;

        return view('user.orderdetail', compact('categories', 'orderdetails'));
    }

    public function showPaymentView()
    {
        $categories = $this->categoryRepo->getAll();

        return view('user.offlinepayment', compact('categories'));
    }

    public function insertOrder(Request $request)
    {
        $cart = $request->session()->get('cart');
        foreach ($cart as $item) {
            $product = $this->productRepo->find($item->id);
            if ($item->quantity > $product->quantity) {
                return redirect()->route('cart');
            }
        }
        $data = $request->all();
        $data['total'] = $request->session()->get('subtotal');
        $data['user_id'] = Auth::id();
        $order = $this->orderRepo->create($data);
        $order_id = $order->id;
        foreach ($cart as $item) {
            $data = [];
            $data['order_id'] = $order_id;
            $data['product_id'] = $item->id;
            $data['quantity'] = $item->quantity;
            $data['price'] = $item->price;
            $this->orderdetailRepo->create($data);
            $this->productRepo->updateQuantity($item->id, $item->quantity);
        }
        $request->session()->forget('cart');
        $request->session()->forget('subtotal');
        $request->session()->forget('count');
        $data = [];
        $data['type'] = config('const.orderNotificationType');
        $data['user_id'] = Auth::id();
        $this->notificationRepo->create($data);
        event(new PusherEvent(Auth::user()));

        return redirect()->route('cart');
    }

    public function approveorder($id)
    {
        $order = $this->orderRepo->approveOrder($id);
        Mail::to($order->user)->send(new MailOrderDetail($order));

        return redirect()->route('showOrderPendingView');
    }

    public function denyorder($id)
    {
        $order = $this->orderRepo->denyOrder($id);
        $orderdetails = $order->orderDetails;
        foreach ($orderdetails as $key => $value) {
            $this->productRepo->restoreQuantity($value->product_id, $value->quantity);
        }

        return redirect()->route('showOrderPendingView');
    }

    public function showOrderSuccessView()
    {
        $orders = $this->orderRepo->showOrderSuccess();

        return view('admin.order.ordersuccess', compact('orders'));
    }

    public function showOrderFailView()
    {
        $orders = $this->orderRepo->showOrderFail();

        return view('admin.order.orderfail', compact('orders'));
    }

    public function showOrderPendingView()
    {
        $orders = $this->orderRepo->showOrderPending();

        return view('admin.order.approveorder', compact('orders'));
    }

    public function showAdminOrderDetailView($id)
    {
        $order = $this->orderRepo->find($id);
        if ($order == null) {
            return redirect()->back();
        }
        $orderdetails = $order->orderDetails;

        return view('admin.order.orderdetail', compact('orderdetails'));
    }
}
