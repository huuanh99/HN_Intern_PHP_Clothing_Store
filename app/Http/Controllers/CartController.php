<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo, ProductRepositoryInterface $productRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
    }

    public function showCartView()
    {
        $categories = $this->categoryRepo->getAll();

        return view('user.cart', compact('categories'));
    }

    public function addToCart(Request $request)
    {
        $id = $request->id;
        $product = $this->productRepo->find($id);
        if ($request->quantity > $product->quantity) {
            return redirect()->route('index');
        }
        if ($request->session()->get('cart') == null) {
            $product->totalquantity = $product->quantity;
            $product->quantity = $request->quantity;
            $cart = [];
            array_push($cart, $product);
            $request->session()->put('cart', $cart);
            $request->session()->put('subtotal', $product->price * $request->quantity);
        } else {
            $cart = $request->session()->get('cart');
            $check = false;
            foreach ($cart as $cartItem) {
                if ($cartItem->id == $id) {
                    $totalquantity = $cartItem->quantity + $request->quantity;
                    if ($totalquantity > $cartItem->totalquantity) {
                        $cartItem->quantity = $cartItem->totalquantity;
                    } else {
                        $cartItem->quantity += $request->quantity;
                    }
                    $check = true;
                }
            }
            if ($check == false) {
                $product->totalquantity = $product->quantity;
                $product->quantity = $request->quantity;
                array_push($cart, $product);
            }
            $request->session()->put('cart', $cart);
            $subtotal = $request->session()->get('subtotal');
            $subtotal += $product->price * $request->quantity;
            $request->session()->put('subtotal', $subtotal);
        }
        $request->session()->put('count', count($request->session()->get('cart')));

        return redirect()->route('cart');
    }

    public function addToCartHomeView(Request $request, $id)
    {
        $product = $this->productRepo->find($id);
        if ($request->session()->get('cart') == null) {
            $product->totalquantity = $product->quantity;
            $product->quantity = 1;
            $cart = [];
            array_push($cart, $product);
            $request->session()->put('cart', $cart);
            $request->session()->put('subtotal', $product->price);
        } else {
            $cart = $request->session()->get('cart');
            $check = false;
            foreach ($cart as $cartItem) {
                if ($cartItem->id == $id) {
                    $totalquantity = $cartItem->quantity + 1;
                    if ($totalquantity > $cartItem->totalquantity) {
                        $cartItem->quantity = $cartItem->totalquantity;
                    } else {
                        $cartItem->quantity += 1;
                    }
                    $check = true;
                }
            }
            if ($check == false) {
                $product->totalquantity = $product->quantity;
                $product->quantity = 1;
                array_push($cart, $product);
            }
            $request->session()->put('cart', $cart);
            $subtotal = $request->session()->get('subtotal');
            $subtotal += $product->price;
            $request->session()->put('subtotal', $subtotal);
        }
        $request->session()->put('count', count($request->session()->get('cart')));

        return redirect()->route('cart');
    }

    public function deleteCart(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        $subtotal = $request->session()->get('subtotal');
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]->id == $id) {
                $subtotal -= $cart[$i]->price * $cart[$i]->quantity;
                array_splice($cart, $i, 1);
            }
        }
        $request->session()->put('cart', $cart);
        $request->session()->put('subtotal', $subtotal);
        $request->session()->put('count', count($request->session()->get('cart')));

        return redirect()->route('cart');
    }

    public function updateCart(Request $request)
    {
        $id = $request->id;
        $cart = $request->session()->get('cart');
        $subtotal = 0;
        foreach ($cart as $cartItem) {
            if ($cartItem->id == $id) {
                if ($request->quantity > $cartItem->totalquantity) {
                    return redirect()->route('cart');
                }
                $cartItem->quantity = $request->quantity;
            }
            $subtotal += $cartItem->price * $cartItem->quantity;
        }
        $request->session()->put('cart', $cart);
        $request->session()->put('subtotal', $subtotal);
        
        return redirect()->route('cart');
    }
}
