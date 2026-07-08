<?php

namespace App\Providers;
use App\Models\Logo;
use App\Models\SchoolName;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('backend.body.header', function ($view) {
            $view->with('profileData', Auth::user());
        });
        View::composer('backend.body.sidebar', function ($view) {
            $view->with('profileData', Auth::user());
            $view->with('logo', Logo::first());
            $view->with('schoolName', SchoolName::first());
        });
        View::composer('backend.body.changepassword', function ($view) {
            $view->with('profileData', Auth::user());
        });
    }
}
