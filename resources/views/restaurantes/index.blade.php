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
            padding: 10px 0;
            margin: 10px 0;
        }

        .filters-row {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            align-items: center;
        }

        .filter-item {
            flex: 0 1 auto;
        }

        /* Estilo base para todos los elementos de filtro */
        .btn-filter {
            border: 2px solid #b22222;
            border-radius: 20px;
            padding: 5px 15px;
            cursor: pointer;
            background-color: white;
            color: #b22222;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            min-width: 120px;
        }

        /* Estilos específicos para los selects */
        select.btn-filter {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23b22222' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 1em;
            padding-right: 30px;
        }

        /* Estilos específicos para los botones */
        button.btn-filter {
            background-image: none;
            padding: 5px 15px;
        }

        .wide-select {
            min-width: 200px;
            max-width: 300px;
        }

        .btn-filter:hover {
            background-color: #f8d7da;
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-filter.active {
            background-color: #b22222;
            color: white;
        }

        .btn-filter.asc::after {
            content: " ↓";
        }

        .btn-filter.desc::after {
            content: " ↑";
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filter-item {
                flex: 1 1 calc(50% - 10px);
            }
            
            .btn-filter {
                width: 100%;
                max-width: none;
            }
        }

        @media (max-width: 480px) {
            .filter-item {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
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

        <!-- Filtros actualizados con estilo unificado -->
        <div class="filters-container">
            <div class="filters-row">
                <div class="filter-item">
                    <select class="btn-filter" id="ciudad_id" name="ciudad_id">
                        <option value="">🏙️ Ciudad</option>
                        @foreach($ciudades as $ciudad)
                            <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <select class="btn-filter wide-select" id="tipocomida_id" name="tipocomida_id">
                        <option value="">🍽️ Tipo de Comida</option>
                        @foreach($tipos_comida as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-item">
                    <button type="button" class="btn-filter" id="precio-toggle" data-order="none">
                        💰 Precio
                    </button>
                </div>
                <div class="filter-item">
                    <button type="button" class="btn-filter" id="puntuacion-toggle" data-order="none">
                        ⭐ Puntuación
                    </button>
                </div>
                <div class="filter-item">
                    <button type="button" id="clear-filters" class="btn-filter">
                        🔄 Limpiar
                    </button>
                </div>
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
                var orden_precio = $('#precio-toggle').data('order');
                var orden_puntuacion = $('#puntuacion-toggle').data('order');

                $.ajax({
                    url: "{{ route('restaurantes.index') }}",
                    method: "GET",
                    data: {
                        nombre: nombre,
                        ciudad: ciudad,
                        ciudad_id: ciudad_id,
                        tipocomida_id: tipocomida_id,
                        orden_precio: orden_precio === 'none' ? '' : orden_precio,
                        orden_puntuacion: orden_puntuacion === 'none' ? '' : orden_puntuacion
                    },
                    success: function(response) {
                        $('#restaurantes-container').html(response);
                        initializeRating();
                    },
                    error: function() {
                        alert('Ocurrió un error al realizar la búsqueda.');
                    }
                });
            }

            // Eventos para la barra de búsqueda
            $('#nombre, #ciudad').on('input', function() {
                clearTimeout($(this).data('timeout'));
                $(this).data('timeout', setTimeout(function() {
                    actualizarResultados();
                }, 300));
            });

            // Eventos para los filtros de dropdown
            $('#ciudad_id, #tipocomida_id').on('change', actualizarResultados);

            // Toggle buttons functionality (ahora sumativos)
            $('#precio-toggle, #puntuacion-toggle').click(function() {
                const $button = $(this);
                const currentOrder = $button.data('order') || 'none';
                
                // Rotate through none -> asc -> desc -> none
                let newOrder;
                if (currentOrder === 'none') {
                    newOrder = 'asc';
                    $button.addClass('asc active').removeClass('desc');
                } else if (currentOrder === 'asc') {
                    newOrder = 'desc';
                    $button.addClass('desc').removeClass('asc');
                } else {
                    newOrder = 'none';
                    $button.removeClass('asc desc active');
                }
                
                $button.data('order', newOrder);
                actualizarResultados();
            });

            // Clear filters
            $('#clear-filters').click(function() {
                $('#nombre').val('');
                $('#ciudad').val('');
                $('#ciudad_id').val('');
                $('#tipocomida_id').val('');
                $('#precio-toggle, #puntuacion-toggle')
                    .data('order', 'none')
                    .removeClass('asc desc active');
                actualizarResultados();
            });

            // Prevenir el envío del formulario
            $('#search-form').on('submit', function(e) {
                e.preventDefault();
                actualizarResultados();
            });

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
                            if ($('#puntuacion-toggle').data('order') !== 'none') {
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
