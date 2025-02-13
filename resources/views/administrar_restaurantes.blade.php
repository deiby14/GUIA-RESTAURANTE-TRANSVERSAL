<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Restaurantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Administrar Restaurantes</h2>
            <a href="{{ route('restaurantes.create') }}" class="btn btn-success">Añadir Restaurante</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($restaurantes as $restaurante)
                    <tr>
                        <td>{{ $restaurante->id }}</td>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->direccion }}</td>
                        <td>{{ $restaurante->telefono }}</td>
                        <td>
                            <a href="{{ route('restaurantes.edit', $restaurante->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('restaurantes.delete', $restaurante->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón de cerrar sesión -->
        <form action="{{ route('logout') }}" method="POST" class="mt-3">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html> 