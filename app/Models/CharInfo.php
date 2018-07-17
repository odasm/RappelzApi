<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharInfo extends Model
{
    protected $table = 'Character';
    protected $connection = 'telecasterdb';
    public $timestamps = false;
}
