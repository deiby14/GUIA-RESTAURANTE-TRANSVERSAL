<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
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

        /* Estilos para los botones del panel */
        .btn-admin {
            color: #000;
            background-color: transparent;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
            padding: 15px 30px;
            margin: 10px 0;
            width: 100%;
            max-width: 300px;
            font-size: 1.1rem;
        }

        .btn-admin:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .admin-panel {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        .panel-title {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 8px 25px;
        }

        .btn-outline-danger:hover {
            color: white;
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
            <!-- Contenido de la navbar -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link user-icon me-3" href="#" style="display: flex; align-items: center;">
                                <img src="{{ asset('img/user.webp') }}" alt="Usuario" class="rounded-circle" style="max-height: 40px;">
                                <span style="margin-left: 10px;">{{ auth()->user()->name }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="admin-panel text-center">
                    <h2 class="panel-title mb-4">Panel de Administración</h2>
                    
                    <div class="d-flex flex-column align-items-center">
                        <a href="{{ route('administrar') }}" class="btn btn-admin mb-3">
                            Gestionar Usuarios
                        </a>
                        
                        <a href="{{ route('administrar.restaurantes') }}" class="btn btn-admin mb-3">
                            Gestionar Restaurantes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 