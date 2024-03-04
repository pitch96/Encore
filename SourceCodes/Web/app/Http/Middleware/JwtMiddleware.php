<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'statusCode' => 400,
                    'success' => false,
                    'message' => 'Token is Invalid'
                ]);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'statusCode' => 400,
                    'success' => false,
                    'message' => 'Token is Expired'
                ]);
            } else {
                return response()->json([
                    'statusCode' => 400,
                    'success' => false,
                    'message' => 'Authorization Token not found'
                ]);
            }
        }
        return $next($request);
    }
}
