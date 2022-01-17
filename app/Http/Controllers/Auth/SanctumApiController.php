<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\TryCatch;

class SanctumApiController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required|string',
            ]);
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status_code' => 403,
                    'message' => 'Unauthorized'
                ], 403);
            }
            $user = User::where('email', $request->email)->first();
            if ($user->role_id === config('const.admin')) {
                $tokenResult = $user->createToken('authToken')->plainTextToken;
            } else {
                $tokenResult = $user->createToken('authToken', [
                    'product:viewAll',
                    'product:view',
                    'comment:post',
                    'user:view',
                    'order:view',
                    'order:insert'
                ])->plainTextToken;
            }

            return response()->json([
                'status_code' => 200,
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
            ]);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function revoke(Request $request, $tokenId)
    {
        try {
            $user = Auth::user();
            $user->tokens()->where('id', $tokenId)->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Revoke token',
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    public function revokeAll(Request $request)
    {
        try {
            $user = Auth::user();
            $user->tokens()->delete();

            return response()->json([
                'status_code' => 200,
                'message' => 'Revoke all tokens',
            ], 200);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'status_code' => 400,
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
