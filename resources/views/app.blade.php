<!--
{{-- resources/views/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" translate ="no">
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/js/app.ts'])
        @inertiaHead
        @routes
    </head>
    <body class="font-sans antialiased bg-white text-black">
        @inertia
    </body>
</html>
-->

{{-- resources/views/app.blade.php --}}
<!DOCTYPE html>
<html lang="pt-BR" translate="no"> 
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <meta http-equiv="Content-Language" content="pt-BR"> 
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        @routes
        @vite(['resources/js/app.ts'])
        
        @inertiaHead
        
    </head>

    <body class="font-sans antialiased bg-white text-black" translate="no">
        @inertia
    </body>
</html>
