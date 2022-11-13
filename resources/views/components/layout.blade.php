<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ isset($title) ? "$title - " : '' }}{{ config('app.name') }}</title>

        @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <main class="container">
            {{ $slot }}
        </main>     
    </body>
</html>