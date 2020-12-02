<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property integer id
 * @property string event
 * @property integer user_id
 * @property User|null user
 * @method static Listener|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Listener create($attributes)
 */
class Listener extends Model
{
    /** @var string */
    protected $table = 'listeners';

    /** @var string[] */
    protected $fillable = [
        'event', 'user_id',
    ];

    /** @var bool */
    public $timestamps = false;

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
