<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Repositories\Comment\CommentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentRepo;

    public function __construct(CommentRepositoryInterface $commentRepo)
    {
        $this->commentRepo = $commentRepo;
    }

    public function commentProduct(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $this->commentRepo->create($data);
        
        return redirect()->back();
    }
}
