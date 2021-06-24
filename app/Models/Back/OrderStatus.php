<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int|null id
 * @property string|null name
 * @property string|null data
 *
 * @method static OrderStatus|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static OrderStatus create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class OrderStatus extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const data = 'data';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'orders_statuses';

    /** @var string[] */
    protected $fillable = [self::name, self::data];
}