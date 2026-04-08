<x-layout>
    @if(session('success'))
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
            <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Post Header -->
        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden mb-8">
            <!-- Featured Image -->
            @if($post->photo)
                <div class="h-96">
                    <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @else
                <div class="h-96 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                    <span class="text-9xl">{{ ['📝', '🚀', '💻', '⚡', '🎯', '🔥', '✨', '🌟', '💡', '🎨'][strlen($post->title) % 10] }}</span>
                </div>
            @endif

            <!-- Post Content -->
            <div class="p-8">
                <!-- Meta Info -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center text-lg font-semibold text-gray-700 dark:text-gray-200 flex-shrink-0">
                            {{ strtoupper(substr($post->author, 0, 2)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900 dark:text-white">{{ $post->author }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $post->created_at->format('d F Y') }} · {{ $post->reading_time }} min czytania · {{ $post->view_count_label }}</p>
                        </div>
                    </div>
                    <div class="ml-auto flex gap-2">
                        <a href="{{ route('posts.edit', $post->slug) }}" class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-xs font-semibold rounded-full hover:bg-indigo-200 dark:hover:bg-indigo-800 transition">
                            Edytuj
                        </a>
                        <button type="button" onclick="showDeleteModal('{{ route('posts.destroy', $post->slug) }}')" class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 text-xs font-semibold rounded-full hover:bg-red-200 dark:hover:bg-red-800 transition">
                            Usuń
                        </button>
                        <form method="POST" action="{{ route('posts.update', $post->slug) }}" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="title" value="{{ $post->title }}">
                            <input type="hidden" name="slug" value="{{ $post->slug }}">
                            <input type="hidden" name="author" value="{{ $post->author }}">
                            <input type="hidden" name="lead" value="{{ $post->lead }}">
                            <input type="hidden" name="content" value="{{ $post->content }}">
                            <input type="hidden" name="is_published" value="{{ $post->is_published ? '0' : '1' }}">
                            @foreach($post->categories as $category)
                                <input type="hidden" name="categories[]" value="{{ $category->id }}">
                            @endforeach
                            <input type="hidden" name="tags" value="{{ $post->tags->pluck('name')->implode(', ') }}">
                            <button type="submit" class="px-3 py-1 {{ $post->is_published ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 hover:bg-yellow-200 dark:hover:bg-yellow-800' : 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 hover:bg-green-200 dark:hover:bg-green-800' }} text-xs font-semibold rounded-full transition">
                                {{ $post->is_published ? 'Cofnij' : 'Publikuj' }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    {{ $post->title }}
                </h1>

                @if ($post->lead)
                    <!-- Lead -->
                    <p class="text-xl text-gray-600 dark:text-gray-400 mb-8 leading-relaxed">
                        {{ $post->lead }}
                    </p>
                @endif

                <!-- Content -->
                <div class="post-content prose prose-lg max-w-none dark:text-gray-300">
                    <p class="text-gray-700 dark:text-gray-300 mb-4 leading-relaxed whitespace-pre-line">
                        {!! $post->content !!}
                    </p>
                </div>

                <!-- Tags -->
                <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
                    @if($post->is_published)
                        <span class="inline-block px-3 py-1 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 text-xs font-semibold rounded-full mb-3">
                            Opublikowany
                        </span>
                    @else
                        <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300 text-xs font-semibold rounded-full mb-3">
                            Szkic
                        </span>
                    @endif
                    
                    @if($post->tags->count() > 0 || $post->categories->count() > 0)
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->categories as $category)
                                <span class="px-3 py-1 bg-indigo-100 dark:bg-indigo-900 text-indigo-800 dark:text-indigo-200 text-sm rounded-full">#{{ $category->name }}</span>
                            @endforeach
                            @foreach($post->tags as $tag)
                                <span class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm rounded-full">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-400 dark:text-gray-500">Brak kategorii ani tagów.</p>
                    @endif
                </div>

                <!-- Social Share -->
                <div class="mt-6 flex items-center gap-4">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Udostępnij:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" target="_blank" class="text-sky-500 hover:text-sky-600 dark:text-sky-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="text-blue-600 hover:text-blue-700 dark:text-blue-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <section class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Komentarze (<span id="comment-count">{{ $post->comments->count() }}</span>)
            </h2>

            <!-- Comment Form -->
            <div class="mb-8 pb-8 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Dodaj komentarz</h3>
                <form action="{{ route('posts.comments.store', $post->slug) }}" method="POST" class="space-y-4">
                    @csrf
                    <!-- Name -->
                    <div>
                        <label for="author_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Twoje imię *
                        </label>
                        <input type="text" id="author_name" name="author_name" value="{{ old('author_name') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('author_name') border-red-500 @enderror"
                            placeholder="Jan Kowalski">
                        @error('author_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="author_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email *
                        </label>
                        <input type="email" id="author_email" name="author_email" value="{{ old('author_email') }}" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('author_email') border-red-500 @enderror"
                            placeholder="jan@example.com">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Email nie będzie publikowany</p>
                        @error('author_email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Komentarz *
                        </label>
                        <textarea id="content" name="content" required rows="5"
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent resize-none @error('content') border-red-500 @enderror"
                            placeholder="Podziel się swoimi przemyśleniami...">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 transition-colors">
                            Opublikuj komentarz
                        </button>
                        <p class="text-sm text-gray-500 dark:text-gray-400">* Pola wymagane</p>
                    </div>
                </form>
            </div>

            <!-- Comments List -->
            <div class="space-y-6" id="comments-list">
                @forelse($post->comments->sortByDesc('created_at') as $comment)
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-400 to-purple-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($comment->author_name, 0, 2)) }}
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $comment->author_name }}</h4>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    {{ $comment->content }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="w-12 h-12 mx-auto mb-3 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="text-2xl">💬</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Brak komentarzy. Bądź pierwszy!</p>
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Related Posts -->
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ostatnie publikacje</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @php
                    $relatedPosts = \App\Models\Post::with(['categories', 'tags'])->where('id', '!=', $post->id)
                        ->where('is_published', true)
                        ->latest()
                        ->limit(3)
                        ->get();
                @endphp
                @forelse($relatedPosts as $related)
                    <a href="{{ route('posts.show', $related->slug) }}" class="group">
                        <article class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                            @if($related->photo)
                                <div class="h-32">
                                    <img src="{{ asset('storage/' . $related->photo) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="h-32 bg-gradient-to-br from-green-500 to-teal-600 flex items-center justify-center">
                                    <span class="text-5xl">{{ ['📝', '🚀', '💻', '⚡', '🎯', '🔥', '✨', '🌟', '💡', '🎨'][strlen($related->title) % 10] }}</span>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 line-clamp-2 mb-2">
                                    {{ $related->title }}
                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $related->reading_time }} min · {{ $related->view_count_label }}</p>
                            </div>
                        </article>
                    </a>
                @empty
                    <div class="col-span-3 text-center py-8">
                        <div class="w-12 h-12 mx-auto mb-3 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <span class="text-2xl">📄</span>
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Brak publikacji.</p>
                    </div>
                @endforelse
            </div>
        </section>

    </main>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-md w-full mx-4 overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto mb-4 bg-red-100 dark:bg-red-900 rounded-full">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white text-center mb-2">Usuń post</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6">Czy na pewno chcesz usunąć ten post? Tej operacji nie można cofnąć.</p>
                <div class="flex gap-3">
                    <button onclick="hideDeleteModal()" class="flex-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition font-medium">
                        Anuluj
                    </button>
                    <form id="deleteForm" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Usuń
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteModal(action) {
            document.getElementById('deleteForm').action = action;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideDeleteModal();
            }
        });
    </script>

</x-layout>
