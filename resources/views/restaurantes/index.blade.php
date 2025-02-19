<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurantes</title>
    <!-- Agregar Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

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

        /* Estilos para la barra de búsqueda */
        .search-form {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }
        .search-form input {
            border: 2px solid #b22222; /* Borde rojo más fuerte */
            border-radius: 25px; /* Bordes redondeados */
            padding: 10px 20px; /* Espaciado interior */
            width: 50%; /* Ocupa el 50% del ancho de la pantalla */
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
        .btn-outline-danger {
            color: #dc3545;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
        }
        .btn-outline-danger:hover {
            color: white;
            background-color: #dc3545;
        }
        .rating-container {
            margin-top: 15px;
        }

        .stars {
            display: inline-flex;
            gap: 5px;
            cursor: pointer;
        }

        .star-rating {
            font-size: 20px;
            color: #ddd;
            transition: color 0.2s;
        }

        .star-rating.active {
            color: #ffc107;
        }

        .rating-text {
            display: block;
            margin-top: 5px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if(auth()->check())
                        
                        
                    @endif
                    @if(auth()->check())
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link user-icon me-3" href="#" style="display: flex; align-items: center;">
                                <img src="{{ asset('img/user.webp') }}" alt="Usuario" class="rounded-circle" style="max-height: 40px;">
                                <span style="margin-left: 10px;">{{ auth()->user()->name }}</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger" style="border-radius: 25px; padding: 8px 20px;">
                                    Cerrar Sesión
                                </button>
                            </form>
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
    <br><br>
    
    <!-- Barra de búsqueda -->
    <form id="search-form" class="search-form">
        <input type="text" name="nombre" id="nombre" placeholder="Buscar por nombre" value="{{ request()->get('nombre') }}">
        <input type="text" name="ciudad" id="ciudad" placeholder="Buscar por ciudad" value="{{ request()->get('ciudad') }}">
    </form>
    <hr>

    <!-- Contenedor de resultados -->
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Restaurantes</h1>
        <div id="restaurantes-container">
            @include('restaurantes.partials.restaurantes_list', ['restaurantes' => $restaurantes])
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/rating.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#nombre, #ciudad').on('input', function() {
                var nombre = $('#nombre').val();
                var ciudad = $('#ciudad').val();

                $.ajax({
                    url: "{{ route('restaurantes.index') }}",
                    method: "GET",
                    data: {
                        nombre: nombre,
                        ciudad: ciudad
                    },
                    success: function(response) {
                        $('#restaurantes-container').html(response);
                    },
                    error: function() {
                        alert('Ocurrió un error al realizar la búsqueda.');
                    }
                });
            });
        });
    </script>
</body>
</html>
