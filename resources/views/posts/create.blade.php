<x-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.css">
    <script src="https://cdn.jsdelivr.net/npm/trix@2.0.8/dist/trix.umd.min.js"></script>
    
    <div class="max-w-3xl mx-auto my-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Nowy post</h1>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" id="post-form" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
            @csrf

            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 p-4 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tytul</label>
                <input type="text" name="title" id="title-input" value="{{ old('title') }}" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Przyjazny adres (slug)</label>
                <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Autor</label>
                <input type="text" name="author" value="{{ old('author') }}" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Kategorie</label>
                <div class="flex flex-wrap gap-3">
                    @foreach($categories as $category)
                        <label class="inline-flex items-center bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-full px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                class="rounded border-gray-300 dark:border-gray-500 text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500 mr-2">
                            <span class="text-sm text-gray-700 dark:text-gray-300">{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tagi</label>
                <input type="text" name="tags" value="{{ old('tags') }}" placeholder="np. laravel, php, tutorial"
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Istniejące tagi: {{ $tags->pluck('name')->implode(', ') ?: 'brak' }}</p>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zajawka</label>
                <textarea name="lead" rows="3" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">{{ old('lead') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Treść</label>
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <div class="trix-editor-wrapper">
                    <div class="editor-toolbar">
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="bold" title="Pogrubienie">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="italic" title="Kursywa">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 4h4m-2 0v16m-4 0h8"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="strike" title="Przekreślenie">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M3 12h18"/></svg>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="heading1" title="Nagłówek 1">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="quote" title="Cytat">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="bulletList" title="Lista punktowana">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="numberList" title="Lista numerowana">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M4 8h.01M4 12h.01M4 16h.01"/></svg>
                        </button>
                        <div class="toolbar-divider"></div>
                        <button type="button" class="editor-toolbar-btn" data-trix-attribute="link" title="Link">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-action="undo" title="Cofnij">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a5 5 0 015 5v2M3 10l6 6m-6-6l6-6"/></svg>
                        </button>
                        <button type="button" class="editor-toolbar-btn" data-trix-action="redo" title="Ponów">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a5 5 0 00-5 5v2m15-7l-6 6m6-6l-6-6"/></svg>
                        </button>
                    </div>
                    <trix-editor for="content" class="trix-content"></trix-editor>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Status</label>
                <div class="flex items-center">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" name="is_published" id="is_published" value="1" 
                        {{ old('is_published') ? 'checked' : '' }}
                        class="rounded border-gray-300 dark:border-gray-500 text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500 h-5 w-5">
                    <label for="is_published" class="ml-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer">Opublikuj od razu</label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Zdjęcie</label>
                <div id="drop-zone" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-lg hover:border-indigo-400 transition cursor-pointer bg-gray-50 dark:bg-gray-700">
                    <div id="upload-content" class="space-y-2 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <label for="photo" class="relative cursor-pointer bg-white dark:bg-gray-600 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Kliknij aby wybrać</span>
                                <input id="photo" name="photo" type="file" accept="image/*" class="sr-only" />
                            </label>
                            <p class="pl-1">lub przeciągnij i upuść</p>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF do 2MB</p>
                    </div>
                    <div id="file-selected" class="hidden flex items-center gap-3">
                        <svg class="h-10 w-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p id="file-name" class="text-sm font-medium text-gray-700 dark:text-gray-300"></p>
                            <p id="file-size" class="text-xs text-gray-500 dark:text-gray-400"></p>
                        </div>
                        <button type="button" id="remove-file" class="ml-4 text-red-500 hover:text-red-700 dark:text-red-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div id="preview-container" class="mt-4 hidden">
                    <img id="preview-image" class="max-h-48 rounded-lg shadow" />
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-indigo-700 transition">
                    Dodaj post
                </button>
                <a href="{{ route('posts.index') }}" class="px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Anuluj
                </a>
            </div>
        </form>
    </div>

    <style>
        /* Editor wrapper - matches form input style */
        .trix-editor-wrapper {
            border: 1px solid #d1d5db;
            border-radius: 0.75rem;
            overflow: hidden;
            background: white;
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            transition: all 0.2s;
        }
        .trix-editor-wrapper:focus-within {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgb(99 102 241 / 0.1);
        }
        
        /* Dark mode - using :where to match Tailwind's dark variant */
        :where(.dark) .trix-editor-wrapper,
        .dark .trix-editor-wrapper {
            border-color: #374151 !important;
            background: #111827 !important;
        }
        :where(.dark) .trix-editor-wrapper:focus-within,
        .dark .trix-editor-wrapper:focus-within {
            border-color: #6366f1 !important;
        }
        
        /* Hide default toolbar */
        trix-toolbar {
            display: none !important;
        }
        
        /* Custom toolbar styling */
        .editor-toolbar {
            display: flex;
            gap: 0.25rem;
            padding: 0.625rem;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        :where(.dark) .editor-toolbar,
        .dark .editor-toolbar {
            background: #1e293b !important;
            border-bottom-color: #334155 !important;
        }
        
        .editor-toolbar-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.25rem;
            height: 2.25rem;
            border-radius: 0.5rem;
            border: none;
            background: transparent;
            color: #64748b;
            cursor: pointer;
            transition: all 0.15s;
        }
        .editor-toolbar-btn:hover {
            background: #e2e8f0;
            color: #334155;
        }
        :where(.dark) .editor-toolbar-btn:hover,
        .dark .editor-toolbar-btn:hover {
            background: #334155 !important;
            color: #e2e8f0 !important;
        }
        .editor-toolbar-btn.active {
            background: #e0e7ff;
            color: #4f46e5;
        }
        :where(.dark) .editor-toolbar-btn.active,
        .dark .editor-toolbar-btn.active {
            background: #4338ca !important;
            color: #e0e7ff !important;
        }
        .editor-toolbar-btn svg {
            width: 1.125rem;
            height: 1.125rem;
        }
        
        .toolbar-divider {
            width: 1px;
            background: #e2e8f0;
            margin: 0 0.5rem;
        }
        :where(.dark) .toolbar-divider,
        .dark .toolbar-divider {
            background: #334155 !important;
        }
        
        /* Editor area */
        .trix-editor {
            background: white !important;
            color: #1e293b !important;
            padding: 1.25rem !important;
            font-family: inherit !important;
            font-size: 1rem !important;
            line-height: 1.75 !important;
            min-height: 250px !important;
        }
        :where(.dark) .trix-editor,
        .dark .trix-editor {
            background: #111827 !important;
            color: #f1f5f9 !important;
        }
        
        /* Placeholder */
        .trix-placeholder {
            color: #94a3b8 !important;
        }
        
        /* Content */
        .trix-content {
            color: inherit !important;
        }
        .trix-content h1 { font-size: 1.5rem; font-weight: 700; margin: 1rem 0 0.5rem; }
        .trix-content h2 { font-size: 1.25rem; font-weight: 600; margin: 0.875rem 0 0.5rem; }
        .trix-content h3 { font-size: 1.125rem; font-weight: 600; margin: 0.75rem 0 0.5rem; }
        .trix-content ul, .trix-content ol { padding-left: 1.5rem; margin: 0.5rem 0; }
        .trix-content blockquote {
            border-left: 4px solid #818cf8;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #64748b;
            font-style: italic;
        }
        :where(.dark) .trix-content blockquote,
        .dark .trix-content blockquote {
            color: #94a3b8 !important;
            border-left-color: #6366f1 !important;
        }
        .trix-content a { color: #4f46e5; text-decoration: underline; }
        .trix-content code {
            background: #f1f5f9;
            padding: 0.125rem 0.375rem;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }
        :where(.dark) .trix-content code,
        .dark .trix-content code {
            background: #334155 !important;
        }
        
        /* Focus state */
        trix-editor.trix-focused {
            outline: none !important;
        }
    </style>

    <script>
        // Apply dark mode styles using cssText with !important
        function applyTrixTheme() {
            const trixEditor = document.querySelector('trix-editor');
            if (!trixEditor) return;
            
            const isDark = document.documentElement.classList.contains('dark');
            const target = trixEditor.shadowRoot?.querySelector('.trix-content') || trixEditor;
            
            if (isDark) {
                target.style.cssText = 'background-color: #111827 !important; color: #f1f5f9 !important; border: none !important;';
            } else {
                target.style.cssText = 'background-color: white !important; color: #1e293b !important; border: none !important;';
            }
        }
        
        setTimeout(applyTrixTheme, 200);
        
        const trixEditor = document.querySelector('trix-editor');
        if (trixEditor) {
            const interval = setInterval(() => {
                applyTrixTheme();
                if (trixEditor.shadowRoot?.querySelector('.trix-content')) {
                    clearInterval(interval);
                }
            }, 100);
            
            trixEditor.addEventListener('trix-initialize', applyTrixTheme);
        }
        
        const darkObserver = new MutationObserver(() => applyTrixTheme());
        darkObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
        
        // Custom toolbar buttons
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.editor-toolbar-btn[data-trix-attribute]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const attribute = this.dataset.trixAttribute;
                    const editor = document.querySelector('trix-editor').editor;
                    if (attribute === 'heading1') {
                        editor.activateAttribute('heading', 1);
                    } else {
                        editor.toggleAttribute(attribute);
                    }
                });
            });
            
            document.querySelectorAll('.editor-toolbar-btn[data-trix-action]').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const action = this.dataset.trixAction;
                    const editor = document.querySelector('trix-editor').editor;
                    if (action === 'undo') editor.undo();
                    else if (action === 'redo') editor.redo();
                });
            });
            
            // Sync Trix content to hidden input before submit
            document.getElementById('post-form')?.addEventListener('submit', function() {
                const trixEditor = document.querySelector('trix-editor');
                const contentInput = document.getElementById('content');
                if (trixEditor && contentInput) {
                    contentInput.value = trixEditor.value;
                }
            });
            
            const titleInput = document.getElementById('title-input');
            const slugInput = document.getElementById('slug-input');

            function slugify(text) {
                return text.toString().toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            }

            if (titleInput && slugInput && !slugInput.value) {
                titleInput.addEventListener('input', function() {
                    slugInput.value = slugify(titleInput.value);
                });
            }

            const dropZone = document.getElementById('drop-zone');
            const fileInput = document.getElementById('photo');
            const uploadContent = document.getElementById('upload-content');
            const fileSelected = document.getElementById('file-selected');
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            const removeFile = document.getElementById('remove-file');
            const previewContainer = document.getElementById('preview-container');
            const previewImage = document.getElementById('preview-image');

            function formatFileSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
            }

            function handleFile(file) {
                if (file && file.type.startsWith('image/')) {
                    fileName.textContent = file.name;
                    fileSize.textContent = formatFileSize(file.size);
                    uploadContent.classList.add('hidden');
                    fileSelected.classList.remove('hidden');
                    dropZone.classList.add('border-green-400', 'bg-green-50', 'dark:bg-green-900/20');

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }

            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    handleFile(e.target.files[0]);
                });
            }

            if (removeFile) {
                removeFile.addEventListener('click', function() {
                    fileInput.value = '';
                    uploadContent.classList.remove('hidden');
                    fileSelected.classList.add('hidden');
                    dropZone.classList.remove('border-green-400', 'bg-green-50', 'dark:bg-green-900/20');
                    previewContainer.classList.add('hidden');
                });
            }

            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                    }, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, function() {
                        dropZone.classList.add('border-indigo-400', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                    }, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, function() {
                        dropZone.classList.remove('border-indigo-400', 'bg-indigo-50', 'dark:bg-indigo-900/20');
                    }, false);
                });

                dropZone.addEventListener('drop', function(e) {
                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        handleFile(files[0]);
                    }
                }, false);
            }
        });
    </script>
</x-layout>
