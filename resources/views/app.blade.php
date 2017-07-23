<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkboxes test task</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/td.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>