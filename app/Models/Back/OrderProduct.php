<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null name
 * @property float|null price
 * @property float|null total
 * @property int|null order_id
 * @property int|null quantity
 * @property int|null product_id
 * @property float|null delivery_total
 * @property float|null delivery_price
 * @property string|null serial_numbers
 * @property int|null payment_currency_id
 * @property int|null delivery_currency_id
 * @property float|null payment_currency_value
 * @property float|null delivery_currency_value
 *
 * @method static Collection all(array $columns)
 * @method static OrderProduct|null find(int $id)
 * @method static OrderProduct create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class OrderProduct extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const price = 'price';

    public const total = 'total';

    public const orderId = 'order_id';

    public const quantity = 'quantity';

    public const productId = 'product_id';

    public const serialNumbers = 'serial_numbers';

    public const deliveryTotal = 'delivery_total';

    public const deliveryPrice = 'delivery_price';

    public const paymentCurrencyId = 'payment_currency_id';

    public const deliveryCurrencyId = 'delivery_currency_id';

    public const paymentCurrencyValue = 'payment_currency_value';

    public const deliveryCurrencyValue = 'delivery_currency_value';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'orders_products';

    /** @var string[] */
    protected $fillable = [
        self::deliveryCurrencyValue,
        self::name, self::price, self::total,
        self::orderId, self::quantity, self::productId,
        self::serialNumbers, self::deliveryTotal, self::deliveryPrice,
        self::deliveryCurrencyId, self::paymentCurrencyId, self::paymentCurrencyValue,
    ];

    /**
     * @return HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, Order::id, self::orderId);
    }

    /**
     * @return HasOne
     */
    public function paymentCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, Currency::id, self::paymentCurrencyId);
    }

    /**
     * @return HasOne
     */
    public function deliveryCurrency(): HasOne
    {
        return $this->hasOne(Currency::class, Currency::id, self::deliveryCurrencyId);
    }
}