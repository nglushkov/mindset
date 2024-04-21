<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DateTimeInterface;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content'];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d.m.Y H:i:s');
    }
}
