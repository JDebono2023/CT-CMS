<?php

namespace App\Models;

use App\Models\category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class media extends Model
{
    use HasFactory;

    protected $table = 'media';

    protected $fillable = [
        'file_name',
        'user_file_name',
        'media',
        'thumb',
        'type_id'

    ];

    protected $primaryKey = 'id';

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(category::class, 'categorymedia', 'media_id', 'category_id')->withPivot('cat_type');
    }

    public function types(): BelongsTo
    {
        return $this->belongsTo(type::class, 'type_id');
    }
}
