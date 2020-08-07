<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{


    public function manager(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
