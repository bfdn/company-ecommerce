<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Hash;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $translatable = ['name', 'slug', 'content', 'seo_keywords', 'seo_description'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'status' => StatusEnum::class,
    ];

    /** GENERAL **/

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
                ->query()
                ->where("$field->{$locale}", $value)
                ->active()
                ->firstOrFail();
        } else {
            // return parent::resolveRouteBinding($value, $field);
            return parent::resolveRouteBinding($value, $field);
        }
    }

    public function resolveRouteBinding_yedek($value, $field = null)
    {
        $locale = app()->getLocale();
        return $this
            ->query()
            ->withWhereHas('articles', fn ($query) => $query->active())
            ->withWhereHas('articles.user', fn ($query) => $query->select("id", "name", "email")->active())
            ->withWhereHas('articles.category', fn ($query) => $query->active())
            ->where("$field->{$locale}", $value)
            ->active()
            ->firstOrFail();
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


    /** SCOPES **/

    public function scopenotIsAdmin($query, $user)
    {
        // $user = Auth::user();
        return $query->when($user->is_admin != 1, fn ($query) => $query->where("user_id", $user->id));
    }


    /**  RELATIONSHIPS **/

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, "blog_category_id", "id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }
}
