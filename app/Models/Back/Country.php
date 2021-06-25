<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

/**
 * @property int|null id
 * @property string|null name
 *
 * @method static Country|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Country create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Country extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    /** @var string */
    protected $table = 'countries';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [self::name];
}