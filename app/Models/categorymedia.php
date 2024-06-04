<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class categorymedia extends Model
{
    use HasFactory;

    protected $table = 'categorymedia';

    protected $fillable = [
        'category_id',
        'media_id',
        'cat_type'

    ];

    protected $primaryKey = 'id';
}