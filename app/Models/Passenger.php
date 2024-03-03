<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{

    
        use HasFactory;
    
        protected $guarded = ['id', 'created_at', 'updated_at'];
    
        public function flights()
        {
            return $this->belongsToMany(Flight::class);
        }
    
}
