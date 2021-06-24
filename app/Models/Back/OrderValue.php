<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderValue extends ModelBack
{
    public const value = 'value';

    public const constId = 'constId';

    public const orderId = 'order_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'orders_values';

    /** @var string */
    protected $primaryKey = self::orderId;

    /** @var string[] */
    protected $fillable = [self::value, self::constId, self::orderId];

    /**
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, Order::id, self::orderId);
    }
}