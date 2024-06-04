<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MediaRequests extends Model
{
    use HasFactory;

    protected $table = 'media_requests';

    protected $fillable = [
        'order_number',
        'file_name',
        'user_file_name',
        'store_id',
        'store_name',
        'confirm',
        'edits',
        'edit_text',
        'starts_at',
        'ends_at',
        'no_end',
        'device',
        'category'

    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $prefix = 'CT-0';
            $id = Auth::user()->id + 102;
            $rand = rand(100, 990);

            $model->order_number = $prefix .  $id . '-' . $rand;
        });
    }
}
