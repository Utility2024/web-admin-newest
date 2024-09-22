<?php

namespace App\Providers;

use Filament\Panel;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use App\Filament\Ticket\Widgets\LatestMyTicketing;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // if (env(key: 'APP_ENV') !=='local') {
        //     URL::forceScheme(scheme:'https');
        // }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        Gate::define('access-panel', function (User $user, Panel $panel) {
            return $user->canAccessPanel($panel);
        });

        Gate::before(function (User $user, $ability) {
            if ($user->isSuperAdmin()) {
                return true;
            }
        });

        // FilamentView::registerRenderHook(
        //     PanelsRenderHook::FOOTER,
        //     fn (): View => view('footer'),

        // if (env(key: 'APP_ENV') !=='local') {
        //     URL::forceScheme(scheme:'https');
        // }
    }
}
