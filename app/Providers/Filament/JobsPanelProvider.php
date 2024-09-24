<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Http\Middleware\Authenticate;
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

class JobsPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('jobs')
            ->path('jobs')
            ->brandLogo(asset('images/logo_siix.png'))
            ->favicon(asset('images/logo_siix.png'))
            ->brandLogoHeight('3rem')
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Jobs/Resources'), for: 'App\\Filament\\Jobs\\Resources')
            ->discoverPages(in: app_path('Filament/Jobs/Pages'), for: 'App\\Filament\\Jobs\\Pages')
            ->pages([
                \App\Filament\Pages\JobsAccess::class,
            ])
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make(),
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
            ])
            // ->topNavigation()
            ->navigationItems([
                NavigationItem::make('Main Menu')
                    ->url('http://portal.siix-ems.co.id/mainMenu')
                    ->icon('heroicon-o-arrow-left-start-on-rectangle')
                    ->sort(3),
            ])
            ->discoverWidgets(in: app_path('Filament/Jobs/Widgets'), for: 'App\\Filament\\Jobs\\Widgets')
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
