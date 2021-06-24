<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer id
 *
 * @method static Order create($attributes)
 * @method static Order|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Order extends Model
{
    public const id = 'id';

    public const ip = 'ip';

    public const fio = 'fio';

    public const email = 'email';

    public const phone = 'phone';

    public const total = 'total';

    public const typeId = 'type_id';

    public const shopId = 'shop_id';

    public const comment = 'comment';

    public const address = 'address';

    public const stateId = 'state_id';

    public const archival = 'archival';

    public const statusId = 'status_id';

    public const createdAt = 'created_at';

    public const updatedAt = 'updated_at';

    public const userAgent = 'user_agent';

    public const countryId = 'country_id';

    public const customerId = 'customer_id';

    public const localityId = 'locality_id';

    public const warehouseId = 'warehouse_id';

    public const trackNumber = 'track_number';

    public const deliveryTotal = 'delivery_total';

    public const pickUpPointId = 'pick_up_point_id';

    public const deliveryOrderId = 'delivery_order_id';

    public const customerGroupId = 'customer_group_id';

    public const paymentMethodId = 'payment_method_id';

    public const shippingMethodId = 'shipping_method_id';

    public const paymentCurrencyId = 'payment_currency_id';

    public const deliveryCreatedAt = 'delivery_created_at';

    public const deliveryCurrencyId = 'delivery_currency_id';

    public const paymentCurrencyValue = 'payment_currency_value';

    public const trackNumberCreatedAt = 'track_number_created_at';

    public const deliveryCurrencyValue = 'delivery_currency_value';

    public const deliveryPaymentMethodId = 'delivery_payment_method_id';

    /** @var string */
    protected $table = 'orders';

    /** @var string */
    const CREATED_AT = 'created_at';

    /** @var string */
    const UPDATED_AT = 'updated_at';

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string[] */
    protected $dates = [self::createdAt, self::updatedAt, self::deliveryCreatedAt];

    /** @var string[] */
    protected $fillable = [
        self::deliveryPaymentMethodId,
        self::id, self::ip, self::fio,
        self::email, self::phone, self::total,
        self::typeId, self::shopId, self::comment,
        self::address, self::stateId, self::archival,
        self::statusId, self::createdAt, self::updatedAt,
        self::userAgent, self::countryId, self::customerId,
        self::localityId, self::warehouseId, self::trackNumber,
        self::deliveryTotal, self::pickUpPointId, self::deliveryOrderId,
        self::customerGroupId, self::paymentMethodId, self::shippingMethodId,
        self::paymentCurrencyId, self::deliveryCreatedAt, self::deliveryCurrencyId,
        self::paymentCurrencyValue, self::trackNumberCreatedAt, self::deliveryCurrencyValue,
    ];

    /**
     * @return HasOne
     */
    public function state(): HasOne
    {
        return $this->hasOne(State::class, State::id, self::stateId);
    }

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(Country::class, Country::id, self::countryId);
    }

    /**
     * @return HasOne
     */
    public function deliveryOrder(): HasOne
    {
        return $this->hasOne(Order::class, Order::id, self::deliveryOrderId);
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, Customer::id, self::customerId);
    }

    /**
     * @return HasOne
     */
    public function locality(): HasOne
    {
        return $this->hasOne(Locality::class, Locality::id, self::localityId);
    }

    /**
     * @return HasOne
     */
    public function pickUpPoint(): HasOne
    {
        return $this->hasOne(PickUpPoint::class, PickUpPoint::id, self::pickUpPointId);
    }

    /**
     * @return HasOne
     */
    public function paymentMethod(): HasOne
    {
        return $this->hasOne(PaymentMethod::class, PaymentMethod::id, self::paymentMethodId);
    }

    /**
     * @return HasOne
     */
    public function shippingMethod(): HasOne
    {
        return $this->hasOne(ShippingMethod::class, ShippingMethod::id, self::shippingMethodId);
    }
}