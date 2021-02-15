<?php

namespace App;

use Illuminate\Database\Eloquent\Collection as CollectionEloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;

/**
 * @property User|null user
 * @property integer|null id
 * @property string|null chat_id
 * @property Collection|null data
 * @property integer|null user_id
 * @method static Chat|null find(integer $id)
 * @method static Chat create(array $attributes)
 * @method static CollectionEloquent all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
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
    protected $fillable = [
        self::data,
        self::chatId,
        self::userId,
    ];

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
        static::saving(function (Chat $model) {
            if (false === is_a($model->data, Collection::class)) {
                $model->data = collect();
            }

            $model->data = json_encode($model->data->all());
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
