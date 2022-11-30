<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OdontologoM
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
        if (!empty(Auth::user())) :
            if (Auth::user()->type_user != "Dentist") {
                return $request->wantsJson()
                    ? new JsonResponse([], 403)
                    : redirect('/403');
            }
        endif;
        return $next($request);
    }
}
