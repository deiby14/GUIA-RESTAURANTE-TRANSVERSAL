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

        /* Estilos para los filtros */
        .filters-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        .form-select {
            border: 2px solid #b22222;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            background-color: white;
            transition: all 0.3s ease;
        }

        .form-select:hover {
            border-color: #8b0000;
        }

        .form-select:focus {
            border-color: #8b0000;
            box-shadow: 0 0 0 0.2rem rgba(139,0,0,0.25);
            outline: none;
        }

        /* Botón limpiar filtros */
        .btn-clear-filters {
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .btn-clear-filters:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        /* Contenedor de filtros responsive */
        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
            align-items: center;
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
        }

        /* Etiquetas para los filtros */
        .filter-label {
            display: block;
            margin-bottom: 5px;
            color: #666;
            font-size: 0.9rem;
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
    
    <!-- Barra de búsqueda y filtros -->
    <div class="container">
        <form id="search-form" class="search-form">
            <input type="text" name="nombre" id="nombre" placeholder="Buscar por nombre" value="{{ request()->get('nombre') }}">
            <input type="text" name="ciudad" id="ciudad" placeholder="Buscar por ciudad" value="{{ request()->get('ciudad') }}">
        </form>

        <!-- Filtros actualizados -->
        <div class="filters-container">
            <div class="filters-row">
                <div class="filter-item">
                    <label class="filter-label">Ciudad</label>
                    <select class="form-select" id="ciudad_id" name="ciudad_id">
                        <option value="">Todas las ciudades</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Tipo de Comida</label>
                    <select class="form-select" id="tipocomida_id" name="tipocomida_id">
                        <option value="">Todos los tipos</option>
                        @foreach($tipos_comida as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Ordenar por Precio</label>
                    <select class="form-select" id="orden_precio" name="orden_precio">
                        <option value="">Precio</option>
                        <option value="asc">Menor a mayor</option>
                        <option value="desc">Mayor a menor</option>
                    </select>
                </div>
                <div class="filter-item">
                    <label class="filter-label">Ordenar por Puntuación</label>
                    <select class="form-select" id="orden_puntuacion" name="orden_puntuacion">
                        <option value="">Puntuación</option>
                        <option value="desc">Mayor puntuación</option>
                        <option value="asc">Menor puntuación</option>
                    </select>
                </div>
            </div>
            <div class="text-center">
                <button type="button" id="clear-filters" class="btn-clear-filters">
                    <i class="fas fa-undo-alt"></i> Limpiar Filtros
                </button>
            </div>
        </div>
    </div>
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
            function actualizarResultados() {
                var nombre = $('#nombre').val();
                var ciudad = $('#ciudad').val();
                var ciudad_id = $('#ciudad_id').val();
                var tipocomida_id = $('#tipocomida_id').val();
                var orden_precio = $('#orden_precio').val();
                var orden_puntuacion = $('#orden_puntuacion').val();

                $.ajax({
                    url: "{{ route('restaurantes.index') }}",
                    method: "GET",
                    data: {
                        nombre: nombre,
                        ciudad: ciudad,
                        ciudad_id: ciudad_id,
                        tipocomida_id: tipocomida_id,
                        orden_precio: orden_precio,
                        orden_puntuacion: orden_puntuacion
                    },
                    success: function(response) {
                        $('#restaurantes-container').html(response);
                    },
                    error: function() {
                        alert('Ocurrió un error al realizar la búsqueda.');
                    }
                });
            }

            // Eventos para la barra de búsqueda
            $('#nombre, #ciudad').on('input', function() {
                // Pequeño retraso para evitar demasiadas peticiones
                clearTimeout($(this).data('timeout'));
                $(this).data('timeout', setTimeout(function() {
                    actualizarResultados();
                }, 300));
            });

            // Eventos para los filtros
            $('#ciudad_id, #tipocomida_id, #orden_precio, #orden_puntuacion').on('change', actualizarResultados);

            // Prevenir el envío del formulario
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                actualizarResultados();
            });

            // Función para limpiar filtros
            $('#clear-filters').click(function() {
                // Limpiar todos los campos
                $('#nombre').val('');
                $('#ciudad').val('');
                $('#ciudad_id').val('');
                $('#tipocomida_id').val('');
                $('#orden_precio').val('');
                $('#orden_puntuacion').val('');
                
                // Actualizar resultados
                actualizarResultados();
            });

            // Sistema de rating en tiempo real
            function initializeRating() {
                $('.stars').each(function() {
                    const $starsContainer = $(this);
                    const restaurantId = $starsContainer.data('restaurant-id');
                    const $stars = $starsContainer.find('.star-rating');
                    const $ratingText = $starsContainer.siblings('.rating-text');

                    // Hover effect
                    $stars.hover(
                        function() {
                            const rating = $(this).data('rating');
                            updateStarsDisplay($stars, rating);
                        },
                        function() {
                            const currentRating = $ratingText.data('current-rating') || 0;
                            updateStarsDisplay($stars, currentRating);
                        }
                    );

                    // Click event
                    $stars.click(function() {
                        if (!$(this).data('logged-in')) {
                            window.location.href = "{{ route('login') }}";
                            return;
                        }

                        const rating = $(this).data('rating');
                        submitRating(restaurantId, rating, $stars, $ratingText);
                    });
                });
            }

            function updateStarsDisplay($stars, rating) {
                $stars.each(function() {
                    const starRating = $(this).data('rating');
                    $(this).toggleClass('active', starRating <= rating);
                });
            }

            function submitRating(restaurantId, rating, $stars, $ratingText) {
                $.ajax({
                    url: "{{ route('restaurantes.rate') }}",
                    method: 'POST',
                    data: {
                        restaurant_id: restaurantId,
                        rating: rating,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Actualizar la visualización de las estrellas actuales
                            updateStarsDisplay($stars, rating);
                            $ratingText.text(`Puntuación: ${rating}/5`);
                            $ratingText.data('current-rating', rating);

                            // Actualizar el promedio en tiempo real
                            if (response.newRating !== undefined) {
                                // Actualizar todas las estrellas para este restaurante cuando no está logueado
                                $(`.stars[data-restaurant-id="${restaurantId}"]`).each(function() {
                                    const $otherStars = $(this).find('.star-rating');
                                    const $otherRatingText = $(this).siblings('.rating-text');
                                    
                                    if (!$otherStars.data('logged-in')) {
                                        updateStarsDisplay($otherStars, response.newRating);
                                        $otherRatingText.text(`Puntuación: ${response.newRating}/5`);
                                        $otherRatingText.data('current-rating', response.newRating);
                                    }
                                });
                            }

                            // Mostrar mensaje de éxito
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal.stopTimer)
                                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                                }
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Valoración guardada correctamente'
                            });

                            // Si hay filtros de puntuación activos, actualizar los resultados
                            if ($('#orden_puntuacion').val()) {
                                actualizarResultados();
                            }
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo guardar la valoración'
                        });
                    }
                });
            }

            // Inicializar el sistema de rating
            initializeRating();

            // Reinicializar rating después de actualizar resultados
            $(document).ajaxComplete(function(event, xhr, settings) {
                if (settings.url.includes('restaurantes')) {
                    initializeRating();
                }
            });
        });
    </script>
</body>
</html>
