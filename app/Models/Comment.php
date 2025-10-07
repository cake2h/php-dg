<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'is_active',
        'name',
        'email',
        'post_id',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}


