<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Actions\Action;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Orion\FilamentBackup\BackupPlugin;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\EditProfile;
use Orion\FilamentGreeter\GreeterPlugin;
use Filament\Http\Middleware\Authenticate;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Orion\FilamentFeedback\FeedbackPlugin;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Ercogx\FilamentOpenaiAssistant\OpenaiAssistantPlugin;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Vormkracht10\TwoFactorAuth\TwoFactorAuthPlugin;
use Stephenjude\FilamentTwoFactorAuthentication\TwoFactorAuthenticationPlugin;

class MainMenuPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('mainMenu')
            ->path('mainMenu')
            ->brandLogo(asset('images/logo_siix.png'))
            ->favicon(asset('images/logo_siix.png'))
            ->brandLogoHeight('3rem')
            ->sidebarCollapsibleOnDesktop()
            ->brandName('Admin Portal')
            ->profile(EditProfile::class)
            // ->navigationItems([
            //     NavigationItem::make('Security')
            //         ->url('http://portal.siix-ems.co.id/mainMenu/my-profile')
            //         ->icon('heroicon-o-lock-closed')
            // ])
            // ->topNavigation()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->plugin(
                \Hasnayeen\Themes\ThemesPlugin::make(),
            )
            ->plugins([
                FilamentApexChartsPlugin::make(),
                // TwoFactorAuthenticationPlugin::make()
                //     ->addTwoFactorMenuItem() // Add 2FA settings to user menu items
                //     ->enforceTwoFactorSetup(),
                GreeterPlugin::make()
                    ->message('Welcome Back')
                    ->action(
                        Action::make('manage_profile')
                            ->label('Manage My Profile')
                            ->icon('heroicon-o-user')
                            ->url('http://portal.siix-ems.co.id/mainMenu/profile')
                    )
                    ->sort(-1)
                    ->columnSpan('full'),

            ])
            ->discoverResources(in: app_path('Filament/MainMenu/Resources'), for: 'App\\Filament\\MainMenu\\Resources')
            ->discoverPages(in: app_path('Filament/MainMenu/Pages'), for: 'App\\Filament\\MainMenu\\Pages')
            ->pages([
                \App\Filament\Pages\AdminDashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/MainMenu/Widgets'), for: 'App\\Filament\\MainMenu\\Widgets')
            ->widgets([
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
