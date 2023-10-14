<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class Category extends Model
{
    use HasFactory, HasTranslations, HasRecursiveRelationships;


    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $translatable = ['name', 'slug', 'content', 'seo_keywords', 'seo_description'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'status' => StatusEnum::class,
    ];

    public function scopenotIsAdmin($query, $user)
    {
        // $user = Auth::user();
        return $query->when($user->is_admin != 1, fn ($query) => $query->where("user_id", $user->id));
    }

    public function getParentKeyName(): string
    {
        return 'parent_id';
    }



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
        // $locale = config('app.locale');

        if ($field == "slug") {
            $slugs = explode('/', $value);
            $slugCount = count($slugs);
            $slug = $slugCount > 1 ? end($slugs) : current($slugs);

            $locale = app()->getLocale();
            return $this
                ->query()
                ->where("$field->{$locale}", $slug)
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

    public function parentCategory(): BelongsTo
    {
        // return $this->hasOne(Category::class, "id", "parent_id")->withDefault([
        return $this->belongsTo(Category::class, "parent_id", "id")->withDefault([
            'name' => 'Ana Kategori'
        ]);
    }

    public function childCategories(): HasMany
    {
        // return $this->hasMany(Category::class, "parent_id", "id")->with("childCategories");
        return $this->hasMany(Category::class, "parent_id", "id");
    }

    // recursive, loads all descendants
    public function childrenRecursive()
    {
        return $this->childCategories()->with('childrenRecursive');
    }

    public function children()
    {
        return $this->childCategories()->with('children');
    }










    /********************************/

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function logs(): MorphMany
    {
        return $this->morphMany(Log::class, 'loggable');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_products');
    }

    public function recursiveProducts()
    {
        return $this->belongsToManyOfDescendantsAndSelf(Product::class, 'category_products');
    }
}
