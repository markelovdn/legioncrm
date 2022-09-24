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
        $parented = Parented::with('user')->where('user_id', auth()->user()->id)->get();

        $parented_id = '';
        foreach ($parented as $item) {
            $parented_id = 'parented/'.$item->id;
        }

        if($request->path() != $parented_id) {
            return redirect($parented_id);
        }
        return $next($request);
    }
}
