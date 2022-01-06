<?php
namespace App\Repositories\User;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

    public function showListUser()
    {
        return User::where('role_id', config('const.user'))->orderBy('id', 'desc')->get();
    }
}
