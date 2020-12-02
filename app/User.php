<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property integer id
 * @property string login
 * @property string name
 * @property string password
 * @property Collection chats
 * @method static User|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static User create($attributes)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'password',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    /** @var Chat|null */
    public $chat = null;

    /**
     * @return HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'user_id', 'id');
    }
}
