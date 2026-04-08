<?php

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('shows reading progress bar on post page', function () {
    $post = Post::factory()->create();

    $this->get(route('posts.show', $post->slug))
        ->assertOk()
        ->assertSee('id="reading-progress"', false);
});

it('reading progress bar is hidden at top of page', function () {
    $post = Post::factory()->create();

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertOk();
    $content = $response->getContent();

    expect($content)->toContain('opacity-0');
});

it('reading progress bar has correct structure', function () {
    $post = Post::factory()->create();

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertOk();
    $content = $response->getContent();

    expect($content)
        ->toContain('id="reading-progress"')
        ->toContain('fixed top-0')
        ->toContain('h-1')
        ->toContain('bg-gradient-to-r from-indigo-500');
});
