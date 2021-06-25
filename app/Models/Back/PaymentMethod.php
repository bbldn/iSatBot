<?php

namespace App\Models\Back;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property int id
 * @property string name
 *
 * @method static Collection all(array $columns)
 * @method static PaymentMethod|null find(int $id)
 * @method static PaymentMethod create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class PaymentMethod extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    /** @var bool */
    public $timestamps = false;

    /** @var string[] */
    protected $fillable = [self::name];

    /** @var string */
    protected $table = 'payment_methods';
}