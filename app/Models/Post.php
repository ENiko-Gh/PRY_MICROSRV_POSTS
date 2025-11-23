<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model  // ✅ PascalCase
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author',  // ✅ Cambiado de 'user_id' a 'author' para coincidir con tu controlador
    ];
}
