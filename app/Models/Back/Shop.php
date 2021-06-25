<?php

namespace App\Models\Back;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property bool|null ssl
 * @property integer|null id
 * @property string|null url
 * @property string|null name
 *
 * @method static Shop|null find(integer $id)
 * @method static Shop create(array $attributes)
 * @method static Collection all(array $columns)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class Shop extends ModelBack
{
    public const id = 'id';

    public const url = 'url';

    public const ssl = 'ssl';

    public const name = 'name';

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $table = 'shops';

    /** @var string */
    protected $primaryKey = self::id;

    /** @var string[] */
    protected $fillable = [
        self::url,
        self::ssl, self::name,
    ];
}