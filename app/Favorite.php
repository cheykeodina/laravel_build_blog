<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordActivity;
    // prevent mass assignment error
    protected $guarded = [];

        public function favorited()
    {
        return $this->morphTo();
    }
}
