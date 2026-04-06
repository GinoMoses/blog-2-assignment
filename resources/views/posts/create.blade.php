<x-layout>
    <div class="max-w-3xl mx-auto my-8">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Nowy post</h1>

        <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 space-y-6">
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
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Przyjazny adres (slug)</label>
                <input type="text" name="slug" value="{{ old('slug') }}" 
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
                <textarea name="content" rows="8" 
                    class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2.5 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">{{ old('content') }}</textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
