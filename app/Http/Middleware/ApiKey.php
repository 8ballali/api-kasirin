<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKey
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
        $api_key = request()->header('x-api-key');
        if($api_key != env('API_KEY')){
            return response()->json([
                'message' => 'Apikey tidak sesuai',
                'code' => 405,
                'success' => true,
            ]);
        }
        return $next($request);
    }
}
