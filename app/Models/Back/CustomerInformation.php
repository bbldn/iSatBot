<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property State|null state
 * @property int|null stateId
 * @property int|null countryId
 * @property int|null localityId
 * @property string|null address
 * @property Country|null country
 * @property Customer|null customer
 * @property Locality|null locality
 * @property integer|null orderStatusId
 * @property integer|null pickUpPointId
 * @property PickUpPoint|null pickUpPoint
 * @property integer|null paymentMethodId
 * @property integer|null shippingMethodId
 * @property PaymentMethod|null paymentMethod
 * @property ShippingMethod|null shippingMethod
 *
 * @method static Collection all($columns = ['*'])
 * @method static CustomerInformation|null find(int $id)
 * @method static CustomerInformation create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerInformation extends ModelBack
{
    public const id = 'id';

    public const address = 'address';

    public const stateId = 'state_id';

    public const countryId = 'country_id';

    public const localityId = 'locality_id';

    public const orderStatusId = 'order_status_id';

    public const pickUpPointId = 'pick_up_point_id';

    public const paymentMethodId = 'payment_method_id';

    public const shippingMethodId = 'shipping_method_id';

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'customers_informations';

    protected $fillable = [
        self::id,
        self::address,
        self::stateId,
        self::countryId,
        self::localityId,
        self::orderStatusId,
        self::pickUpPointId,
        self::paymentMethodId,
        self::shippingMethodId,
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
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, Customer::id, self::id);
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