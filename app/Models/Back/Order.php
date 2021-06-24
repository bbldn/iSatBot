<?php

namespace App\Models\Back;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null ip
 * @property string|null fio
 * @property string|null email
 * @property string|null phone
 * @property float|null total
 * @property int|null type_id
 * @property int|null shop_id
 * @property int|null state_id
 * @property string|null comment
 * @property string|null address
 * @property bool|null archival
 * @property int|null status_id
 * @property string|null user_agent
 * @property int|null country_id
 * @property int|null customer_id
 * @property int|null locality_id
 * @property int|null warehouse_id
 * @property string|null track_number
 * @property float|null delivery_total
 * @property int|null pick_up_point_id
 * @property int|null delivery_order_id
 * @property int|null customer_group_id
 * @property int|null payment_method_id
 * @property int|null delivery_currency_id
 * @property float|null payment_currency_value
 * @property float|null delivery_currency_value
 * @property int|null delivery_payment_method_id
 * @property DateTimeInterface|null created_at
 * @property DateTimeInterface|null updated_at
 * @property DateTimeInterface|null delivery_created_at
 * @property DateTimeInterface|null track_number_created_at
 *
 * @property Shop|null shop
 * @property State|null state
 * @property Country|null country
 *
 * @method static Order|null find(int $id)
 * @method static Order create(array $attributes)
 * @method static Collection all(array $columns = ['*'])
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
    protected $dates = [
        self::createdAt,
        self::updatedAt,
        self::deliveryCreatedAt,
        self::trackNumberCreatedAt,
    ];

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
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class, Shop::id, self::shopId);
    }

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
    public function status(): HasOne
    {
        return $this->hasOne(OrderStatus::class, OrderStatus::id, self::statusId);
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
    public function customerGroup(): HasOne
    {
        return $this->hasOne(CustomerGroup::class, CustomerGroup::id, self::customerGroupId);
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