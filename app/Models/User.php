<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'status',
        'is_admin',
        'is_staff'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function scopenotIsAdmin($query, $user)
    {
        // $user = Auth::user();
        return $query->when($user->is_admin != 1, fn ($query) => $query->where("id", $user->id));
    }

    public function scopeStatus($query, $status)
    {
        if (!is_null($status))
            return $query->where("status", $status);
    }

    public function scopeSearchText($query, $searchText)
    {
        if (!is_null($searchText)) {
            return $query->where(function ($q) use ($searchText) {
                $q->where("name", "LIKE", "%" . $searchText . "%")
                    ->orWhere("email", "LIKE", "%" . $searchText . "%");
                // ->orWhere("username", "LIKE", "%" . $searchText . "%");
            });
        }
    }

    public function scopeDate($query, $date)
    {
        if (!is_null($date)) {
            return $query->whereDate('created_at', '=', date('Y-m-d', strtotime($date)));
        }
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, "user_id", "id");
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, "user_id", "id");
    }

    public function blogCategories(): HasMany
    {
        return $this->hasMany(BlogCategory::class, "user_id", "id");
    }

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class, "user_id", "id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "user_id", "id");
    }

    public function hasLogs(): HasMany
    {
        return $this->hasMany(Log::class, 'user_id', 'id');
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
