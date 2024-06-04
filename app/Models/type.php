<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class type extends Model
{
    use HasFactory;

    protected $table = 'types';

    protected $fillable = [
        'num',
        'name'

    ];

    protected $primaryKey = 'id';

    public function allMedia(): HasMany
    {
        return $this->hasMany(media::class, 'type_id');
    }
}