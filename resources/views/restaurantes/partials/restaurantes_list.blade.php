<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>
    <div class="row">
        @foreach ($restaurantes as $restaurante)
            <div class="col-md-4 mb-4">
                <a href="{{ route('restaurantes.show', $restaurante->id) }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Foto del restaurante -->
                        @if ($restaurante->fotos && $restaurante->fotos->isNotEmpty())
                            <img src="{{ asset($restaurante->fotos->first()->ruta_imagen) }}" class="card-img-top" alt="{{ $restaurante->nombre }}">
                        @else
                            <img src="{{ asset('img/restaurante_1_' . str_pad(rand(0, 9), 4, '0', STR_PAD_LEFT) . '.jpg') }}" class="card-img-top" alt="{{ $restaurante->nombre }}">
                        @endif
                        <div class="card-body">
                            <!-- Nombre del restaurante -->
                            <h5 class="card-title">{{ $restaurante->nombre }}</h5>
                            <!-- Detalles del restaurante -->
                            <p><strong>Ciudad:</strong> {{$restaurante->ciudad->nombre}}</p>
                            <p><strong>Precio Medio:</strong> {{ $restaurante->precio_medio }}</p>
                            <p><strong>Tipo de Cocina:</strong> {{ $restaurante->tipocomida->nombre ?? 'No especificado' }}</p>
    
                            <!-- Sistema de rating actualizado -->
                            <div class="rating-container mt-3">
                                <!-- Puntuación media -->
                                <div class="average-rating mb-2">
                                    <small class="text-muted">Puntuación media:</small>
                                    <div class="stars" data-restaurant-id="{{ $restaurante->id }}-avg">
                                        @php
                                            $averageRating = round($restaurante->valoraciones->avg('puntuación') ?? 0);
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star star-rating {{ $i <= $averageRating ? 'active' : '' }}" 
                                               data-rating="{{ $i }}"
                                               style="pointer-events: none"></i>
                                        @endfor
                                        <span class="ms-2">({{ number_format($averageRating, 1) }})</span>
                                    </div>
                                </div>

                                <!-- Puntuación del usuario (solo si está autenticado) -->
                                @auth
                                    <div class="user-rating">
                                        <small class="text-muted">Tu puntuación:</small>
                                        <div class="stars" data-restaurant-id="{{ $restaurante->id }}">
                                            @php
                                                $userRating = $restaurante->valoraciones
                                                    ->where('user_id', auth()->id())
                                                    ->first()->puntuación ?? 0;
                                            @endphp
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star star-rating {{ $i <= $userRating ? 'active' : '' }}" 
                                                   data-rating="{{ $i }}"
                                                   data-logged-in="true"></i>
                                            @endfor
                                            <span class="rating-text" data-current-rating="{{ $userRating }}">
                                                ({{ $userRating > 0 ? $userRating : 'Sin valorar' }})
                                            </span>
                                        </div>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <style>
        .rating-container {
            margin-top: 15px;
        }

        .stars {
            display: inline-flex;
            gap: 5px;
            align-items: center;
        }

        .star-rating {
            font-size: 18px;
            color: #ddd;
            transition: color 0.2s;
        }

        .star-rating.active {
            color: #ffc107;
        }

        .average-rating .star-rating {
            font-size: 16px;
        }

        .rating-text {
            display: inline-block;
            margin-left: 5px;
            font-size: 14px;
        }

        .text-muted {
            display: block;
            margin-bottom: 2px;
        }

        .user-rating {
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #eee;
        }
    </style>
</body>
</html>

