<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer id
 * @property string type
 * @property string product_name
 * @property integer product_id
 * @property float price
 * @property integer amount
 * @property string currency_name
 * @property string parent_name
 * @property string phone
 * @property string fio
 * @property string region
 * @property string city
 * @property string street
 * @property string house
 * @property string warehouse
 * @property string mail
 * @property string whant
 * @property string vip_num
 * @property integer time
 * @property integer status
 * @property string comments
 * @property integer archive
 * @property integer read
 * @property bool synchronize
 * @property bool client_id
 * @property bool payment
 * @property bool delivery
 * @property integer order_num
 * @property string track_number
 * @property DateTime track_number_date
 * @property bool money_given
 * @property bool track_sent
 * @property string serial_num
 * @property integer shop_id
 * @property integer shop_id_counterparty
 * @property integer payment_wait_days
 * @property float payment_wait_first_sum
 * @property integer document_id
 * @property integer document_type
 * @property DateTime invoice_sent
 * @property float currency_value
 * @property string currency_value_when_purchasing
 * @property float shipping_price
 * @property float shipping_price_old
 * @property string shipping_currency_name
 * @property float shipping_currency_value
 * @property CustomerBack|null customer
 * @property ShippingMethodsBack|null shipping
 * @property PaymentBack|null paymentObject
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static OrderBack create($attributes)
 */
class OrderBack extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'type', 'product_name', 'product_id', 'price',
        'amount', 'currency_name', 'parent_name',
        'phone', 'fio', 'region', 'city',
        'street', 'house', 'warehouse',
        'mail', 'whant', 'vip_num', 'time',
        'status', 'comments', 'archive', 'read',
        'synchronize', 'client_id', 'payment',
        'delivery', 'order_num', 'track_number',
        'track_number_date', 'money_given',
        'track_sent', 'serial_num', 'shop_id',
        'shop_id_counterparty', 'payment_wait_days',
        'payment_wait_first_sum', 'payment_date',
        'document_id', 'document_type',
        'invoice_sent', 'currency_value',
        'currency_value_when_purchasing', 'shipping_price',
        'shipping_price_old', 'shipping_currency_name',
        'shipping_currency_value',
    ];

    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $connection */
    protected $connection = 'mysql_back';

    /** @var string $table */
    protected $table = 'SS_orders_gamepost';

    /** @var array $attributes */
    protected $attributes = [
        'product_name' => '',
        'whant' => '',
        'amount' => 1,
        'currency_name' => 'грн',
        'status' => 1,
        'comments' => '',
        'serial_num' => '',
        'document_type' => 2,
    ];

    /** @var array $dates */
    protected $dates = [
        'track_number_date',
        'invoice_sent',
    ];

    /** @var array $casts */
    protected $casts = [
        'price' => 'float',
        'payment_wait_first_sum' => 'float',
        'currency_value' => 'float',
        'shipping_price' => 'float',
        'shipping_price_old' => 'float',
        'shipping_currency_value' => 'float',
    ];

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(CustomerBack::class, 'id', 'client_id');
    }

    /**
     * @return HasOne
     */
    public function shipping(): HasOne
    {
        return $this->hasOne(ShippingMethodsBack::class, 'id', 'delivery');
    }

    /**
     * @return HasOne
     */
    public function paymentObject(): HasOne
    {
        return $this->hasOne(PaymentBack::class, 'id', 'payment');
    }
}
