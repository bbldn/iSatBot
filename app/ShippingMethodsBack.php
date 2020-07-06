<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer SID
 * @property string|null Name
 * @property string|null description
 * @property string|null email_comments_text
 * @property integer|null Enabled
 * @property integer|null module_id
 * @property integer|null sort_order
 * @property string warehouses
 * @property DateTime warehouses_last_update
 * @property string key
 * @method static ShippingMethodsBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static ShippingMethodsBack create($attributes)
 */
class ShippingMethodsBack extends Model
{
    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var array $fillable */
    protected $fillable = [
        'Name', 'description', 'email_comments_text',
        'Enabled', 'module_id', 'sort_order',
        'warehouses', 'warehouses_last_update',
        'key',
    ];

    /** @var string $connection */
    protected $connection = 'mysql_back';

    /** @var string $table */
    protected $table = 'SS_shipping_methods';

    /** @var array $attributes */
    protected $attributes = [
        'Name' => null,
        'description' => null,
        'email_comments_text' => null,
        'Enabled' => null,
        'module_id' => null,
        'sort_order' => 0,
        'warehouses' => '',
    ];

    /** @var array $dates */
    protected $dates = [
        'warehouses_last_update',
    ];

    /** @var string $primaryKey */
    protected $primaryKey = 'SID';

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(OrderBack::class, 'delivery', $this->primaryKey)
            ->where('SS_orders_gamepost.id', '=', 'SS_orders_gamepost.order_num');
    }
}
