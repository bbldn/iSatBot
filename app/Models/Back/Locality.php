<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null id
 * @property string|null name
 * @property string|null uuid
 * @property string|null data
 * @property State|null state
 * @property bool|null enabled
 * @property PickUpPoint[]|Collection pickUpPoints
 *
 * @method static Locality|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Locality create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Locality extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const uuid = 'uuid';

    public const data = 'data';

    public const enabled = 'enabled';

    public const stateId = 'state_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'localities';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [
        self::name, self::uuid,
        self::data, self::stateId, self::enabled,
    ];

    /**
     * @return HasOne
     */
    public function state(): HasOne
    {
        return $this->hasOne(State::class, State::id, self::stateId);
    }

    /**
     * @return HasMany
     */
    public function pickUpPoints(): HasMany
    {
        return $this->hasMany(PickUpPoint::class, PickUpPoint::localityId, self::id);
    }
}