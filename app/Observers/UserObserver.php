<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Traits\Loggable;

class UserObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = User::class;
    }


    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        $this->log("create", $user->id, $user->toArray(), $this->model, true);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('password')) {
            $user->notify(new PasswordChangedNotification($user));
        }
        if (!$user->wasChanged('password')) {
            $this->updateLog($user, $this->model);
        }

        // dd($user);


    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        $this->log("delete", $user->id,  $user->toArray(), $this->model);
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // $this->log("restore", $user->id, $user->toArray(), $this->model);
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // $this->log("force delete", $user->id, $user->toArray(), $this->model);
    }
}
