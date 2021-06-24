<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property string name
 * @property string data
 * @method static Collection all($columns = ['*'])
 * @method static ShippingMethod create($attributes)
 * @method static ShippingMethod|null find(integer $id)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class ShippingMethod extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const data = 'data';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'shipping_methods';

    /** @var string[] */
    protected $fillable = [self::id, self::name, self::data];
}