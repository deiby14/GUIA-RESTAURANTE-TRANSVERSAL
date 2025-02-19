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
    
                            <!-- Sección de rating -->
                            <div class="rating-container mt-3">
                                <div class="stars" data-restaurant-id="{{ $restaurante->id }}">
                                    <i class="fas fa-star star-rating" data-rating="1"></i>
                                    <i class="fas fa-star star-rating" data-rating="2"></i>
                                    <i class="fas fa-star star-rating" data-rating="3"></i>
                                    <i class="fas fa-star star-rating" data-rating="4"></i>
                                    <i class="fas fa-star star-rating" data-rating="5"></i>
                                </div>
                                <span class="rating-text d-block mt-2">
                                    Puntuación: {{ 
                                        isset($userRatings[$restaurante->id]) 
                                        ? (int)$userRatings[$restaurante->id] 
                                        : (int)($restaurante->valoraciones->avg('puntuación') ?? 0) 
                                    }}/5
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</body>
</html>

