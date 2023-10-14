<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'product_id'];
    protected $table = "category_products";

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
