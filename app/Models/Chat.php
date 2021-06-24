<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property User|null user
 * @property int|null id
 * @property string|null chat_id
 * @property Collection|null data
 * @property int|null user_id
 *
 * @method static Chat|null find(int $id)
 * @method static Chat create(array $attributes)
 * @method static Collection all(array $columns)
 * @method static Builder where($column, $operator, $value, $boolean)
 */
class Chat extends Model
{
    public const id = 'id';

    public const data = 'data';

    public const chatId = 'chat_id';

    public const userId = 'user_id';

    /** @var string */
    protected $table = 'chats';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [self::data, self::chatId, self::userId];

    /**
     *
     */
    public static function boot(): void
    {
        parent::boot();

        $up = function ($model) {
            $data = json_decode($model->data, true);

            if (false === is_array($data)) {
                $data = [];
            }

            $model->data = collect($data);
        };

        static::saved($up);
        static::retrieved($up);
        static::saving(function (Chat $chat) {
            if (false === is_a($chat->data, Collection::class)) {
                $chat->data = collect();
            }

            $chat->data = json_encode($chat->data->all());
        });
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, User::id, self::userId);
    }
}