<?php

namespace App\Providers;

use App\Events\OrderCreatedEvent;
use App\Events\OrderStatusChangedEvent;
use App\Events\UserRegisteredEvent;
use App\Listeners\OrderCreatedMailListener;
use App\Listeners\OrderStatusChangedMailListener;
use App\Listeners\SendVerifyMailListener;
use App\Models\Permission;
use App\Models\Product;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Observers\PermissionObserver;
use App\Observers\ProductObserver;
use App\Observers\RoleObserver;
use App\Observers\SettingsObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        UserRegisteredEvent::class => [ // Event
            SendVerifyMailListener::class // Listener
        ],
        OrderCreatedEvent::class => [
            OrderCreatedMailListener::class
        ],
        OrderStatusChangedEvent::class => [
            OrderStatusChangedMailListener::class
        ]
    ];

    // Observer Ekleme
    protected $observers = [
        Settings::class => SettingsObserver::class,
        User::class => UserObserver::class,
        Role::class => RoleObserver::class,
        Permission::class => PermissionObserver::class,
        Product::class => ProductObserver::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // User::observe(UserRegisteredObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
