<?php

namespace App\Models\Back;

use DateTimeInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property string|null fio
 * @property int|null group_id
 * @property string|null phone
 * @property string|null comment
 * @property CustomerGroup|null group
 * @property DateTimeInterface|null created_at
 * @property CustomerInformation|null information
 *
 * @method static Customer|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Customer create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class Customer extends ModelBack
{
    public const id = 'id';

    public const fio = 'fio';

    public const phone = 'phone';

    public const comment = 'comment';

    public const groupId = 'group_id';

    public const createdAt = 'created_at';

    const CREATED_AT = 'created_at';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'customers';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $dates = [self::createdAt];

    /** @var string[] */
    protected $fillable = [
        self::id,
        self::fio,
        self::phone,
        self::comment,
        self::groupId,
        self::createdAt,
    ];

    /**
     * @return HasOne
     */
    public function group(): HasOne
    {
        return $this->hasOne(CustomerGroup::class, CustomerGroup::id, self::groupId);
    }

    /**
     * @return HasOne
     */
    public function information(): HasOne
    {
        return $this->hasOne(CustomerInformation::class, CustomerInformation::id, self::id);
    }
}