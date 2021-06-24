<?php


namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null name
 * @property int|null language_id
 * @property CustomerGroup|null customerGroup
 *
 * @method static Collection all(array $columns)
 * @method static CustomerGroupDescription create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class CustomerGroupDescription extends ModelBack
{
    public const id = 'id';

    public const name = 'name';

    public const languageId = 'language_id';

    /** @var bool */
    public $timestamps = false;

    /** @var bool */
    public $incrementing = false;

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'customers_groups_descriptions';

    /** @var string[] */
    protected $fillable = [
        self::id,
        self::name,
        self::languageId,
    ];

    /**
     * @return HasOne
     */
    public function customerGroup(): HasOne
    {
        return $this->hasOne(CustomerGroup::class, CustomerGroup::id, self::id);
    }
}