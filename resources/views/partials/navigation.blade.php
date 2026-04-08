    <!-- Navigation -->
    <nav class="sticky top-0 z-40 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md border-b border-gray-200 dark:border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white text-lg font-bold shadow-sm">
                        📝
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">Blog</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button id="dark-mode-toggle" class="p-2 rounded-xl text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg id="sun-icon" class="w-5 h-5 hidden dark:block transition-all duration-300 scale-0 opacity-0 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg id="moon-icon" class="w-5 h-5 block dark:hidden transition-all duration-300 scale-100 opacity-100 rotate-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>
                    <a href="{{ route('posts.index') }}" class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition">
                        Posty
                    </a>
                    <a href="{{ route('posts.create') }}" class="px-4 py-2 text-sm font-medium bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl hover:bg-gray-700 dark:hover:bg-gray-100 transition">
                        + Nowy
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <script>
        const toggle = document.getElementById('dark-mode-toggle');
        const sunIcon = document.getElementById('sun-icon');
        const moonIcon = document.getElementById('moon-icon');
        
        if (toggle) {
            toggle.addEventListener('click', () => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', isDark);
                
                if (isDark) {
                    sunIcon.classList.remove('scale-0', 'opacity-0', 'rotate-90');
                    sunIcon.classList.add('scale-100', 'opacity-100', 'rotate-0');
                    moonIcon.classList.remove('scale-100', 'opacity-100', 'rotate-0');
                    moonIcon.classList.add('scale-0', 'opacity-0', 'rotate-90');
                } else {
                    moonIcon.classList.remove('scale-0', 'opacity-0', 'rotate-90');
                    moonIcon.classList.add('scale-100', 'opacity-100', 'rotate-0');
                    sunIcon.classList.remove('scale-100', 'opacity-100', 'rotate-0');
                    sunIcon.classList.add('scale-0', 'opacity-0', 'rotate-90');
                }
            });
        }
    </script>
