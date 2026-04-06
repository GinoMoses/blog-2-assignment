<!DOCTYPE html>
<html lang="pl" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - Lista Postów</title>

    <script>
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    @vite(['resources/css/app.css'])
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
    @include('partials.navigation')

    {{ $slot }}

    @include('partials.footer')

    @vite(['resources/js/app.js'])
</body>

</html>
