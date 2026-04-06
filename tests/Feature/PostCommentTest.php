<?php

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Laravel\post;

uses(RefreshDatabase::class);

it('can submit a comment on a post', function () {
    $post = Post::factory()->create();

    post(route('posts.comments.store', $post->slug), [
        'author_name' => 'Jan Kowalski',
        'author_email' => 'jan@example.com',
        'content' => 'To jest świetny artykuł!',
    ])
        ->assertRedirectBack()
        ->assertSessionHas('success');

    expect($post->comments)->toHaveCount(1);
    expect($post->comments->first()->author_name)->toBe('Jan Kowalski');
});

it('validates required fields when submitting comment', function () {
    $post = Post::factory()->create();

    post(route('posts.comments.store', $post->slug), [])
        ->assertSessionHasErrors(['author_name', 'author_email', 'content']);
});

it('validates email format for comment', function () {
    $post = Post::factory()->create();

    post(route('posts.comments.store', $post->slug), [
        'author_name' => 'Jan Kowalski',
        'author_email' => 'not-an-email',
        'content' => 'To jest komentarz',
    ])
        ->assertSessionHasErrors(['author_email']);
});

it('can display comments on post show page', function () {
    $post = Post::factory()->create();

    $comment = Comment::create([
        'post_id' => $post->id,
        'author_name' => 'Anna Nowak',
        'author_email' => 'anna@example.com',
        'content' => 'Bardzo pomocny artykuł!',
    ]);

    expect($post->comments)->toHaveCount(1);
    expect($post->comments->first()->author_name)->toBe('Anna Nowak');
});

it('cascades comment deletion when post is deleted', function () {
    $post = Post::factory()->create();

    Comment::create([
        'post_id' => $post->id,
        'author_name' => 'Test User',
        'author_email' => 'test@example.com',
        'content' => 'Test comment',
    ]);

    expect($post->comments)->toHaveCount(1);

    $post->delete();

    expect(Comment::count())->toBe(0);
});
