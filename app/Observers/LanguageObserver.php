<?php

namespace App\Observers;

use App\Models\Language;
use App\Traits\Loggable;

class LanguageObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Language::class;
    }


    /**
     * Handle the Language "created" event.
     */
    public function created(Language $language): void
    {
        $this->log('create', $language->id, $language->toArray(), $this->model);
    }

    /**
     * Handle the Language "updated" event.
     */
    public function updated(Language $language): void
    {
        $this->updateLog($language, $this->model);
    }

    /**
     * Handle the Language "deleted" event.
     */
    public function deleted(Language $language): void
    {
        $this->log('delete', $language->id, $language->toArray(), $this->model);
    }

    /**
     * Handle the Language "restored" event.
     */
    public function restored(Language $language): void
    {
        // $this->log('restore', $language->id, $language->toArray(), $this->model);
    }

    /**
     * Handle the Language "force deleted" event.
     */
    public function forceDeleted(Language $language): void
    {
        // $this->log('force delete', $language->id, $language->toArray(), $this->model);
    }
}
