<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>@yield('title', 'Welcome to Dinotopia!')</title>
        <link rel="stylesheet" href="{{ asset('styles/styles.css') }}">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
        <script src="https://kit.fontawesome.com/fab65cceab.js" crossorigin="anonymous"></script>
        <script type="module"> import 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/+esm';</script>
        <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>⚫️</text></svg>">
        @stack('stylesheets')

        @stack('javascripts')
    </head>
    <body>
        @yield('body')
    </body>
</html>
