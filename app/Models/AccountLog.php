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

    /**
     * Get the account
     */
    public function conta()
    {
        return $this->belongsTo('App\Models\Conta');
    }
}
