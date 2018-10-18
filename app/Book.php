<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['user_id', 'title', 'decription', 'image'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
