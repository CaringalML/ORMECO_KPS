<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
    ];

     // Define the relationship with the Product model
     public function products()
     {
         return $this->hasMany(Product::class, 'user_id', 'department_id');
     }
}
