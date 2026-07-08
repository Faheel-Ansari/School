<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        switch (Auth::user()->role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
                break;
            case 'superadmin':
                return redirect()->intended('/superadmin/dashboard');
                break;
            case 'teacher':
                return redirect()->intended('/teacher/dashboard');
                break;
            case 'parent':
                return redirect()->intended('/parent/dashboard');
                break;
            case 'reception':
                return redirect()->intended('/receptionist/dashboard');
                break;
            case 'accountant':
                return redirect()->intended('/accountant/dashboard');
                break;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
    public function parentdestroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/parent/login');
    }
}
