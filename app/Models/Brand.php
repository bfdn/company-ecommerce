<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Brand extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function scopenotIsAdmin($query, $user)
    {
        // $user = Auth::user();
        return $query->when($user->is_admin != 1, fn ($query) => $query->where("user_id", $user->id));
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
