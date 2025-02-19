<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrar Usuarios</title>
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

        /* mensajes de error */
        .error {
        color: red;
        font-size: 14px;
        display: block; /* Hace que el mensaje aparezca en una nueva línea */
        margin-top: 5px; /* Espaciado para que no quede pegado al input */
        }
        .is-invalid {
            border: 1px solid red; /* Resalta el campo con un borde rojo */
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
                            <a href="{{ route('administrar.restaurantes') }}" class="btn btn-hover-grey" style="margin-right: 10px;">Restaurantes</a>
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
            <h2>Administrar Usuarios</h2>
            <button type="button" class="btn btn-outline-custom" data-bs-toggle="modal" data-bs-target="#createUserModal">
                Añadir Usuario
            </button>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role?->name ?? 'Sin rol' }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-custom" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                Eliminar
                            </button>
                        </td>
                    </tr>

                    <!-- Modal de Edición para cada usuario -->
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Editar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="form-label">Nombre</label>
                                            <input type="text" class="form-control" name="name" id="name2-{{ $user->id }}" onblur="validarNombre2(this, '{{ $user->id }}')" value="{{ $user->name }}">
                                            <span class="error" id="errorName2-{{ $user->id }}"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="text" class="form-control" name="email" id="email2-{{ $user->id }}" onblur="validarEmail2(this, '{{ $user->id }}')" value="{{ $user->email }}">
                                            <span class="error" id="errorEmail2-{{ $user->id }}"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contraseña (dejar en blanco para mantener la actual)</label>
                                            <input type="password" class="form-control" name="password" id="password2-{{ $user->id }}" onblur="validarPassword2(this, '{{ $user->id }}')">
                                            <span class="error" id="errorPassword2-{{ $user->id }}"></span>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Rol</label>
                                            <select class="form-control" name="rol_id">
                                                @foreach($roles as $rol)
                                                    <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                                                        {{ $rol->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-outline-custom" id="edit_submit-{{ $user->id }}">Actualizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal de Eliminación -->
                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Confirmar Eliminación</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>¿Estás seguro que quieres eliminar al usuario <strong>{{ $user->name }}</strong>?</p>
                                    <p class="text-danger">Esta acción no se puede deshacer.</p>
                                    
                                    @if(session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <form action="{{ route('users.delete', $user->id) }}" 
                                          method="POST" 
                                          style="display: inline;">
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
        <div class="modal fade" id="createUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Añadir Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" name="name" id="name" onblur="validarNombre(this)">
                                <span class="error" id="errorName"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="text" class="form-control" name="email" id="email" onblur="validarEmail(this)">
                                <span class="error" id="errorEmail"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" onblur="validarPassword(this)">
                                <span class="error" id="errorPassword"></span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Rol</label>
                                <select class="form-control" name="rol_id" id="rol">
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-outline-custom" id="create_submit" >Crear</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de cerrar sesión -->
        <form action="{{ route('logout') }}" method="POST" class="mt-4">
            @csrf
            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
        </form>
    </div>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    {{-- JS --}}
    <script src="{{ asset('js/validations_usr_crud.js') }}"></script>
</body>
</html> 