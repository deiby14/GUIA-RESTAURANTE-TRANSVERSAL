<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Restaurantes</title>
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

        /* Estilos para los botones del CRUD */
        .btn-outline-custom {
            color: #000;
            background-color: transparent;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        /* Para el botón de eliminar */
        .btn-outline-danger {
            color: #dc3545;
            background-color: transparent;
            border: 2px solid #dc3545;
        }

        .btn-outline-danger:hover {
            color: #fff;
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
            <!-- Botón de collapse para pantallas pequeñas -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Contenido de la navbar -->
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if(auth()->check())
                        <li class="nav-item mt-2 mb-2">
                            <a href="{{ route('administrar') }}" class="btn btn-hover-grey" style="margin-right: 10px;">Usuarios</a>
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

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Administrar Restaurantes</h2>
            <button type="button" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#createRestauranteModal">
                Añadir Restaurante
            </button>
        </div>
        
        <!-- Mensajes de error y éxito -->
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Añade esto justo después del div de mensajes de éxito y antes de la tabla -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" id="searchNombre" class="form-control" placeholder="Buscar por nombre...">
                    </div>
                    <div class="col-md-2">
                        <select id="filterCiudad" class="form-control">
                            <option value="">Todas las ciudades</option>
                            @foreach(\App\Models\Ciudad::all() as $ciudad)
                                <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filterTipoComida" class="form-control">
                            <option value="">Todos los tipos</option>
                            @foreach(\App\Models\Tipocomida::all() as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select id="filterPrecio" class="form-control">
                            <option value="">Todos los precios</option>
                            <option value="$">$ (Económico)</option>
                            <option value="$$">$$ (Moderado)</option>
                            <option value="$$$">$$$ (Caro)</option>
                            <option value="$$$$">$$$$ (Muy caro)</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button id="limpiarFiltros" class="btn btn-secondary">Limpiar filtros</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio Medio</th>
                    <th>Tipo de Cocina</th>
                    <th>Ciudad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($restaurantes as $restaurante)
                    <tr>
                        <td>{{ $restaurante->id }}</td>
                        <td>{{ $restaurante->nombre }}</td>
                        <td>{{ $restaurante->precio_medio }}</td>
                        <td>{{ $restaurante->tipocomida->nombre ?? 'No especificado' }}</td>
                        <td>{{ $restaurante->ciudad ? $restaurante->ciudad->nombre : 'No especificada' }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-custom" data-bs-toggle="modal" data-bs-target="#editRestauranteModal{{ $restaurante->id }}">
                                Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRestauranteModal{{ $restaurante->id }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal de Edición -->
                    <div class="modal fade" id="editRestauranteModal{{ $restaurante->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Restaurante</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('restaurantes.update', $restaurante->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="nombre" value="{{ $restaurante->nombre }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Dirección</label>
                                            <input type="text" class="form-control" name="dirección" value="{{ $restaurante->dirección }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Precio Medio</label>
                                            <select class="form-control" name="precio_medio" required>
                                                <option value="$" {{ $restaurante->precio_medio === '$' ? 'selected' : '' }}>$ (Económico)</option>
                                                <option value="$$" {{ $restaurante->precio_medio === '$$' ? 'selected' : '' }}>$$ (Moderado)</option>
                                                <option value="$$$" {{ $restaurante->precio_medio === '$$$' ? 'selected' : '' }}>$$$ (Caro)</option>
                                                <option value="$$$$" {{ $restaurante->precio_medio === '$$$$' ? 'selected' : '' }}>$$$$ (Muy caro)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Descripción</label>
                                            <textarea class="form-control" name="descripcion" rows="3">{{ $restaurante->descripcion }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ciudad</label>
                                            <select class="form-control" name="ciudad_id" required>
                                                <option value="">Seleccione una ciudad</option>
                                                @foreach(\App\Models\Ciudad::all() as $ciudad)
                                                    <option value="{{ $ciudad->id }}" {{ $restaurante->ciudad_id == $ciudad->id ? 'selected' : '' }}>
                                                        {{ $ciudad->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tipo de Cocina</label>
                                            <select class="form-control" name="tipocomida_id" required>
                                                <option value="">Seleccione un tipo de cocina</option>
                                                @foreach(\App\Models\Tipocomida::all() as $tipo)
                                                    <option value="{{ $tipo->id }}" {{ $restaurante->tipocomida_id == $tipo->id ? 'selected' : '' }}>
                                                        {{ $tipo->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Imagen Actual</label>
                                            @if($restaurante->fotos && $restaurante->fotos->isNotEmpty())
                                                <img src="{{ asset($restaurante->fotos->first()->ruta_imagen) }}" 
                                                     class="img-thumbnail d-block mb-2" 
                                                     style="max-width: 200px">
                                            @endif
                                            <input type="file" class="form-control" name="imagen">
                                            <small class="text-muted">Deja en blanco para mantener la imagen actual</small>
                                        </div>
                                        <button type="submit" class="btn btn-outline-custom">Actualizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de Eliminación -->
                    <div class="modal fade" id="deleteRestauranteModal{{ $restaurante->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro que quieres eliminar el restaurante <strong>{{ $restaurante->nombre }}</strong>?</p>
                                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('restaurantes.delete', $restaurante->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>

        <!-- Modal de Creación -->
        <div class="modal fade" id="createRestauranteModal" tabindex="-1" aria-labelledby="createRestauranteModalLabel" aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRestauranteModalLabel">Añadir Restaurante</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('restaurantes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="nombre">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="direccion">Dirección</label>
                                <input type="text" class="form-control" id="direccion" name="dirección" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="precio_medio">Precio Medio</label>
                                <select class="form-control" id="precio_medio" name="precio_medio" required>
                                    <option value="$">$ (Económico)</option>
                                    <option value="$$">$$ (Moderado)</option>
                                    <option value="$$$">$$$ (Caro)</option>
                                    <option value="$$$$">$$$$ (Muy caro)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="descripcion">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="ciudad_id">Ciudad</label>
                                <select class="form-control" id="ciudad_id" name="ciudad_id" required>
                                    <option value="">Seleccione una ciudad</option>
                                    @foreach(\App\Models\Ciudad::all() as $ciudad)
                                        <option value="{{ $ciudad->id }}">{{ $ciudad->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tipocomida_id">Tipo de Cocina</label>
                                <select class="form-control" id="tipocomida_id" name="tipocomida_id" required>
                                    <option value="">Seleccione un tipo de cocina</option>
                                    @foreach(\App\Models\Tipocomida::all() as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="imagen">Imagen</label>
                                <input type="file" 
                                       class="form-control" 
                                       id="imagen" 
                                       name="imagen" 
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       required>
                                <small class="text-muted">Formatos permitidos: JPG, JPEG, PNG, GIF. Tamaño máximo: 2MB</small>
                            </div>
                            <div class="modal-footer px-0 pb-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-outline-custom">Crear</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('imagen').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB en bytes

        if (file) {
            if (!allowedTypes.includes(file.type)) {
                alert('Por favor, selecciona una imagen en formato JPG, JPEG, PNG o GIF');
                this.value = ''; // Limpia el input
                return;
            }

            if (file.size > maxSize) {
                alert('La imagen no debe pesar más de 2MB');
                this.value = ''; // Limpia el input
                return;
            }
        }
    });
    </script>

    <!-- Añade esto justo antes del cierre del body, después del script existente -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchNombre = document.getElementById('searchNombre');
        const filterCiudad = document.getElementById('filterCiudad');
        const filterTipoComida = document.getElementById('filterTipoComida');
        const filterPrecio = document.getElementById('filterPrecio');
        const limpiarFiltros = document.getElementById('limpiarFiltros');

        function filtrarRestaurantes() {
            const params = new URLSearchParams({
                nombre: searchNombre.value,
                ciudad: filterCiudad.value,
                tipo: filterTipoComida.value,
                precio: filterPrecio.value
            });

            fetch(`/filtrar-restaurantes?${params}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = '';
                    
                    data.forEach(rest => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${rest.id}</td>
                                <td>${rest.nombre}</td>
                                <td>${rest.precio_medio}</td>
                                <td>${rest.tipocomida ? rest.tipocomida.nombre : 'No especificado'}</td>
                                <td>${rest.ciudad ? rest.ciudad.nombre : 'No especificada'}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-custom" data-bs-toggle="modal" data-bs-target="#editRestauranteModal${rest.id}">
                                        Editar
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteRestauranteModal${rest.id}">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                });
        }

        // Event listeners
        searchNombre.addEventListener('input', filtrarRestaurantes);
        filterCiudad.addEventListener('change', filtrarRestaurantes);
        filterTipoComida.addEventListener('change', filtrarRestaurantes);
        filterPrecio.addEventListener('change', filtrarRestaurantes);

        limpiarFiltros.addEventListener('click', () => {
            searchNombre.value = '';
            filterCiudad.value = '';
            filterTipoComida.value = '';
            filterPrecio.value = '';
            filtrarRestaurantes();
        });
    });
    </script>
</body>
</html> 