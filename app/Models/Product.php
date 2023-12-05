<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'report_type',
        'user_id',
        'file',
        'path'

    ];

     // Define the relationship with the Field model
     public function field()
     {
         return $this->belongsTo(Field::class, 'user_id', 'department_id');
     }
}
