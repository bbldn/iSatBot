<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

/**
 * @property integer id
 * @property string chat_id
 * @property \Illuminate\Support\Collection|null data
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

    /** @var string[] $fillable */
    protected $fillable = [
        'chat_id', 'data', 'user_id',
    ];

    /**
     *
     */
    public static function boot()
    {
        parent::boot();

        $up = function ($model) {
            $data = json_decode($model->data, true);

            if (false === is_array($data)) {
                $data = [];
            }

            $model->data = collect($data);
        };

        static::retrieved($up);
        static::saved($up);

        static::saving(function ($model) {
            if (false === is_a($model->data, \Illuminate\Support\Collection::class)) {
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
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
