<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DateTimeInterface;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'is_title_by_ai', 'is_content_by_ai'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d.m.Y');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
