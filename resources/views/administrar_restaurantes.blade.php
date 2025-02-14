<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Restaurantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados para la navbar */
        .navbar-custom {
            background-color: #fff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand img {
            max-height: 40px;
        }
        .user-icon {
            cursor: pointer;
        }
        .btn-hover-grey:hover {
            background-color: #e0e0e0;
            color: #000;
            border: 1px solid #ccc;
        }

        /* Estilos para los botones del CRUD */
        .btn-outline-custom {
            color: #000;
            background-color: transparent;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Para el botón de eliminar */
        .btn-outline-danger {
            color: #dc3545;
            background-color: transparent;
            border: 2px solid #dc3545;
        }

        .btn-outline-danger:hover {
            color: #fff;
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <!-- Logotipo -->
            <a class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <!-- Botón de collapse para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenido de la navbar -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item mt-2 mb-2">
                            <a href="{{ route('administrar') }}" class="btn btn-hover-grey" style="margin-right: 10px;">Usuarios</a>
                        </li>
                       
                    @endif

                    @if(auth()->check())
                        <li class="nav-item">
                            <a class="nav-link user-icon" href="#" style="display: flex; align-items: center;">
                                <img src="{{ asset('img/user.webp') }}" alt="Usuario" class="rounded-circle" style="max-height: 40px;">
                                <span style="margin-left: 10px;">{{ auth()->user()->name }}</span>
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-danger" style="border-radius: 25px; padding: 10px 20px;">Iniciar Sesión</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Administrar Restaurantes</h2>
            <a href="{{ route('restaurantes.create') }}" class="btn btn-outline-custom">Añadir Restaurante</a>
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
                            <a href="{{ route('restaurantes.edit', $restaurante->id) }}" class="btn btn-sm btn-outline-custom">Editar</a>
                            <form action="{{ route('restaurantes.delete', $restaurante->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
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