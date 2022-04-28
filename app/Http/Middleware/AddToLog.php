<?php

namespace App\Http\Middleware;

use Closure;
use App\LogActivityModel;

class AddToLog
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
        $response = $next($request);
        error_log($request->fullUrl());

        return $response;
    }
}
