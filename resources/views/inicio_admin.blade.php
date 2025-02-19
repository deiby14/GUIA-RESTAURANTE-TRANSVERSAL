<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
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
        .btn-custom {
            border: 2px solid #b22222;
            border-radius: 25px;
            padding: 15px 30px;
            transition: all 0.3s ease;
            width: 75%;
            margin: 15px 0;
            font-size: 18px;
        }
        .btn-custom.primary {
            background-color: #b22222;
            color: white;
        }
        .btn-custom.primary:hover {
            background-color: #8b0000;
            border-color: #8b0000;
        }
        .btn-custom.secondary {
            background-color: white;
            color: #b22222;
        }
        .btn-custom.secondary:hover {
            background-color: #b22222;
            color: white;
        }
        .admin-container {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            margin-top: 30px;
        }
        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
            border-radius: 25px;
            padding: 8px 20px;
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
            <a class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="d-inline-block align-text-top">
            </a>
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

    <div class="container">
        <div class="admin-container">
            <h2 class="text-center mb-4" style="color: #b22222;">Panel de Administración</h2>
            
            <div class="row">
                <div class="col-12 d-flex flex-column align-items-center">
                    <a href="{{ route('administrar') }}" class="btn btn-custom secondary" style="width: 300px;">
                        <i class="fas fa-users"></i> Gestionar Usuarios
                    </a>
                    <a href="{{ route('administrar.restaurantes') }}" class="btn btn-custom secondary" style="width: 300px;">
                        <i class="fas fa-utensils"></i> Gestionar Restaurantes
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 