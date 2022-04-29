<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isSuper
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(auth()->user()->type < 1 && auth()->user()->type > 2){

            return response()->json([
                'message' => 'You do not have permission to access this resource.'
            ], 401);

        }

        return $next($request);
    }
}
