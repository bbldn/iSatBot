<?php


namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null name
 * @property int|null sort_order
 * @property int|null manager_id
 * @property int|null currency_id
 * @property Customer|null manager
 * @property Currency|null currency
 *
 * @method static Warehouse|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Warehouse create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Warehouse extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const sortOrder = 'sort_order';

    public const managerId = 'manager_id';

    public const currencyId = 'currency_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'warehouses';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [
        self::name,
        self::sortOrder,
        self::managerId,
        self::currencyId,
    ];

    /**
     * @return HasOne
     */
    public function manager(): HasOne
    {
        return $this->hasOne(Customer::class, Customer::id, self::managerId);
    }

    /**
     * @return HasOne
     */
    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, Currency::id, self::currencyId);
    }
}