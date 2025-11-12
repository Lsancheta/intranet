<!--
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Intranet OS')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">Intranet OS</a>
    <div class="navbar-nav">
      <a class="nav-link" href="{{ route('ordens.index') }}">Ordens de Serviço</a>
      <a class="nav-link" href="{{ route('estoque.index') }}">Estoque</a>
    </div>
  </div>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>