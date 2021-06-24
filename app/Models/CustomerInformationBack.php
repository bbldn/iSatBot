<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer|null id
 * @property string|null address
 * @property integer|null stateId
 * @property integer|null countryId
 * @property integer|null localityId
 * @property CustomerBack|null customer
 * @property integer|null orderStatusId
 * @property integer|null pickUpPointId
 * @property integer|null paymentMethodId
 * @property integer|null shippingMethodId
 *
 * @method static Collection all($columns = ['*'])
 * @method static CustomerInformationBack|null find(integer $id)
 * @method static CustomerInformationBack create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerInformationBack extends Model
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

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $connection = 'mysql_back';

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
    public function customer(): HasOne
    {
        return $this->hasOne(CustomerBack::class, CustomerBack::id, self::id);
    }
}