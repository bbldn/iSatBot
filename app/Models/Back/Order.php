<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property integer id
 * @method static Order|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Order create($attributes)
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

    public const deliveryOrderId = 'delivery_order_id';

    public const pickUpPointId = 'pick_up_point_id';

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

    /** @var string[] */
    protected $fillable = [];

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string */
    protected $table = 'orders';

    /** @var string[] */
    protected $dates = [];
}