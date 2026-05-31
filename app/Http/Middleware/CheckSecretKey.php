<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSecretKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $key = env('SECRET_KEY');
        
        if(!$request->header('X-SUPER-SECRET-KEY')){
            return response()->json([
                'message' => 'No secret key'
            ],400);
        }
        if($request->header('X-SUPER-SECRET-KEY') !== $key){
            return response()->json([
                'message' => 'Invalid key'
            ], 401 );
        }

        return $next($request); 
    }
}
