<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Enums\PaymentTypeEnum;
use App\Enums\YesNoEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "user_id",
        "payment_method",
        "order_status",
        "total_price",
        "tax_total_price",
        "total_qty",
        "name",
        "surname",
        "company",
        "address",
        "email",
        "phone",
        "same_address",
        "notes",
        // "payment_type"
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'order_status' => OrderStatusEnum::class,
        'payment_method' => PaymentTypeEnum::class,
        'same_address' => YesNoEnum::class,
        // 'tax' => TaxEnum::class,
    ];

    public function details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id");
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }
}
