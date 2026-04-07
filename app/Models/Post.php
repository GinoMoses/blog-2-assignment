<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'author',
        'photo',
        'is_published',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
    ];

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getReadingTimeAttribute(): int
    {
        $words = Str::wordCount(strip_tags($this->content));

        return (int) ceil($words / 200);
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getViewCountLabelAttribute(): string
    {
        $count = $this->view_count;
        $lastDigit = abs($count) % 10;
        $lastTwoDigits = abs($count) % 100;

        if ($lastTwoDigits >= 12 && $lastTwoDigits <= 14) {
            return "{$count} wyświetleń";
        }

        if ($lastDigit === 1) {
            return "{$count} wyświetlenie";
        }

        if ($lastDigit >= 2 && $lastDigit <= 4) {
            return "{$count} wyświetlenia";
        }

        return "{$count} wyświetleń";
    }
}
