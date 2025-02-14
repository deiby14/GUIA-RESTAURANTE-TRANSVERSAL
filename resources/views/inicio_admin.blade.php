<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Panel de Administración</h2>
        
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <a href="{{ route('administrar') }}" class="btn btn-primary btn-lg m-2 w-75">Gestionar Usuarios</a>
                <br>
                <a href="{{ route('administrar.restaurantes') }}" class="btn btn-success btn-lg m-2 w-75">Gestionar Restaurantes</a>
                
                <!-- Botón de cerrar sesión -->
                <form action="{{ route('logout') }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 