<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'file_name',
        'user_file_name',
        'teams_id'

    ];

    protected $primaryKey = 'id';

    public function teams(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
