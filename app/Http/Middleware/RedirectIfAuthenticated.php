<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                if ($user->user_type === 'admin' && !$request->routeIs('admin-dashboard')) {
                    return redirect()->route('admin-dashboard');
                } elseif ($user->user_type === 'customer') {
                    return redirect()->route('home-page');
                } elseif ($user->user_type === 'employee') {
                    $employee = Employee::where('user_id', $user->user_id)->first();
                    if ($employee) {
                        if ($employee->positionType->position_type_name === 'manager') {
                            return redirect()->route('manager-homepage');
                        } elseif ($employee->positionType->position_type_name === 'laborer') {
                            return redirect()->route('laborer-homepage');
                        }
                    }
                }
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
