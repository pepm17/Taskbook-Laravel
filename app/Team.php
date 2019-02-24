<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table = 'teams';

    protected $fillable = ['name', 'description', 'creator'];

    public function creator(){
        return $this->belongsTo('App\User');
    }

    public function activities(){
        return $this->hasMany('App\Activity');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_team');
    }
}
