<?php

namespace App\Observers;

use App\Models\Settings;
use App\Traits\Loggable;

class SettingsObserver
{

    use Loggable;

    public function __construct()
    {
        $this->model = Settings::class;
    }


    /**
     * Handle the Settings "created" event.
     */
    public function created(Settings $settings): void
    {
        //
    }

    /**
     * Handle the Settings "updated" event.
     */
    public function updated(Settings $settings): void
    {
        $this->updateLog($settings, $this->model);
    }

    /**
     * Handle the Settings "deleted" event.
     */
    public function deleted(Settings $settings): void
    {
        //
    }

    /**
     * Handle the Settings "restored" event.
     */
    public function restored(Settings $settings): void
    {
        //
    }

    /**
     * Handle the Settings "force deleted" event.
     */
    public function forceDeleted(Settings $settings): void
    {
        //
    }
}
