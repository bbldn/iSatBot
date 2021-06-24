<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int|null id
 * @property string|null name
 * @property string|null labelLeft
 * @property string|null labelRight
 *
 * @method static StateType|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static StateType create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class StateType extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const labelLeft = 'label_left';

    public const labelRight = 'label_right';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'state_types';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [self::name, self::labelLeft, self::labelRight];
}