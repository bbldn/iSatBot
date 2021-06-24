<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property string name
 * @property string data
 *
 * @method static Collection all(array $columns)
 * @method static ShippingMethod|null find(int $id)
 * @method static ShippingMethod create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
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