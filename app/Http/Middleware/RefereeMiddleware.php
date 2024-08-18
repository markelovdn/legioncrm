<?php

namespace App\Http\Middleware;

use App\Models\Coach;
use App\Models\Referee;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefereeMiddleware
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
        $referee = Referee::with('user')->where('user_id', auth()->user()->id)->first();

        if($request->path() != 'referee/'.$referee->id) {
            return redirect('referee/'.$referee->id);
        }
        return $next($request);
    }
}
