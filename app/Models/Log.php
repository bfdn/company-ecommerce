<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Log extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $dateFormat = "Y-m-d H:i:s";
    protected $casts = [
        //'data' => "array"
    ];

    public const ACTIONS = [
        'create',
        "update",
        "delete",
        "force delete",
        "restore",
        "login",
        "logout",
        "verify user",
        "password reset mail send",
    ];

    public const MODELS = [
        Settings::class,
        User::class,
        Role::class,
        Permission::class,
    ];

    public function loggable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
