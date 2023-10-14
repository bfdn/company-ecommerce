<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Enums\TaxEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $translatable = ['name', 'slug', 'content', 'seo_keywords', 'seo_description'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'status' => StatusEnum::class,
        'popular' => StatusEnum::class,
        'tax' => TaxEnum::class,
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
        }
        return parent::resolveRouteBinding($value, $field);
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, "brand_id", "id");
    }

    public function categoriesPluck(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "category_products");
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, "category_products");
    }
}
