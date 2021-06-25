<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null constId
 * @property Order|null order
 * @property int|null order_id
 * @property string|null value
 *
 * @method static Collection all(array $columns)
 * @method static OrderValue create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
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