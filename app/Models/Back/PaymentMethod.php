<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property string name
 * @method static Collection all($columns = ['*'])
 * @method static PaymentMethod create($attributes)
 * @method static PaymentMethod|null find(integer $id)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class PaymentMethod extends Model
{
    public const id = 'id';

    public const name = 'name';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string */
    protected $table = 'payment_methods';

    /** @var string[] */
    protected $fillable = [self::id, self::name];
}