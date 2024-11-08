<?php

namespace App\Providers;

use App\Models\Glove;
use App\Models\Ticket;
use App\Models\Garment;
use App\Models\Ionizer;
use App\Models\Flooring;
use App\Models\MasterWip;
use App\Models\Packaging;
use App\Models\Soldering;
use App\Models\Worksurface;
use App\Models\EquipmentGround;
use App\Models\GroundMonitorBox;
use App\Observers\GlovesObserver;
use App\Observers\TicketObserver;
use App\Observers\FloringObserver;
use App\Observers\GarmentObserver;
use App\Observers\IonizerObserver;
use App\Observers\MasterWipObserver;
use App\Observers\PackagingObserver;
use App\Observers\SolderingObserver;
use Illuminate\Support\Facades\Event;
use App\Observers\WorksurfaceObserver;
use Illuminate\Auth\Events\Registered;
use App\Observers\EquipmentGroundObserver;
use App\Observers\GroundMonitorBoxObserver;
use Laravel\Fortify\Events\TwoFactorAuthenticationEnabled;
use Laravel\Fortify\Events\TwoFactorAuthenticationChallenged;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Vormkracht10\TwoFactorAuth\Listeners\SendTwoFactorCodeListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        EquipmentGround::observe(EquipmentGroundObserver::class);
        Flooring::observe(FloringObserver::class);
        Garment::observe(GarmentObserver::class);
        Glove::observe(GlovesObserver::class);
        GroundMonitorBox::observe(GroundMonitorBoxObserver::class);
        Ionizer::observe(IonizerObserver::class);
        Packaging::observe(PackagingObserver::class);
        Soldering::observe(SolderingObserver::class);
        Worksurface::observe(WorksurfaceObserver::class);
        Ticket::observe(TicketObserver::class);
        MasterWip::observe(MasterWipObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
