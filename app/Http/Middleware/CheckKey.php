<?php

namespace App\Http\Middleware;

use Closure;

class CheckKey
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
        if(env('KEY_API' ,'asdewqzxcvfr')  == $request->header('key'))
            return $next($request);
        else
            return response()->json(['message'=> 'unauthorized']);
    }
}
