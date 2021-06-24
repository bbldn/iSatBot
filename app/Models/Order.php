<?php

namespace App\Models;

use App\Models\Back\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property integer|null id
 * @property integer|null front_id
 * @property integer|null back_id
 * @method static Order|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Order create($attributes)
 */
class Order extends Model
{
    public const id = 'id';

    public const backId = 'back_id';

    public const frontId = 'front_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'orders';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $connection = 'mysql_synchronizer';

    /** @var string[] */
    protected $fillable = [
        self::backId,
        self::frontId,
    ];
}