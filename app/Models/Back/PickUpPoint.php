<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null name
 * @property string|null uuid
 * @property string|null data
 * @property State|null state
 * @property bool|null enabled
 * @property int|null locality_id
 * @property Locality|null locality
 * @property int|null shipping_method_id
 * @property ShippingMethod|null shippingMethod
 *
 * @method static PickUpPoint|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static PickUpPoint create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class PickUpPoint extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const uuid = 'uuid';

    public const data = 'data';

    public const enabled = 'enabled';

    public const localityId = 'locality_id';

    public const shippingMethodId = 'shipping_method_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'pick_up_points';

    /** @var string[] */
    protected $fillable = [
        self::name, self::uuid, self::data,
        self::enabled, self::localityId, self::shippingMethodId,
    ];

    /**
     * @return HasOne
     */
    public function locality(): HasOne
    {
        return $this->hasOne(Locality::class, Locality::id, self::localityId);
    }

    /**
     * @return HasOne
     */
    public function shippingMethod(): HasOne
    {
        return $this->hasOne(ShippingMethod::class, ShippingMethod::id, self::shippingMethodId);
    }
}