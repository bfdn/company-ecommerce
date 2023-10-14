<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\TaxEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "order_id",
        "product_id",
        "price",
        "qty",
        "total_price",
        "tax",
        "tax_price",
        "order_detail_status"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'order_detail_status' => OrderStatusEnum::class,
        'tax' => TaxEnum::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, "order_id", "id");
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "product_id", "id");
    }
}
