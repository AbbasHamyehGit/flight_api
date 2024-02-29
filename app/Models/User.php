<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // Define fillable attributes
    protected $fillable = ['name', 'email'];
}
