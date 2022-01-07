<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordUserRequest;
use App\Http\Requests\ChangePaswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery;

class UserController extends Controller
{
    protected $categoryRepo;
    protected $userRepo;
    protected $productRepo;

    public function __construct(
        CategoryRepositoryInterface $categoryRepo,
        UserRepositoryInterface $userRepo,
        ProductRepositoryInterface $productRepo
    ) {
        $this->categoryRepo = $categoryRepo;
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;
    }

    public function dashboard()
    {
        $categories = $this->categoryRepo->getAll();

        return view('dashboard', compact('categories'));
    }

    public function index()
    {
        $products = $this->productRepo->getAll();
        $categories = $this->categoryRepo->getAll();

        return view('user.index', compact('products', 'categories'));
    }

    public function showUserProfile()
    {
        $categories = $this->categoryRepo->getAll();

        return view('user.profile', compact('categories'));
    }

    public function updateCustomer(UpdateUserRequest $request)
    {
        $id = Auth::id();
        $user = $this->userRepo->find($id);
        $data = [];
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $this->userRepo->update($id, $data);
        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $_FILES['image']['name'];
        $file_temp = $_FILES['image']['tmp_name'];
        $div = explode('.', $file_name);
        $file_ext = strtolower(end($div));
        if (!empty($file_name)) {
            if (in_array($file_ext, $permited) == false) {
                $request->session()->flash('message', __('imageType'));
                
                return redirect()->back();
            } else {
                $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 10) . '.' . $file_ext;
                $uploaded_image = "../public/uploads/$unique_image";
                move_uploaded_file($file_temp, $uploaded_image);
                if ($user->image != null) {
                    unlink("../public/uploads/" . $user->image);
                }
                $data = [];
                $data['image'] = $unique_image;
                $this->userRepo->update($id, $data);
                $request->session()->flash('message', __('updateUser'));

                return redirect()->back();
            }
        } else {
            $request->session()->flash('message', __('updateUser'));

            return redirect()->back();
        }
    }

    public function lockUser($id)
    {
        $user = $this->userRepo->find($id);
        if ($user == null) {
            return redirect()->back();
        }
        $data = [];
        $data['status'] = config('const.lock');
        $this->userRepo->update($id, $data);

        return redirect()->back();
    }

    public function unlockUser($id)
    {
        $user = $this->userRepo->find($id);
        if ($user == null) {
            return redirect()->back();
        }
        $data = [];
        $data['status'] = config('const.active');
        $this->userRepo->update($id, $data);

        return redirect()->back();
    }

    public function provideNewPassword($id)
    {
        $user = $this->userRepo->find($id);
        if ($user == null) {
            return redirect()->back();
        }

        return view('admin.user.changepassword', compact('user'));
    }

    public function showListUserView()
    {
        $users = $this->userRepo->showListUser();

        return view('admin.user.userlist', compact('users'));
    }

    public function showChangePasswordView()
    {
        $categories = $this->categoryRepo->getAll();

        return view('user.changepassword', compact('categories'));
    }

    public function changePassword(ChangePaswordRequest $request)
    {
        $data = [];
        $data['password'] = Hash::make($request->password);
        $this->userRepo->update(Auth::id(), $data);
        $request->session()->flash('message', __('changePassword'));

        return redirect()->back();
    }

    public function changePasswordUser(ChangePasswordUserRequest $request)
    {
        $data = [];
        $data['password'] = Hash::make($request->password);
        $this->userRepo->update($request->id, $data);

        return redirect()->back();
    }
}
