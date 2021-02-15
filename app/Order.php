<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer|null id
 * @property integer|null front_id
 * @property integer|null back_id
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static OrderBack create($attributes)
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
