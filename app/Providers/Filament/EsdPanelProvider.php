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
use TomatoPHP\FilamentNotes\FilamentNotesPlugin;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class EsdPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('esd')
            ->darkMode(false)
            ->path('esd')
            ->brandLogo(asset('images/logo_siix.png'))
            ->favicon(asset('images/logo_siix.png'))
            ->brandLogoHeight('3rem')
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->brandName('ESD Portal')
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
                FilamentNotesPlugin::make()
                    ->useNotification()
                    ->useChecklist()
                    ->useStatus()
                    ->useGroups()
                    ->useShareLink()
            ])
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Esd/Resources'), for: 'App\\Filament\\Esd\\Resources')
            ->discoverPages(in: app_path('Filament/Esd/Pages'), for: 'App\\Filament\\Esd\\Pages')
            ->pages([
                \App\Filament\Pages\DashboardESD::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Esd/Widgets'), for: 'App\\Filament\\Esd\\Widgets')
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
                // Add custom middleware here
                \App\Http\Middleware\CheckEsdAccess::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
