<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Mail\VerifyMail;
use App\Models\UserVerify;
use App\Notifications\VerifyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendVerifyMailListener
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
    public function handle(UserRegisteredEvent $event): void
    {
        $token = Str::random("60");

        UserVerify::create([
            'user_id' => $event->user->id,
            'token' => $token
        ]);


        // Mail Gönderme İşlemi
        $event->user->notify(new VerifyNotification($token));
    }
}
