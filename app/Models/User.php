<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @property int id
 * @property string name
 * @property string login
 * @property string password
 * @property Chat[]|Collection chats
 *
 * @method static User|null find(int $id)
 * @method static Collection all(array $columns)
 * @method static User create(array $attributes)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    public const id = 'id';

    public const name = 'name';

    public const login = 'login';

    public const password = 'password';

    /** @var string[] */
    protected $fillable = [self::name, self::password];

    public ?Chat $chat = null;

    /**
     * @return HasMany
     */
    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, Chat::userId, Chat::id);
    }
}