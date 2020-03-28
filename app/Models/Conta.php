<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Event;

class Conta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conta', 'saldo'
    ];


    public static function boot() {
        parent::boot();

	    static::created(function($conta) {
	        Event::dispatch('conta.created', $conta);
        });

	    static::updated(function($conta) {
            Event::dispatch('conta.updated', $conta);
	    });
    }
    
    /**
     * Get the logs of a account
     */
    public function logs()
    {
        return $this->hasMany('App\Models\AccountLogs');
    }
}
