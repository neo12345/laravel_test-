<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserConfirms extends Model
{

    protected $fillable = array(
        'user_id',
        'action',
        'token',
    );

}
