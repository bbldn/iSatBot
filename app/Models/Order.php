<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int|null back_id
 * @property int|null front_id
 *
 * @method static Order|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Order create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class Order extends Model
{
    public const backId = 'back_id';

    public const frontId = 'front_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'orders';

    /** @var string */
    protected $connection = 'mysql_synchronizer';

    /** @var string[] */
    protected $fillable = [self::backId, self::frontId];
}