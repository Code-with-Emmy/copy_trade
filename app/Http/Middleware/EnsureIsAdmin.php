<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Admin;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\meta;
class EnsureIsAdmin
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
        $api = new meta();
        
        if (Auth::guard('admin')->check()) {
            
            $res = $api->verify_license();
            if ($res != true) {
                abort(503, 'Sorry for interrupting! Please check back later.');
            }

            return $next($request);
        } else {
            return redirect()->route('validate_admin');
        }
    }
}
