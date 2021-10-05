<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class Auth_Token
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = request()->header('user_id');
        $auth_token = request()->header('auth_token');
        $user = User::find($user_id);
        if($user->token != $auth_token){
            return response()->json([
                'message' => 'Sesi Telah Habis Silakan Login Kembali',
                'code' => 405,
                'success' => true,
            ]);
        }
        return $next($request);
    }
}
