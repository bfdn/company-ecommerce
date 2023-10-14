<?php

namespace App\Observers;

use App\Models\Role;
use App\Traits\Loggable;

class RoleObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = Role::class;
    }


    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $this->log('create', $role->id, $role->toArray(), $this->model);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        $this->updateLog($role, $this->model);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        $this->log('delete', $role->id, $role->toArray(), $this->model);
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        // $this->log('restore', $role->id, $role->toArray(), $this->model);
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        // $this->log('force delete', $role->id, $role->toArray(), $this->model);
    }
}
