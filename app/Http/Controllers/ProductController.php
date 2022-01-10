<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Rating;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductImage\ProductImageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productRepo;
    protected $categoryRepo;
    protected $productimageRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        ProductRepositoryInterface $productRepo,
        ProductImageRepositoryInterface $productimageRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->productRepo = $productRepo;
        $this->productimageRepo = $productimageRepo;
    }

    public function showProductByCategory($id)
    {
        $categories = $this->categoryRepo->getAll();
        $category = $this->categoryRepo->find($id);
        if ($category == null) {
            return redirect()->route('index');
        }
        $childproducts = $category->childproducts;
        $grandchildproducts = $category->grandchildproducts;

        return view('user.productbycat', compact('category', 'childproducts', 'grandchildproducts', 'categories'));
    }

    public function showProductByPrice($begin, $end)
    {
        $categories = $this->categoryRepo->getAll();
        $product = $this->productRepo->showProductPrice($begin, $end);

        return view('user.productbyprice', compact('product', 'categories'));
    }

    public function showDetailProduct($id)
    {
        $categories = $this->categoryRepo->getAll();
        $product = $this->productRepo->showDetailProduct($id);
        if ($product == null) {
            return redirect()->route('index');
        }
        $comment = $product->comments;
        $fivestar = $product->ratings->where('rating', 5)->count();
        $fourstar = $product->ratings->where('rating', 4)->count();
        $threestar = $product->ratings->where('rating', 3)->count();
        $twostar = $product->ratings->where('rating', 2)->count();
        $onestar = $product->ratings->where('rating', 1)->count();

        return view('user.details', compact(
            'product',
            'comment',
            'categories',
            'fivestar',
            'fourstar',
            'threestar',
            'twostar',
            'onestar'
        ));
    }

    public function searchProduct(Request $request)
    {
        $categories = $this->categoryRepo->getAll();
        $product = $this->productRepo->searchProduct($request);

        return view('user.search', compact('product', 'categories'));
    }

    public function showAddProductView()
    {
        $categories = $this->categoryRepo->getAll();

        return view('admin.product.productadd', compact('categories'));
    }

    public function showListProductView()
    {
        $products = $this->productRepo->getAll();

        return view('admin.product.productlist', compact('products'));
    }

    public function addProduct(AddProductRequest $request)
    {
        $data = $request->all();
        $product = $this->productRepo->create($data);
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
                $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 10) . '.' . $file_ext;
                $uploaded_image = "../public/uploads/$unique_image";
                move_uploaded_file($file_temp, $uploaded_image);
                $data = [];
                $data['product_id'] = $product->id;
                $data['path'] = $unique_image;
                $this->productimageRepo->create($data);
            }
        }
        $request->session()->flash('message', __('insertProduct'));

        return redirect()->route('productadd');
    }

    public function showEditProductView($id)
    {
        $product = $this->productRepo->find($id);
        $categories = $this->categoryRepo->getAll();

        return view('admin.product.productedit', compact('product', 'categories'));
    }

    public function editProduct(AddProductRequest $request)
    {
        $product = $this->productRepo->find($request->id);
        if ($product == null) {
            return redirect()->back();
        }
        $data = [];
        $data['quantity'] = $request->quantity;
        $data['category_id'] = $request->category_id;
        $data['description'] = $request->description;
        $data['price'] = $request->price;
        $this->productRepo->update($request->id, $data);
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $total = count($_FILES['upload']['name']);
        if ($total > 0) {
            $productImages = $product->productImages;
            foreach ($productImages as $key => $value) {
                unlink("../public/uploads/" . $value->path);
                $this->productimageRepo->delete($value->id);
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
                    $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 10) . '.' . $file_ext;
                    $uploaded_image = "../public/uploads/$unique_image";
                    move_uploaded_file($file_temp, $uploaded_image);
                    $data = [];
                    $data['product_id'] = $product->id;
                    $data['path'] = $unique_image;
                    $this->productimageRepo->create($data);
                }
            }
        }
        
        return redirect()->back();
    }

    public function deleteProduct($id)
    {
        $product = $this->productRepo->find($id);
        if ($product == null) {
            return redirect()->back();
        }
        $productImages = $product->productImages;
        foreach ($productImages as $key => $value) {
            unlink("../public/uploads/" . $value->path);
        }
        $this->productRepo->delete($id);
        
        return redirect()->back();
    }
}
