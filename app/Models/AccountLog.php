<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conta_id', 'type', 'message'
    ];
}
