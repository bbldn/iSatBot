<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

/**
 * @property integer id
 * @property string chat_id
 * @property string data
 * @property integer user_id
 * @property User|null user
 * @method static Chat|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static Chat create($attributes)
 */
class Chat extends Model
{
    /** @var string $table */
    protected $table = 'chats';

    /** @var array $fillable */
    protected $fillable = [
        'chat_id', 'data', 'user_id',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
