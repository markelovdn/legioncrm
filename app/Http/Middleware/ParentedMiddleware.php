<?php

namespace App\Http\Middleware;

use App\Models\Parented;
use Closure;
use Illuminate\Http\Request;

class ParentedMiddleware
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
        $parented = Parented::with('user')->where('user_id', auth()->user()->id)->first();

        if($request->path() != 'parented/'.$parented->id) {
            return redirect('parented/'.$parented->id);
        }

        return $next($request);
    }
}
