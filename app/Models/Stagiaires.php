<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stagiaires extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstName',
        'lastName',
        'age',
        'created_at',
        'updated_at'
    ];
}
