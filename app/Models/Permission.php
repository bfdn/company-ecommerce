<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Permission\Models\Permission as PermissionModel;

class Permission extends PermissionModel
{
    use HasFactory;

    public $hidden = ['guard_name', 'updated_at'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];
}
