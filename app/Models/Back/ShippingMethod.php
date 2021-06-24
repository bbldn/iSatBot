<?php

namespace App\Models\Back;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int SID
 * @property string|null Name
 * @property string|null description
 * @property string|null email_comments_text
 * @property int|null Enabled
 * @property int|null module_id
 * @property int|null sort_order
 * @property string warehouses
 * @property DateTime warehouses_last_update
 * @property string key
 * @method static Collection all($columns = ['*'])
 * @method static ShippingMethod create($attributes)
 * @method static ShippingMethod|null find(integer $id)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class ShippingMethod extends Model
{
    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [
        'Name', 'description', 'email_comments_text',
        'Enabled', 'module_id', 'sort_order',
        'warehouses', 'warehouses_last_update',
        'key',
    ];

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string */
    protected $table = 'SS_shipping_methods';

    /** @var array */
    protected $attributes = [
        'Name' => null,
        'description' => null,
        'email_comments_text' => null,
        'Enabled' => null,
        'module_id' => null,
        'sort_order' => 0,
        'warehouses' => '',
    ];

    /** @var string[] */
    protected $dates = [
        'warehouses_last_update',
    ];

    /** @var string */
    protected $primaryKey = 'SID';

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'delivery', $this->primaryKey)
            ->where('SS_orders_gamepost.id', '=', 'SS_orders_gamepost.order_num');
    }
}
