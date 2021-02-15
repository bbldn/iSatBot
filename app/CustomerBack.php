<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property string|null ip
 * @property integer|null id
 * @property string|null vip
 * @property string|null fio
 * @property string|null code
 * @property string|null city
 * @property string|null mail
 * @property string|null info
 * @property string|null login
 * @property string|null house
 * @property string|null phone
 * @property string|null region
 * @property string|null street
 * @property string|null comment
 * @property integer|null active
 * @property integer|null account
 * @property integer|null referer
 * @property integer|null payment
 * @property string|null password
 * @property integer|null shop_id
 * @property integer|null date_reg
 * @property integer|null group_id
 * @property string|null warehouse
 * @property string|null image_big
 * @property integer|null delivery
 * @property integer|null money_box
 * @property string|null image_small
 * @property integer|null money_real
 * @property DateTime|null date_birth
 * @property integer|null date_acc_end
 * @property string|null chatname_color
 * @property integer|null money_virtual
 * @property integer|null group_extra_id
 * @property integer|null date_acc_begin
 * @property string|null timestamp_active
 * @property string|null timestamp_online
 * @method static OrderBack create(array $attributes)
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerBack extends Model
{
    public const ip = 'ip';

    public const id = 'id';

    public const vip = 'vip';

    public const fio = 'fio';

    public const code = 'code';

    public const city = 'city';

    public const mail = 'mail';

    public const info = 'info';

    public const login = 'login';

    public const house = 'house';

    public const phone = 'phone';

    public const active = 'active';

    public const region = 'region';

    public const street = 'street';

    public const shopId = 'shop_id';

    public const comment = 'comment';

    public const account = 'account';

    public const referer = 'referer';

    public const payment = 'payment';

    public const dateReg = 'date_reg';

    public const groupId = 'group_id';

    public const password = 'password';

    public const delivery = 'delivery';

    public const imageBig = 'image_big';

    public const moneyBox = 'money_box';

    public const warehouse = 'warehouse';

    public const moneyReal = 'money_real';

    public const dateBirth = 'date_birth';

    public const imageSmall = 'image_small';

    public const dateAccEnd = 'date_acc_end';

    public const moneyVirtual = 'money_virtual';

    public const groupExtraId = 'group_extra_id';

    public const dateAccBegin = 'date_acc_begin';

    public const chatnameColor = 'chatname_color';

    public const timestampActive = 'timestamp_active';

    public const timestampOnline = 'timestamp_online';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string */
    protected $table = 'SS_buyers_gamepost';

    /** @var array<string, mixed> */
    protected $attributes = [
        self::vip => '',
        self::info => '',
        self::shopId => 1,
        self::groupExtraId => 1,
        self::chatnameColor => '006084',
    ];

    /** @var string[] */
    protected $dates = [
        self::dateBirth,
    ];

    /** @var string[] */
    protected $fillable = [
        self::ip,
        self::vip,
        self::fio,
        self::code,
        self::city,
        self::mail,
        self::info,
        self::login,
        self::house,
        self::phone,
        self::active,
        self::region,
        self::street,
        self::shopId,
        self::comment,
        self::account,
        self::referer,
        self::payment,
        self::dateReg,
        self::groupId,
        self::password,
        self::delivery,
        self::imageBig,
        self::moneyBox,
        self::warehouse,
        self::moneyReal,
        self::dateBirth,
        self::imageSmall,
        self::dateAccEnd,
        self::moneyVirtual,
        self::groupExtraId,
        self::dateAccBegin,
        self::chatnameColor,
        self::timestampActive,
        self::timestampOnline,
    ];

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderBack::class, OrderBack::clientId, self::id)
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
                orders.`status` != ? AND orders.`client_id` = ?
            GROUP BY
                cash.`income`;";

        $result = DB::connection($this->connection)->select($sql, [9, $this->getKey()]);

        if (0 === count($result)) {
            return 0;
        }

        return round($result[0]->balance, 2);
    }
}
