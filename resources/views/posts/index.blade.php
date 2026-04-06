<x-layout>
    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Posty</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Artykuły i tutoriale</p>
        </div>

        <!-- Filters/Search Bar -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 mb-8">
            <form method="GET" action="{{ route('posts.index') }}" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Szukaj postów..."
                        class="w-full pl-11 pr-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>
                <select name="category" class="px-4 py-2.5 text-sm border border-gray-200 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-indigo-500 min-w-[160px]">
                    <option value="">Wszystkie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition">
                    Szukaj
                </button>
                @if(request('search') || request('category'))
                    <a href="{{ route('posts.index') }}" class="px-4 py-2.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition flex items-center">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        <!-- Posts Grid -->
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

            @forelse ($posts as $post)
                <article class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-700 hover:shadow-md transition-all duration-200">
                    <!-- Image -->
                    <div class="relative h-44 rounded-t-2xl overflow-hidden">
                        @if($post->photo)
                            <img src="{{ asset('storage/' . $post->photo) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-indigo-500/20 to-purple-600/20 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                                <span class="text-5xl opacity-60">{{ ['📝', '🚀', '💻', '⚡', '🎯'][array_rand(['📝', '🚀', '💻', '⚡', '🎯'])] }}</span>
                            </div>
                        @endif
                        @if(!$post->is_published)
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 bg-gray-900/80 dark:bg-gray-800/80 text-white text-xs font-medium rounded-lg backdrop-blur-sm">Szkic</span>
                            </div>
                        @else
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 bg-green-600/80 text-white text-xs font-medium rounded-lg backdrop-blur-sm">Opublikowany</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        @if($post->categories->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-3">
                                @foreach($post->categories->take(2) as $category)
                                    <span class="px-2.5 py-0.5 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-medium rounded-lg">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">
                            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-4">
                            {{ $post->lead ?? Str::limit(strip_tags($post->content), 100) }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500 pt-3 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 bg-gray-100 dark:bg-gray-700 rounded-lg text-xs font-medium flex items-center justify-center text-gray-600 dark:text-gray-300">
                                    {{ strtoupper(substr($post->author, 0, 1)) }}
                                </div>
                                <span>{{ $post->author }}</span>
                            </div>
                            <span>{{ $post->created_at->format('d M') }}</span>
                        </div>
                    </div>
                </article>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center">
                        <span class="text-3xl">📭</span>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Brak postów</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nie ma jeszcze żadnych postów.</p>
                    <a href="{{ route('posts.create') }}" class="inline-block px-4 py-2 text-sm font-medium bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition">
                        Dodaj pierwszy post
                    </a>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="mt-8">
                {{ $posts->withQueryString()->links() }}
            </div>
        @endif
    </main>
</x-layout>
