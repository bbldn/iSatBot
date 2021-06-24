<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer|null id
 * @property integer|null sort_order
 * @property CustomerGroupDescriptionBack[]|Collection descriptions
 * @method static Collection all($columns = ['*'])
 * @method static CustomerGroupBack|null find(integer $id)
 * @method static CustomerGroupBack create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerGroupBack extends Model
{
    public const id = 'id';

    public const sortOrder = 'sort_order';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'customers_groups';

    /** @var string */
    protected $connection = 'mysql_back';

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
        return $this->hasMany(CustomerGroupDescriptionBack::class, CustomerGroupDescriptionBack::id, self::id);
    }
}