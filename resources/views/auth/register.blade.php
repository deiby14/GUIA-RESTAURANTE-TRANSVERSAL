<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Guía de Restaurantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 50px auto;
        }
        .login-form {
            background: white;
            padding: 30px;
            border: 2px solid #dc3545;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(220,53,69,0.1);
        }
        .btn-outline-custom {
            color: #dc3545;
            border: 2px solid #dc3545;
            transition: all 0.3s ease;
        }
        .btn-outline-custom:hover {
            color: white;
            background-color: #dc3545;
        }
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="login-form">
            <h2 class="text-center mb-4">Registro</h2>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nombre de Usuario</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" >
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" >
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" >
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-custom">Registrarse</button>
                </div>

                <div class="text-center mt-3">
                    <a href="{{ route('login') }}" class="text-decoration-none text-danger">¿Ya tienes cuenta? Inicia Sesión</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/validations.js') }}"></script>
</body>
</html>