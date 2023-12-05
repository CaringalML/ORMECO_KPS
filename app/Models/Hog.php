<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'notices',
        'department_id'
    ];
}
