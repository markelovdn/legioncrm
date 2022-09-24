<?php

namespace App\Http\Middleware;

use App\Models\Coach;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachMiddleware
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
        $coach = Coach::with('user')->where('user_id', auth()->user()->id)->get();

        $coach_id = '';
        foreach ($coach as $item) {
            $coach_id = 'coach/'.$item->id;
        }

        if($request->path() != $coach_id) {
            return redirect($coach_id);
        }
        return $next($request);
    }
}
