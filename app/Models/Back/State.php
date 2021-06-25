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
 * @property int|null type_id
 * @property int|null country_id
 * @property StateType|null type
 * @property Country|null country
 * @property Locality[]|Collection localities
 *
 * @method static State|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static State create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class State extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const uuid = 'uuid';

    public const data = 'data';

    public const typeId = 'type_id';

    public const countryId = 'country_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'states';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [
        self::name, self::uuid,
        self::data, self::typeId, self::countryId,
    ];

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(Country::class, Country::id, self::countryId);
    }

    /**
     * @return HasOne
     */
    public function type(): HasOne
    {
        return $this->hasOne(StateType::class, StateType::id, self::typeId);
    }

    /**
     * @return HasMany
     */
    public function localities(): HasMany
    {
        return $this->hasMany(Locality::class, Locality::stateId, self::id);
    }
}