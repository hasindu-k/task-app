<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'time',
        'status',
        'user_id',
    ];

    protected $casts = [
        'time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
