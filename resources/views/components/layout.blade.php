@php
    $appName = config('app.name');
@endphp

@props([
    'title' => $appName,
    'showTitle' => true,
])

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title !== $appName ? "$title - $appName" : $appName }}</title>

    <link rel="shortcut icon" href="/img/favicon/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/img/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="/img/favicon/favicon-192.png">
    <link rel="icon" type="image/png" sizes="160x160" href="/img/favicon/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/img/favicon/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/img/favicon/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/img/favicon/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/favicon/favicon-16.png">
    <link rel="apple-touch-icon" href="/img/favicon/favicon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/img/favicon/favicon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/img/favicon/favicon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/img/favicon/favicon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/img/favicon/favicon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/img/favicon/favicon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/favicon/favicon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/img/favicon/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/img/favicon/favicon-180.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/img/favicon/favicon-144.png">
    <meta name="msapplication-config" content="/img/browserconfig.xml">

    @vite(['resources/scss/app.scss', 'resources/js/app.ts'])
</head>

<body>
    <x-navbar />
    <main class="container mt-2" id="app">
        @if ($showTitle != false)
            <h1>{{ $title }}</h1>
        @endif

        {{ $slot }}
    </main>
</body>

</html>
