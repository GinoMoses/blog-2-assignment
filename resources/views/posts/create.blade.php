<x-layout>
    <form method="POST" action="{{ route('posts.store') }}" class="flex flex-col max-w-3xl mx-auto my-4 space-y-4">
        @csrf

        @if ($errors->any())
            <ul class="bg-red-200 text-red-700 p-6 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div>
            <label class="block font-medium mb-1">Tytul</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded p-2" />
            @error('title')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Przyjazny adres</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="w-full border rounded p-2" />
            @error('slug')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Autor</label>
            <input type="text" name="author" value="{{ old('author') }}" class="w-full border rounded p-2" />
            @error('author')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Kategorie</label>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                            class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2">{{ $category->name }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block font-medium mb-1">Tagi (oddzielone przecinkami)</label>
            <input type="text" name="tags" value="{{ old('tags') }}" placeholder="np. laravel, php, tutorial"
                class="w-full border rounded p-2" />
            <p class="text-sm text-gray-500 mt-1">Istniejące tagi: {{ $tags->pluck('name')->implode(', ') ?: 'brak' }}</p>
            @error('tags')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Zajawka</label>
            <textarea name="lead" rows="3" class="w-full border rounded p-2">{{ old('lead') }}</textarea>
            @error('lead')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label class="block font-medium mb-1">Treść</label>
            <textarea name="content" rows="10" class="w-full border rounded p-2">{{ old('content') }}</textarea>
            @error('content')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-blue-700 text-white p-4 mt-4 rounded hover:bg-blue-800">
            Dodaj
        </button>
    </form>
</x-layout>
