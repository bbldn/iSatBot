<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @property integer id
 * @property string login
 * @property string password
 * @property string fio
 * @property string phone
 * @property string region
 * @property string city
 * @property string street
 * @property string house
 * @property string mail
 * @property string code
 * @property integer active
 * @property integer account
 * @property integer date_reg
 * @property integer date_acc_begin
 * @property integer date_acc_end
 * @property string vip
 * @property string image_small
 * @property string image_big
 * @property string info
 * @property string ip
 * @property string timestamp_online
 * @property string timestamp_active
 * @property string chatname_color
 * @property integer money_real
 * @property integer money_virtual
 * @property integer money_box
 * @property DateTime date_birth
 * @property integer referer
 * @property integer group_id
 * @property integer group_extra_id
 * @property integer shop_id
 * @property string comment
 * @property integer delivery
 * @property integer payment
 * @property string warehouse
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static OrderBack create($attributes)
 */
class CustomerBack extends Model
{
    /** @var array $fillable */
    protected $fillable = [
        'login', 'password', 'fio',
        'phone', 'region', 'city',
        'street', 'house', 'mail',
        'code', 'active', 'account',
        'date_reg', 'date_acc_begin',
        'date_acc_end', 'vip', 'image_small',
        'image_big', 'info', 'ip',
        'timestamp_online', 'timestamp_active',
        'chatname_color', 'money_real', 'money_virtual',
        'money_box', 'date_birth', 'referer',
        'group_id', 'group_extra_id', 'shop_id',
        'comment', 'delivery', 'payment',
        'warehouse',
    ];

    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $connection */
    protected $connection = 'mysql_back';

    /** @var string $table */
    protected $table = 'SS_buyers_gamepost';

    /** @var array $dates */
    protected $dates = [
        'date_birth',
    ];

    /** @var array $attributes */
    protected $attributes = [
        'vip' => '',
        'info' => '',
        'chatname_color' => '006084',
        'group_extra_id' => 1,
        'shop_id' => 1,
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderBack::class, 'client_id', 'id')
            ->where('SS_orders_gamepost.id', '=', 'SS_orders_gamepost.order_num');
    }

    /**
     * @return float
     */
    public function balance(): float
    {
        /** @noinspection SqlNoDataSourceInspection */
        /** @noinspection SqlDialectInspection */
        $sql = "
            SELECT 
                (IFNULL(cash.`income`, 0) - IFNULL(SUM(orders.`price` * orders.`amount`), 0)) as `balance` 
            FROM 
                SS_orders_gamepost orders 
            LEFT JOIN 
                (
                    SELECT 
                        SUM(`price` / `currency_value`) as `income`, `order_num` 
                    FROM 
                        SS_cash 
                    GROUP BY 
                        `order_num`
                ) cash 
            ON 
                cash.`order_num` = orders.`order_num`
            WHERE 
                orders.`status` != 9 AND orders.`client_id` = {$this->getKey()} 
            GROUP BY 
                cash.`income`;";
        $result = DB::connection($this->connection)->select($sql);

        return round($result[0]['balance'], 2);
    }
}
