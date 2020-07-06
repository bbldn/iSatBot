<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer id
 * @property integer|null front_id
 * @property integer|null back_id
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static OrderBack create($attributes)
 */
class Order extends Model
{
    /** @var array $fillable */
    protected $fillable = ['front_id', 'back_id'];

    /** @var bool $timestamps */
    public $timestamps = false;

    /** @var string $connection */
    protected $connection = 'mysql_synchronizer';

    /** @var string $table */
    protected $table = 'orders';
}
