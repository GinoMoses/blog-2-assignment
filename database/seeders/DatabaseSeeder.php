<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
        Category::create(['name' => 'React', 'slug' => 'react']);
        Category::create(['name' => 'AI & Copilot', 'slug' => 'ai-copilot']);

        Tag::create(['name' => 'laravel', 'slug' => 'laravel']);
        Tag::create(['name' => 'php', 'slug' => 'php']);
        Tag::create(['name' => 'docker', 'slug' => 'docker']);
        Tag::create(['name' => 'tutorial', 'slug' => 'tutorial']);
        Tag::create(['name' => 'react', 'slug' => 'react']);
        Tag::create(['name' => 'javascript', 'slug' => 'javascript']);
        Tag::create(['name' => 'ai', 'slug' => 'ai']);
        Tag::create(['name' => 'copilot', 'slug' => 'copilot']);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
