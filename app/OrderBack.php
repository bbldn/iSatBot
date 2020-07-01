<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
