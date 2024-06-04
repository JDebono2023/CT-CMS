<?php

namespace App\Models;

use App\Models\media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image',
        'visible',
        'file_name'

    ];

    protected $primaryKey = 'id';


    public function media(): BelongsToMany
    {
        return $this->belongsToMany(media::class, 'categorymedia', 'media_id', 'category_id')->withPivot('cat_type');
    }
}
