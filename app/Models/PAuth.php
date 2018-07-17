<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PAuth extends Model
{
    protected $table = 'Account';
    protected $primaryKey = 'account_id';
    protected $guarded = [];
    public $timestamps = false;
}
