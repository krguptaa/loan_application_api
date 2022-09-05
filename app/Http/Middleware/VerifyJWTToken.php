<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class VerifyJWTToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status'=>0, 'message' => 'Your session is expired. Please login again to continue.', 'data'=>[],'statusCode'=>401]);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status'=>0, 'message' => 'Your session is expired. Please login again to continue.', 'data'=>[],'statusCode'=>401]);
            } else {
                return response()->json(['status'=>0, 'message' => 'Your session is expired. Please login again to continue.','data'=>[], 'statusCode'=>401]);
            }
        }

        return $next($request);
    }
}
