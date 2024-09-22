<?php

namespace App\Providers\Filament;

use Closure;
use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Illuminate\Http\Request;
use Filament\Pages\Dashboard;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use Illuminate\Validation\Rules\Password;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class GaPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('ga')
            ->darkMode(false)
            ->path('ga')
            ->brandLogo(asset('images/logo_siix.png'))
            ->favicon(asset('images/logo_siix.png'))
            ->brandLogoHeight('3rem')
            ->sidebarCollapsibleOnDesktop()
            ->brandName('GA Portal')
            ->profile(EditProfile::class)
            ->navigationItems([
                NavigationItem::make('Back')
                    ->url('http://portal.siix-ems.co.id/jobs')
                    ->icon('heroicon-o-arrow-left-start-on-rectangle')
                    ->sort(3),
            ])
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make()
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Ga/Resources'), for: 'App\\Filament\\Ga\\Resources')
            ->discoverPages(in: app_path('Filament/Ga/Pages'), for: 'App\\Filament\\Ga\\Pages')
            ->pages([
                \App\Filament\Pages\DashboardGa::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Ga/Widgets'), for: 'App\\Filament\\Ga\\Widgets')
            ->widgets([
                // Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \Hasnayeen\Themes\Http\Middleware\SetTheme::class,
                \App\Http\Middleware\CheckGaAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
