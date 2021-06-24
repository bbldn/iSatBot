<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int|null id
 * @property int|null sort_order
 * @property CustomerGroupDescription[]|Collection descriptions
 * @method static Collection all($columns = ['*'])
 * @method static CustomerGroup|null find(int $id)
 * @method static CustomerGroup create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerGroup extends ModelBack
{
    public const id = 'id';

    public const sortOrder = 'sort_order';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'customers_groups';

    /** @var string[] */
    protected $fillable = [
        self::id,
        self::sortOrder,
    ];

    /**
     * @return HasMany
     */
    public function descriptions(): HasMany
    {
        return $this->hasMany(CustomerGroupDescription::class, CustomerGroupDescription::id, self::id);
    }
}