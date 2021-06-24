<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int|null id
 * @property User|null user
 * @property int|null user_id
 * @property string|null event
 *
 * @method static Listener|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static Listener create(array $attributes)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class Listener extends Model
{
    public const id = 'id';

    public const event = 'event';

    public const userId = 'user_id';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'listeners';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [self::event, self::userId];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, User::id, self::userId);
    }
}