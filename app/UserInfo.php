<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    protected $table = 'user_info';

    public function User(){
        return $this->belongsTo('App\User');
    }
}
