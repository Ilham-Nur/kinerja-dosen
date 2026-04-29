<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div style="display: flex; min-height: 100vh; font-family: Arial, sans-serif;">
        @include('partials.sidebar')

        <div style="flex: 1; display: flex; flex-direction: column;">
            @include('partials.navbar')

            <main style="padding: 24px; background: #f5f5f5; flex: 1;">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
