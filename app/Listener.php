<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property User|null user
 * @property integer|null id
 * @property string|null event
 * @property integer|null user_id
 * @method static Listener create($attributes)
 * @method static Listener|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Listener extends Model
{
    public const id = 'id';

    public const event = 'event';

    public const userId = 'user_id';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string */
    protected $table = 'listeners';

    /** @var string[] */
    protected $fillable = [
        self::event,
        self::userId,
    ];

    /** @var bool */
    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, User::id, self::userId);
    }
}
