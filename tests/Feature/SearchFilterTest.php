<?php

use App\Models\Category;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can filter posts by search term', function () {
    Post::factory()->create(['title' => 'Laravel Tutorial']);
    Post::factory()->create(['title' => 'React Guide']);

    $response = $this->get('/posts?search=Laravel');

    $response->assertSee('Laravel Tutorial');
});

it('can filter posts by category', function () {
    $category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $post = Post::factory()->create(['title' => 'Laravel Post']);
    $post->categories()->attach($category);

    Post::factory()->create(['title' => 'React Post']);

    $response = $this->get('/posts?category=laravel');

    $response->assertSee('Laravel Post');
});

it('can combine search and category filter', function () {
    $category = Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $post = Post::factory()->create(['title' => 'Laravel Advanced']);
    $post->categories()->attach($category);

    Post::factory()->create(['title' => 'Laravel Basic']);

    $response = $this->get('/posts?search=Advanced&category=laravel');

    $response->assertSee('Laravel Advanced');
});

it('can display category badges on posts', function () {
    $category = Category::create(['name' => 'PHP', 'slug' => 'php']);
    $post = Post::factory()->create(['title' => 'PHP Tutorial']);
    $post->categories()->attach($category);

    $response = $this->get('/posts');

    $response->assertSee('PHP');
});

it('shows clear filter button when filtering', function () {
    $response = $this->get('/posts?search=test');

    $response->assertSee('Wyczyść');
});

it('category dropdown shows all categories', function () {
    Category::create(['name' => 'Laravel', 'slug' => 'laravel']);
    Category::create(['name' => 'React', 'slug' => 'react']);

    $response = $this->get('/posts');

    $response->assertSee('Laravel');
    $response->assertSee('React');
});
