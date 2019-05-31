<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;
use App\Traits\ApiResponser;
use Closure;

class CustomThrottleRequests extends ThrottleRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
   
   
}
