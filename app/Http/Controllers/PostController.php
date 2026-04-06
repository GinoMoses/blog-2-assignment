<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $posts = $query->latest()->paginate(9)->withQueryString();
        $categories = Category::all();

        return view('posts.index', [
            'posts' => $posts,
            'categories' => $categories,
        ]);
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        return view('posts.show', [
            'post' => $post,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.create', [
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug'],
            'lead' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['nullable', 'array'],
            'tags' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $post = new Post;

        $post->title = $parameters['title'];
        $post->slug = $parameters['slug'];
        $post->lead = $parameters['lead'] ?? null;
        $post->author = $parameters['author'];
        $post->content = $parameters['content'];

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('posts', 'public');
            $post->photo = $path;
        }

        $post->save();

        if (! empty($parameters['categories'])) {
            $post->categories()->attach($parameters['categories']);
        }

        if (! empty($parameters['tags'])) {
            $tagNames = array_map('trim', explode(',', $parameters['tags']));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                if (empty($tagName)) {
                    continue;
                }
                $slug = Str::slug($tagName);
                $tag = Tag::firstOrCreate(
                    ['slug' => $slug],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }

            if (! empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
        }

        return redirect()->route('posts.index');
    }

    public function storeComment(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'author_email' => ['required', 'email', 'max:255'],
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $post->comments()->create($validated);

        return back()->with('success', 'Komentarz został dodany!');
    }

    public function edit(string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, string $slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        $parameters = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:posts,slug,'.$post->id],
            'lead' => ['nullable', 'string'],
            'author' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'categories' => ['nullable', 'array'],
            'tags' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'max:2048'],
            'remove_photo' => ['nullable', 'string'],
        ]);

        $post->title = $parameters['title'];
        $post->slug = $parameters['slug'];
        $post->lead = $parameters['lead'] ?? null;
        $post->author = $parameters['author'];
        $post->content = $parameters['content'];

        if ($request->has('remove_photo')) {
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
                $post->photo = null;
            }
        } elseif ($request->hasFile('photo')) {
            if ($post->photo) {
                Storage::disk('public')->delete($post->photo);
            }
            $path = $request->file('photo')->store('posts', 'public');
            $post->photo = $path;
        }

        $post->save();

        $post->categories()->sync($parameters['categories'] ?? []);

        $post->tags()->detach();
        if (! empty($parameters['tags'])) {
            $tagNames = array_map('trim', explode(',', $parameters['tags']));
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                if (empty($tagName)) {
                    continue;
                }
                $tagSlug = Str::slug($tagName);
                $tag = Tag::firstOrCreate(
                    ['slug' => $tagSlug],
                    ['name' => $tagName]
                );
                $tagIds[] = $tag->id;
            }

            if (! empty($tagIds)) {
                $post->tags()->attach($tagIds);
            }
        }

        return redirect()->route('posts.show', $post->slug)->with('success', 'Post został zaktualizowany!');
    }
}
