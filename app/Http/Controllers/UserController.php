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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $categories = Category::where('status', 'active')->orderBy('id')->get();

        return view('dashboard', compact('categories'));
    }

    public function index()
    {
        $products = Product::all();
        $categories = Category::where('status', 'active')->orderBy('id')->get();

        return view('user.index', compact('products', 'categories'));
    }

    public function showUserProfile()
    {
        $categories = Category::where('status', 'active')->orderBy('id')->get();

        return view('user.profile', compact('categories'));
    }

    public function updateCustomer(UpdateUserRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->save();
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
                $unique_image = substr(password_hash(time(), PASSWORD_BCRYPT), 0, 15) . '.' . $file_ext;
                $uploaded_image = "../public/uploads/$unique_image";
                move_uploaded_file($file_temp, $uploaded_image);
                if ($user->image != null) {
                    unlink("../public/uploads/" . $user->image);
                }
                $user->image = $unique_image;
                $user->save();
                $request->session()->flash('message', __('updateUser'));

                return redirect()->back();
            }
        } else {
            $user->save();
            $request->session()->flash('message', __('updateUser'));

            return redirect()->back();
        }
    }

    public function lockUser($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->back();
        }
        $user->status = "lock";
        $user->save();

        return redirect()->back();
    }

    public function unlockUser($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->back();
        }
        $user->status = "active";
        $user->save();

        return redirect()->back();
    }

    public function provideNewPassword($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return redirect()->back();
        }

        return view('admin.user.changepassword', compact('user'));
    }

    public function showListUserView()
    {
        $users = User::where('role_id', config('const.user'))->orderBy('id', 'desc')->get();

        return view('admin.user.userlist', compact('users'));
    }

    public function showChangePasswordView()
    {
        $categories = Category::all();

        return view('user.changepassword', compact('categories'));
    }

    public function changePassword(ChangePaswordRequest $request)
    {
        $id = Auth::id();
        $user = User::find($id);
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);
        $user->save();
        $request->session()->flash('message', __('changePassword'));

        return redirect()->back();
    }

    public function changePasswordUser(ChangePasswordUserRequest $request)
    {
        $user = User::find($request->id);
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);
        $user->save();

        return redirect()->back();
    }
}
