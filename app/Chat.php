<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

/**
 * @property integer id
 * @property string chat_id
 * @property array|null data
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
     *
     */
    public static function boot()
    {
        parent::boot();
        static::retrieved(function ($model){
            $data = json_decode($model->data, true);

            if (false === is_array($data)) {
                $data = [];
            }

            $model->data = $data;
        });

        static::saving(function ($model){
            if (false === is_array($model->data)) {
                $model->data = [];
            }

            $model->data = json_encode($model->data);
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
