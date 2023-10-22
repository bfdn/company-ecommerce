<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $translatable = ['name', 'slug', 'content', 'seo_keywords', 'seo_description'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'status' => StatusEnum::class,
    ];

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field == "slug") {
            $locale = app()->getLocale();
            return $this
                ->withWhereHas('category', fn ($query) => $query->select("id", "name", "slug"))
                ->where("$field->{$locale}", $value)
                ->active()
                ->firstOrFail();
        }
        return parent::resolveRouteBinding($value, $field);
    }

    /** SCOPES METHODS **/
    public function scopeActive($query)
    {
        return $query->where("status", 1);
    }

    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @return string
     */
    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function scopenotIsAdmin($query, $user)
    {
        // $user = Auth::user();
        return $query->when($user->is_admin != 1, fn ($query) => $query->where("user_id", $user->id));
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function category(): HasOne
    {
        return $this->hasOne(BlogCategory::class, "id", "blog_category_id");
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
