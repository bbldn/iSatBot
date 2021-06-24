<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer|null id
 * @property string|null fio
 * @property string|null phone
 * @property string|null comment
 * @property integer|null group_id
 * @property DateTimeInterface|null created_at
 * @method static OrderBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static OrderBack create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class CustomerBack extends Model
{
    public const id = 'id';

    public const fio = 'fio';

    public const phone = 'phone';

    public const comment = 'comment';

    public const groupId = 'group_id';

    public const createdAt = 'created_at';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'customers';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $dates = [self::createdAt];

    /** @var string */
    protected $connection = 'mysql_back';

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
    public function information(): HasOne
    {
        return $this->hasOne(CustomerInformationBack::class, CustomerInformationBack::id, self::id);
    }
}