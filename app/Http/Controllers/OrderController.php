<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showOrderView(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())->get();
        $categories = Category::where('status', 'active')->orderBy('id')->get();

        return view('user.order', compact('orders', 'categories'));
    }

    public function showOrderDetailView(Request $request, $id)
    {
        $order = Order::find($id);
        $categories = Category::where('status', 'active')->orderBy('id')->get();
        $orderdetails = $order->orderDetails;

        return view('user.orderdetail', compact('categories', 'orderdetails'));
    }

    public function showPaymentView()
    {
        $categories = Category::where('status', 'active')->orderBy('id')->get();

        return view('user.offlinepayment', compact('categories'));
    }

    public function insertOrder(Request $request)
    {
        $cart = $request->session()->get('cart');
        foreach ($cart as $item) {
            $product = Product::find($item->id);
            if ($item->quantity > $product->quantity) {
                $request->session()->flash('fail', __('orderfail'));

                return redirect()->route('cart');
            }
        }
        $order = Order::create([
            'address' => $request->address,
            'phone' => $request->phone,
            'total' => $request->session()->get('subtotal'),
            'user_id' => Auth::id(),
        ]);
        $order_id = $order->id;
        foreach ($cart as $item) {
            OrderDetail::create([
                'order_id' => $order_id,
                'product_id' => $item->id,
                'quanatity' => $item->quantity,
                'quantity' => $item->price,
            ]);
            $product = Product::find($item->id);
            $product->quantity -= $item->quantity;
            $product->save();
        }
        $request->session()->forget('cart');
        $request->session()->forget('subtotal');
        $request->session()->forget('count');
        $request->session()->flash('success', __('ordersuccess'));

        return redirect()->route('cart');
    }

    public function approveorder($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('showOrderPendingView');
        }
        $order->status = 'approve';
        $order->save();

        return redirect()->route('showOrderPendingView');
    }

    public function denyorder($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->route('showOrderPendingView');
        }
        $orderdetails = $order->orderDetails;
        foreach ($orderdetails as $key => $value) {
            $product = $value->product;
            $product->quantity += $value->quantity;
            $product->save();
        }
        $order->delete();

        return redirect()->route('showOrderPendingView');
    }

    public function showOrderSuccessView()
    {
        $orders = Order::where('status', 'approve')->orderBy('id', 'desc')->get();
        
        return view('admin.order.ordersuccess', compact('orders'));
    }

    public function showOrderPendingView()
    {
        $orders = Order::where('status', 'pending')->orderBy('id', 'desc')->get();
        
        return view('admin.order.approveorder', compact('orders'));
    }

    public function showAdminOrderDetailView($id)
    {
        $order = Order::find($id);
        if ($order == null) {
            return redirect()->back();
        }
        $orderdetails = $order->orderDetails;

        return view('admin.order.orderdetail', compact('orderdetails'));
    }
}
