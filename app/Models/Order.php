<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property string street
 * @property int house_number
 * @property string house_number_addition
 * @property string postal_code
 * @property string city
 * @property string country
 * @property int number
 * @property int order_status_id
 */
class Order extends Model
{
    use HasFactory;

    public function orderStatus(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    public function getAddress(): string
    {
        return sprintf("%s %b%s, %s, %s, %s",
            $this->street,
            $this->house_number,
            $this->house_number_addition,
            $this->postal_code,
            $this->city,
            $this->country
        );
    }

    public function addAddressToCollection()
    {
        $this->address = $this->getAddress();
    }
}
