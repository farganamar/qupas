<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    //
    protected $table = 'histories';

    protected $fillable = [
        'user_id', 'nominal', 'message'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
