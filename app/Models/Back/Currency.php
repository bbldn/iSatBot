<?php

namespace App\Models\Back;

use DateTimeInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|null id
 * @property string|null name
 * @property string|null code
 * @property float|null value
 * @property bool|null enabled
 * @property string|null symbol_left
 * @property string|null symbol_right
 * @property string|null decimal_place
 * @property DateTimeInterface|null updated_at
 *
 * @method static Currency|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Currency create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class Currency extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const code = 'code';

    public const value = 'value';

    public const enabled = 'enabled';

    public const updatedAt = 'updated_at';

    public const symbolLeft = 'symbol_left';

    public const symbolRight = 'symbol_right';

    public const decimalPlace = 'decimal_place';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'currencies';

    /** @var string */
    const UPDATED_AT = 'updated_at';

    /** @var string[] */
    protected $dates = [self::updatedAt];

    /** @var string[] */
    protected $fillable = [
        self::name, self::code, self::value,
        self::symbolRight, self::decimalPlace,
        self::enabled, self::updatedAt, self::symbolLeft,
    ];
}