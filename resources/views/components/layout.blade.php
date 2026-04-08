<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Lista Postów</title>

    <link href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.css" rel="stylesheet">

    <style>
        pre[class*="language-"],
        code[class*="language-"] {
            font-size: 0.875rem !important;
            line-height: 1.6 !important;
        }
        pre[class*="language-"] {
            background: #2d2d2d !important;
            border-radius: 0.5rem !important;
            padding: 1rem !important;
            margin: 1rem 0 !important;
            overflow-x: auto !important;
            border: 1px solid #404040;
        }
        pre.line-numbers {
            position: relative !important;
            padding-left: 3.5rem !important;
            counter-reset: linenumber !important;
        }
        pre.line-numbers > code {
            position: relative !important;
            white-space: pre !important;
        }
        .line-numbers-rows {
            border-right: 1px solid #404040 !important;
        }
        :not(.dark) pre[class*="language-"] {
            background: #1e1e1e !important;
        }
        :not(.dark) .line-numbers-rows {
            border-right-color: #404040 !important;
        }
        
        /* Code blocks in post content */
        .post-content pre {
            background: #2d2d2d !important;
            border-radius: 0.5rem;
            padding: 1rem;
            margin: 1rem 0;
            overflow-x: auto;
            border: 1px solid #404040;
        }
        .post-content code {
            background: #f1f5f9;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
            color: #e11d48;
        }
        :where(.dark) .post-content code,
        .dark .post-content code {
            background: #334155 !important;
            color: #fb7185 !important;
        }
        :where(.dark) .post-content pre,
        .dark .post-content pre {
            background: #1e1e1e !important;
            border-color: #404040 !important;
        }
        :where(.dark) .post-content pre code,
        .dark .post-content pre code {
            background: transparent !important;
            color: inherit !important;
        }
    </style>

    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css'])
</head>

<body class="min-h-screen flex flex-col bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    @include('partials.navigation')
    @include('partials.reading-progress')
    <div class="flex-1">
    {{ $slot }}
    </div>
    @include('partials.footer')

    <button id="back-to-top" class="fixed bottom-6 right-6 p-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-full shadow-lg opacity-0 invisible transition-all duration-300 hover:bg-gray-700 dark:hover:bg-gray-200 z-50">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    <script>
        const btn = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                btn.classList.remove('opacity-0', 'invisible');
                btn.classList.add('opacity-100', 'visible');
            } else {
                btn.classList.add('opacity-0', 'invisible');
                btn.classList.remove('opacity-100', 'visible');
            }
        });
        
        btn?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @vite(['resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/prism.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-php.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-javascript.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-css.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-bash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-sql.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/components/prism-json.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/prismjs@1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Prism !== 'undefined') {
                Prism.highlightAll();
            }
        });
    </script>
</body>

</html>
