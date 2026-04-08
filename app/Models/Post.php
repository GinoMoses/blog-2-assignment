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

    public function getReadingTimeLabelAttribute(): string
    {
        $minutes = $this->reading_time;

        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;
            if ($remainingMinutes === 0) {
                return "{$hours} ".$this->pluralizeHours($hours).' czytania';
            }

            return "{$hours}h {$remainingMinutes} min czytania";
        }

        return "{$minutes} min czytania";
    }

    private function pluralizeHours(int $count): string
    {
        $lastDigit = $count % 10;
        $lastTwoDigits = $count % 100;

        if ($lastTwoDigits >= 12 && $lastTwoDigits <= 14) {
            return 'godzin';
        }

        return match ($lastDigit) {
            1 => 'godzina',
            2, 3, 4 => 'godziny',
            default => 'godzin',
        };
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
