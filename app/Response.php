<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $table = 'responses';

    protected $fillable = ['content', 'creator', '_dad'];

    public function activity(){
        return $this->belongsTo('App\Activity');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
