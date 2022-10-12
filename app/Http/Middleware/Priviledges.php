<?php

namespace App\Http\Middleware;

use App\Models\Priviledge;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class Priviledges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        $userPriviledge = Priviledge::where('user_id', $user->id)->first();
        $priviledges = explode(';', $userPriviledge->priviledge);

        foreach ($priviledges as $p) {
            foreach ($roles as $r) {
                if ($r == $p) {
                    return $next($request);
                }
            }
        }

        return redirect('/user/notPriviledges');
    }
}
