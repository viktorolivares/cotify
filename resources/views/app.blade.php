<!DOCTYPE html>
<html class="h-full dark">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    {{-- Inertia --}}
    {{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=smoothscroll,NodeList.prototype.forEach,Promise,Object.values,Object.assign" defer></script> --}}

    {{-- Ping CRM --}}
    {{-- <script src="https://polyfill.io/v3/polyfill.min.js?features=String.prototype.startsWith" defer></script> --}}

    @vite('resources/js/app.js')
    @inertiaHead
</head>
<body class="bg-white dark:bg-slate-900 dark:[color-scheme:dark] dark:text-gray-200 font-sans leading-none antialiased text-xs">
    @inertia
</body>
</html>
