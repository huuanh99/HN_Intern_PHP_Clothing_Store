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

    public function commentProductApi(Request $request)
    {
        if (!Auth::user()->tokenCan('comment:post')) {
            return response()->json([
                'status_code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $comment = $this->commentRepo->create($data);
        
        return response()->json([
            'data' => $comment,
        ], 200);
    }
}
