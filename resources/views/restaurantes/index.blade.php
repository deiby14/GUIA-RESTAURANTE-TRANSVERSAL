<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <!-- Agregar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <style>
        .card img {
            height: 200px;
            object-fit: cover;
        }   
            .navbar-custom {
                background-color: #fff; /* Fondo blanco */
                box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); /* Sombra negra suave */
            }
            .navbar-brand img {
                max-height: 40px; /* Tamaño del logotipo */
            }
            .user-icon {
                cursor: pointer; /* Cambiar el cursor al pasar sobre el icono */
            }
    
            /* Estilos para las barras de búsqueda */
            .search-form {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px; /* Espaciado entre elementos */
            }
            .search-form input {
                border: 2px solid #b22222; /* Borde rojo más fuerte */
                border-radius: 25px; /* Bordes redondeados */
                padding: 10px 20px; /* Espaciado interior */
                flex: 1; /* Expandir los inputs */
                max-width: calc(45%); /* Limitar el ancho para dejar espacio al botón */
            }
            .search-form button {
                background-color: #b22222; /* Color rojo más fuerte */
                color: white;
                border: none;
                border-radius: 25px; /* Bordes redondeados */
                padding: 10px 20px; /* Espaciado interior */
                cursor: pointer;
                transition: background-color 0.3s ease;
            }
            .search-form button:hover {
                background-color: #8b0000; /* Efecto hover más oscuro */
            }
            h3{
                color: white;
                font-weight: bold;
                text-align: center;
                padding: 10px;
            }
            .container-grid {
                display: grid;
                grid-template-columns: 1fr 1fr; /* Dos columnas de igual tamaño */
                height: 100vh; /* Ocupa toda la altura de la ventana */
            }
            .izquierda, .derecha {
                padding: 20px; /* Espaciado interno */
            }
            .btn-hover-grey:hover {
                background-color: #e0e0e0; /* Un gris un poco más oscuro */
                color: #000; /* Cambiar el color del texto */
                border: 1px solid #ccc; /* Agregar un borde */
            }
            .navbar-nav {
                margin-top: 3px; /* Margen superior */
                margin-bottom: 4px; /* Margen inferior */
            }
        </style>
</head>
<body>
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
                            <a href="{{ route('restaurantes.index') }}" class="btn btn-hover-grey" style="margin-right: 10px;">Restaurantes</a>
                        </li>
                        <li class="nav-item mt-2 mb-2">
                            <a href="{{ route('favorites.index') }}" class="btn btn-hover-grey">Favoritos</a>
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
        <h1 class="mb-4">Lista de Restaurantes</h1>
        <div class="row">
            @foreach ($restaurantes as $restaurante)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <!-- Mostrar la primera imagen si existe -->
                        @if ($restaurante->fotos && $restaurante->fotos->isNotEmpty())
                        <img src="{{ asset('img/restaurante_1_' . str_pad(rand(0, 9), 4, '0', STR_PAD_LEFT) . '.jpg') }}" class="card-img-top" alt="{{ $restaurante->nombre }}">
                        @else
                            <!-- Mostrar una imagen por defecto si no hay fotos -->
                            <img src="{{ asset('img/restaurante_1_' . str_pad(rand(0, 9), 4, '0', STR_PAD_LEFT) . '.jpg') }}" class="card-img-top" alt="{{ $restaurante->nombre }}">
                        @endif
        
                        <div class="card-body">
                            <h5 class="card-title">{{ $restaurante->nombre }}</h5>
                            <p><strong>Dirección:</strong> {{ $restaurante->direccion }}</p>
                            <p><strong>Precio Medio:</strong> {{ $restaurante->precio_medio }}</p>
                            <p><strong>Tipo de Cocina:</strong> {{ $restaurante->tipo_cocina }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Agregar Bootstrap JS (opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>