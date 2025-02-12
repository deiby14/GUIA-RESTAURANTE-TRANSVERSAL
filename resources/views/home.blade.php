<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Inicio</title>
    <!-- Agregar Bootstrap u otros estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Bienvenido a nuestra Aplicación</h1>
        <p>Esta es tu página de inicio.</p>

        @if(auth()->check())
            <a href="{{ route('restaurants.index') }}" class="btn btn-primary">Ver Restaurantes</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">Iniciar Sesión</a>
        @endif
    </div>
</body>
</html>