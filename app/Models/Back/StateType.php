<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property integer|null id
 * @property string|null name
 * @property string|null labelLeft
 * @property string|null labelRight
 *
 * @method static Collection all($columns = ['*'])
 * @method static StateType|null find(integer $id)
 * @method static StateType create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class StateType extends Model
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
    protected $fillable = [
        self::name,
        self::labelLeft,
        self::labelRight,
    ];
}