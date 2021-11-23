<?php

namespace App\Http\Middleware;

use Closure;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Session;
class Sweet
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
        if (session('success')) {
            Alert::success(session('success'));
        }

        if (session('error')) {
            Alert::error(session('error'));
        }

        return $next($request);
    }
}
