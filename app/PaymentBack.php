<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * @property integer PID
 * @property string|null Name
 * @property string|null description
 * @property integer|null Enabled
 * @property integer|null calculate_tax
 * @property integer|null sort_order
 * @property string|null email_comments_text
 * @property integer|null module_id
 * @method static PaymentBack|null find(integer $id)
 * @method static Collection all($columns = ['*'])
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static PaymentBack create($attributes)
 */
class PaymentBack extends Model
{
    /** @var string[] */
    protected $fillable = [
        'Name', 'description', 'Enabled',
        'calculate_tax', 'sort_order',
        'email_comments_text', 'module_id'
    ];

    /** @var array */
    protected $attributes = [
        'Name' => null,
        'description' => null,
        'Enabled' => null,
        'calculate_tax' => null,
        'sort_order' => 0,
        'email_comments_text' => '',
        'module_id' => null,
    ];

    /** @var bool */
    public $timestamps = false;

    /** @var string */
    protected $connection = 'mysql_back';

    /** @var string */
    protected $table = 'SS_payment_types';

    /** @var string */
    protected $primaryKey = 'PID';
}
