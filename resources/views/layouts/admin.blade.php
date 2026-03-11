<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - FMEXPRESS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- SIDEBAR -->
        @include('components.admin.sidebar')

        <!-- MAIN CONTENT -->
        <div class="flex-1">
            @yield('content')
        </div>
    </div>
</body>
</html>