<?php

namespace App\Observers;

use App\Models\Permission;
use App\Traits\Loggable;

class PermissionObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Permission::class;
    }


    /**
     * Handle the Permission "created" event.
     */
    public function created(Permission $permission): void
    {
        $this->log('create', $permission->id, $permission->toArray(), $this->model);
    }

    /**
     * Handle the Permission "updated" event.
     */
    public function updated(Permission $permission): void
    {
        $this->updateLog($permission, $this->model);
    }

    /**
     * Handle the Permission "deleted" event.
     */
    public function deleted(Permission $permission): void
    {
        $this->log('delete', $permission->id, $permission->toArray(), $this->model);
    }

    /**
     * Handle the Permission "restored" event.
     */
    public function restored(Permission $permission): void
    {
        // $this->log('restore', $permission->id, $permission->toArray(), $this->model);
    }

    /**
     * Handle the Permission "force deleted" event.
     */
    public function forceDeleted(Permission $permission): void
    {
        // $this->log('force delete', $permission->id, $permission->toArray(), $this->model);
    }
}
