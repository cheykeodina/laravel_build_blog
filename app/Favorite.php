<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    // prevent mass assignment error
    protected $guarded = [];
}
