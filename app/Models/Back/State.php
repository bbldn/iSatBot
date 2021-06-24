<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer|null id
 * @property string|null name
 * @property string|null uuid
 * @property string|null data
 * @property Country|null country
 * @property integer|null type_id
 * @property integer|null country_id
 *
 * @method static State|null find(integer $id)
 * @method static State create(array $attributes)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class State extends Model
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
        self::name,
        self::uuid,
        self::data,
        self::typeId,
        self::countryId,
    ];

    /**
     * @return HasOne
     */
    public function country(): HasOne
    {
        return $this->hasOne(Country::class, Country::id, self::countryId);
    }
}