    <!-- Footer -->
    <footer class="border-t border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-gray-500 dark:text-gray-400">
                <p>© 2026 ZSTiO. Projekt edukacyjny - Podstawy Laravel</p>
                <div class="flex items-center gap-5">
                    <a href="{{ route('posts.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Posty</a>
                    <a href="{{ route('posts.create') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">Utwórz post</a>
                </div>
            </div>
        </div>
    </footer>
