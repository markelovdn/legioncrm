<?php

namespace App\Http\Middleware;

use App\Models\Organization;
use App\Models\Parented;
use Closure;
use Illuminate\Http\Request;

class OrganizationMiddleware
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
        $org = Organization::with('user')->where('user_id', auth()->user()->id)->first();

        if($request->path() != 'organization/'.$org->id) {
            return redirect('organization/'.$org->id);
        }

        return $next($request);
    }
}