<?php

namespace App\Listeners;

use App\Events\OrderCreatedEvent;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderCreatedMailListener
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
    public function handle(OrderCreatedEvent $event): void
    {
        // $user = $event->user;
        $order = $event->order;

        // Mail Gönderme İşlemi
        $event->user->notify(new OrderCreatedNotification($order));
    }
}
