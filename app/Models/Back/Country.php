<?php


namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;

/**
 * @property integer|null id
 * @property string|null name
 *
 * @method static Collection all($columns = ['*'])
 * @method static Country|null find(integer $id)
 * @method static Country create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Country
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