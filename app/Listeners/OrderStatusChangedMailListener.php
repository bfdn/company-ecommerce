<?php

namespace App\Listeners;

use App\Events\OrderStatusChangedEvent;
use App\Notifications\OrderStatusChangedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderStatusChangedMailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderStatusChangedEvent $event): void
    {
        $user = $event->user;
        $order = $event->order;

        $user->notify(new OrderStatusChangedNotification($order));
    }
}
