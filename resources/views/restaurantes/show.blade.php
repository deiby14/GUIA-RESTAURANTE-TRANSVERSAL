<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurante->nombre }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .valoracion-box {
            border: 1px solid #dc3545;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .valoracion-actions {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
        .stars {
            color: #ffc107;
            margin-bottom: 15px;
            font-size: 24px;
        }
        .star-rating {
            cursor: pointer;
            transition: transform 0.2s;
        }
        .star-rating:hover {
            transform: scale(1.2);
        }
        .restaurant-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
        }
        .valoraciones-section h3 {
            color: #dc3545;
            margin-bottom: 20px;
        }
        .btn-custom {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
        }
        .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .user-info img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        .date-info {
            color: #6c757d;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <!-- Incluir el mismo navbar que tienes en index -->
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-4">{{ $restaurante->nombre }}</h1>
                
                @if(auth()->check())
                    <!-- Panel de edición de comentario para el usuario actual -->
                    @php
                        $miValoracion = $restaurante->valoraciones->where('user_id', auth()->id())->first();
                    @endphp
                    @if($miValoracion)
                    <div class="valoracion-box mb-4">
                        <h4>Tu valoración</h4>
                        <div class="stars mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $miValoracion->puntuación ? 'text-warning' : 'text-secondary' }}"></i>
                            @endfor
                        </div>
                        <div class="comment-section">
                            <p class="mb-2">{{ $miValoracion->comentario }}</p>
                            <div class="btn-group">
                                <button class="btn btn-outline-primary btn-sm edit-valoracion me-2" 
                                        data-valoracion-id="{{ $miValoracion->id }}"
                                        data-comentario="{{ $miValoracion->comentario }}">
                                    <i class="fas fa-edit"></i> Editar comentario
                                </button>
                                <form action="{{ route('valoraciones.reset', $miValoracion->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar tu comentario?')">
                                        <i class="fas fa-trash"></i> Eliminar comentario
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif

                @if ($restaurante->fotos->isNotEmpty())
                    <img src="{{ asset($restaurante->fotos->first()->ruta_imagen) }}" 
                         class="img-fluid rounded mb-4 w-100" 
                         style="object-fit: cover; height: 400px;" 
                         alt="{{ $restaurante->nombre }}">
                @endif
                
                <div class="restaurant-info">
                    <h3 class="mb-4">Información del Restaurante</h3>
                    <p><i class="fas fa-map-marker-alt text-danger"></i> <strong>Dirección:</strong> {{ $restaurante->direccion }}</p>
                    <p><i class="fas fa-utensils text-danger"></i> <strong>Tipo de Cocina:</strong> {{ $restaurante->tipo_cocina }}</p>
                    <p><i class="fas fa-euro-sign text-danger"></i> <strong>Precio Medio:</strong> {{ $restaurante->precio_medio }}€</p>
                    <p><i class="fas fa-info-circle text-danger"></i> <strong>Descripción:</strong> {{ $restaurante->descripcion }}</p>
                </div>

                <div class="valoraciones-section">
                    <h3><i class="fas fa-star text-danger"></i> Valoraciones y Comentarios</h3>
                    <div class="valoraciones-list">
                        @foreach($restaurante->valoraciones->where('user_id', '!=', auth()->id()) as $valoracion)
                            <div class="valoracion-box">
                                <div class="user-info">
                                    <img src="{{ asset('img/user.webp') }}" alt="Usuario">
                                    <div>
                                        <strong>{{ $valoracion->user->name }}</strong>
                                        <div class="date-info">{{ $valoracion->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $valoracion->puntuación ? 'text-warning' : 'text-secondary' }}"></i>
                                    @endfor
                                </div>
                                <p class="mb-2">{{ $valoracion->comentario }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar botón volver arriba a la derecha, justo después del navbar -->
    <div class="container mt-3">
        <div class="row">
            <div class="col-12 text-end">
                <a href="{{ route('restaurantes.index') }}" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <!-- Agregar botón volver al final de la página -->
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('restaurantes.index') }}" class="btn btn-outline-danger">
            <i class="fas fa-arrow-left"></i> Volver a restaurantes
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Manejo de estrellas para la puntuación
        const stars = document.querySelectorAll('.star-rating');
        const puntuacionInput = document.getElementById('puntuacion');

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                highlightStars(rating);
            });

            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                puntuacionInput.value = rating;
                highlightStars(rating);
            });
        });

        function highlightStars(rating) {
            stars.forEach(star => {
                star.classList.toggle('text-warning', star.dataset.rating <= rating);
            });
        }

        // Manejo del formulario
        const valoracionForm = document.querySelector('form');
        if (valoracionForm) {
            valoracionForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const comentario = document.getElementById('comentario').value;
                if (!comentario.trim()) {
                    alert('Por favor, escribe un comentario');
                    return;
                }

                this.submit();
            });
        }

        // Manejo de edición de valoraciones
        document.querySelectorAll('.edit-valoracion').forEach(button => {
            button.addEventListener('click', function() {
                const valoracionId = this.dataset.valoracionId;
                const comentario = this.dataset.comentario;
                const valoracionBox = this.closest('.valoracion-box');
                
                const form = document.createElement('form');
                form.action = `/valoraciones/${valoracionId}`;
                form.method = 'POST';
                form.innerHTML = `
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <textarea class="form-control" name="comentario">${comentario}</textarea>
                    </div>
                    <button type="submit" class="btn btn-custom btn-sm">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm cancel-edit">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                `;
                
                const originalContent = valoracionBox.innerHTML;
                valoracionBox.innerHTML = '';
                valoracionBox.appendChild(form);
                
                form.querySelector('.cancel-edit').addEventListener('click', () => {
                    valoracionBox.innerHTML = originalContent;
                });
            });
        });
    </script>
</body>
</html> 