<?php

namespace App\Models\Synchronizer;

use Illuminate\Database\Eloquent\Model;

class SynchronizerModel extends Model
{
    /** @var string */
    protected $connection = 'mysql_synchronizer';
}