<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderStatus extends Model
{
    use HasFactory;

    public const ORDER_PAYMENT_WAITING = 1;
    public const ORDER_PAYMENT_CANCELED = 2;
    public const ORDER_PAYMENT_FAILED = 3;
    public const ORDER_PAYED = 4;
    public const ORDER_ON_THE_WAY = 5;
    public const ORDER_NOT_DELIVERED = 6;
    public const ORDER_DELIVERED_BY_PICKUP_POINT = 7;
    public const ORDER_DELIVERED = 8;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
