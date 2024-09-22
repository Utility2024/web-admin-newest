<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Hasnayeen\Themes\ThemesPlugin;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use Filament\Http\Middleware\Authenticate;
use Hasnayeen\Themes\Http\Middleware\SetTheme;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class FormPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('form')
            ->path('form')
            ->brandLogo(asset('images/logo_siix.png'))
            ->favicon(asset('images/logo_siix.png'))
            ->brandLogoHeight('3rem')
            ->profile(EditProfile::class)
            ->sidebarCollapsibleOnDesktop()
            ->navigationItems([
                NavigationItem::make('Main Menu')
                    ->url('http://portal.siix-ems.co.id/mainMenu')
                    ->icon('heroicon-o-arrow-left-start-on-rectangle')
                    ->sort(3),
            ])
            ->topNavigation()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Form/Resources'), for: 'App\\Filament\\Form\\Resources')
            ->discoverPages(in: app_path('Filament/Form/Pages'), for: 'App\\Filament\\Form\\Pages')
            ->pages([
                \App\Filament\Pages\DashboardForm::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Form/Widgets'), for: 'App\\Filament\\Form\\Widgets')
            ->widgets([
                //
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
                SetTheme::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(
                ThemesPlugin::make(),
            );
    }
}
