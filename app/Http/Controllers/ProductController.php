<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function showProductByCategory($id)
    {
        $categories = Category::where('status', 'active')->orderBy('id')->get();
        $category = Category::find($id);
        if ($category == null) {
            return redirect()->route('index');
        }
        $product = $category->products;

        return view('user.productbycat', compact('category', 'product', 'categories'));
    }

    public function showDetailProduct($id)
    {
        $product = Product::with('comments')->find($id);
        $categories = Category::where('status', 'active')->orderBy('id')->get();
        if ($product == null) {
            return redirect()->route('index');
        }
        $comment = $product->comments;

        return view('user.details', compact('product', 'comment', 'categories'));
    }

    public function searchProduct(Request $request)
    {
        $categories = Category::where('status', 'active')->orderBy('id')->get();
        $product = product::where('name', 'like', '%' . $request->keyword . '%')->get();

        return view('user.search', compact('product', 'categories'));
    }

    public function showAddProductView()
    {
        $category = Category::where('status', 'active')->orderBy('id')->get();

        return view('admin.product.productadd', compact('category'));
    }

    public function showListProductView()
    {
        $products = Product::orderBy('id', 'desc')->get();

        return view('admin.product.productlist', compact('products'));
    }

    public function addProduct(AddProductRequest $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'category_id' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $total = count($_FILES['upload']['name']);
        for ($i=0; $i < $total; $i++) {
            $file_name = $_FILES['upload']['name'][$i];
            $file_temp = $_FILES['upload']['tmp_name'][$i];
            $div = explode('.', $file_name);
            $file_ext = strtolower(end($div));
            if (in_array($file_ext, $permited) == false) {
                $request->session()->flash('message', __('imageType'));
                
                return redirect()->back();
            } else {
                $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 15) . '.' . $file_ext;
                $uploaded_image = "../public/uploads/$unique_image";
                move_uploaded_file($file_temp, $uploaded_image);
                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $unique_image,
                ]);
            }
        }

        return redirect()->route('productadd');
    }

    public function showEditProductView($id)
    {
        $product = Product::find($id);
        $category = Category::where('status', 'active')->orderBy('id')->get();

        return view('admin.product.productedit', compact('product', 'category'));
    }

    public function editProduct(AddProductRequest $request)
    {
        $product = Product::find($request->id);
        if ($product == null) {
            return redirect()->back();
        }
        $product->name = $request->name;
        $product->quantity = $request->quantity;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->price = $request->price;
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $total = count($_FILES['upload']['name']);
        $product->save();
        if ($total > 1) {
            $productImages = $product->productImages;
            foreach ($productImages as $key => $value) {
                $value->delete();
                unlink("../public/uploads/" . $value->path);
            }
            for ($i=0; $i < $total; $i++) {
                $file_name = $_FILES['upload']['name'][$i];
                $file_temp = $_FILES['upload']['tmp_name'][$i];
                $div = explode('.', $file_name);
                $file_ext = strtolower(end($div));
                if (in_array($file_ext, $permited) == false) {
                    $request->session()->flash('message', __('imageType'));
                    
                    return redirect()->back();
                } else {
                    $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 15) . '.' . $file_ext;
                    $uploaded_image = "../public/uploads/$unique_image";
                    move_uploaded_file($file_temp, $uploaded_image);
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $unique_image,
                    ]);
                }
            }
        }
        
        return redirect()->back();
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if ($product == null) {
            return redirect()->back();
        }
        $product->delete();

        return redirect()->back();
    }
}
