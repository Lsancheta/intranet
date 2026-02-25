<!DOCTYPE html>
<html lang="pt-BR" translate="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Pannela de Pedra') }}</title>

    @routes
    @vite(['resources/js/app.ts'])
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
