<?php


namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|null id
 * @property string|null name
 *
 * @method static OrderType|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static OrderType create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class OrderType extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'orders_types';

    /** @var string[] */
    protected $fillable = [self::name];
}