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
                        <li class="nav-item mt-2 mb-2">
                            <a href="{{ route('restaurantes.index') }}" class="btn btn-hover-grey" style="margin-right: 10px;">Restaurantes</a>
                        </li>
                        <li class="nav-item mt-2 mb-2">
                            <a href="{{ route('favorites.index') }}" class="btn btn-hover-grey">Favoritos</a>
                        </li>
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
        <input type="text" name="nombre" id="nombre" placeholder="Buscar por nombre">
        <input type="text" name="ciudad" id="ciudad" placeholder="Buscar por ciudad">
        <button type="button" id="btn-buscar">Buscar</button>
    </form>

    <!-- Botones de filtro -->
    <div class="text-center mb-4">
        <button class="btn btn-outline-danger filter-btn" data-filter="precio">Ordenar por Precio</button>
        <button class="btn btn-outline-danger filter-btn" data-filter="valoracion">Ordenar por Valoración</button>

        <!-- Dropdown Filtro de Ciudad -->
        <div class="btn-group">
            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownCiudad" data-bs-toggle="dropdown">
                Filtrar por Ciudad
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownCiudad">
                @foreach ($ciudades as $ciudad)
                    <li>
                        <a class="dropdown-item filtro-ciudad" href="#" data-id="{{ $ciudad->id }}">{{ $ciudad->nombre }}</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Dropdown Filtro de Tipo de Comida -->
        <div class="btn-group">
            <button class="btn btn-outline-danger dropdown-toggle" type="button" id="dropdownComida" data-bs-toggle="dropdown">
                Filtrar por Tipo de Comida
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownComida">
                @foreach ($tipos_comida as $tipo)
                    <li>
                        <a class="dropdown-item filtro-comida" href="#" data-id="{{ $tipo->id }}">{{ $tipo->nombre }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Contenedor de resultados -->
    <div id="restaurantes-container">
        @include('restaurantes.partials.restaurantes_list', ['restaurantes' => $restaurantes])
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/rating.js') }}"></script>
    <script>
        $(document).ready(function() {
            let timeoutId;
    
            function filtrarRestaurantes() {
                var nombre = $('#nombre').val();
                var ciudad = $('#ciudad').val();
                var filtroPrecio = $('.filter-btn[data-filter="precio"]').hasClass('active') ? 'asc' : '';
                var filtroValoracion = $('.filter-btn[data-filter="valoracion"]').hasClass('active') ? 'desc' : '';
    
                var ciudadesSeleccionadas = $('.filtro-ciudad.active').map(function() {
                    return $(this).data('id');
                }).get();
    
                var tiposComidaSeleccionados = $('.filtro-comida.active').map(function() {
                    return $(this).data('id');
                }).get();
    
                $.ajax({
                    url: "{{ route('restaurantes.index') }}",
                    method: "GET",
                    data: {
                        nombre: nombre,
                        ciudad: ciudad,
                        precio: filtroPrecio,
                        valoracion: filtroValoracion,
                        ciudades: ciudadesSeleccionadas,
                        tiposComida: tiposComidaSeleccionados
                    },
                    success: function(response) {
                        $('#restaurantes-container').html(response);
                    },
                    error: function() {
                        alert('Error al cargar los datos.');
                    }
                });
            }
    
            // Buscar automáticamente al escribir en los campos de búsqueda con debounce
            $('#nombre, #ciudad').on('input', function() {
                clearTimeout(timeoutId);
                timeoutId = setTimeout(filtrarRestaurantes, 300); // 300ms de retraso
            });
    
            // Buscar al hacer clic en el botón Buscar
            $('#btn-buscar').on('click', filtrarRestaurantes);
    
            // Manejo de botones de filtro
            $('.filter-btn').on('click', function() {
                // Desactivar otros botones de filtro
                $('.filter-btn').not(this).removeClass('active');
                // Alternar estado activo del botón clickeado
                $(this).toggleClass('active');
                filtrarRestaurantes();
            });
    
            // Manejo de selección en dropdown de ciudad
            $('.filtro-ciudad').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                filtrarRestaurantes();
            });
    
            // Manejo de selección en dropdown de tipo de comida
            $('.filtro-comida').on('click', function(e) {
                e.preventDefault();
                $(this).toggleClass('active');
                filtrarRestaurantes();
            });
        });
    </script>
</body>
</html>