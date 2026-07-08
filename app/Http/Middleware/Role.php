<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        
        $userRole = $request->user()->role;

        if ($userRole !== $role) {
            
            if ($userRole === 'superadmin') {
                return redirect('/superadmin/dashboard');
            }elseif ($userRole === 'admin') {
                return redirect('/admin/dashboard');
            }elseif ($userRole === 'teacher') {
                return redirect('/teacher/dashboard');
            }elseif ($userRole === 'parent') {
                return redirect('/parent/dashboard');
            }elseif ($userRole === 'reception') {
                return redirect('/receptionist/dashboard');
            }elseif ($userRole === 'accountant') {
                return redirect('/accountant/dashboard');
            }
            
            return redirect('/login');
        }

       
        return $next($request);
    }

}
