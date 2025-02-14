<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registro</h2>
        <form method="POST" action="{{ route('register') }}" novalidate> 
            @csrf

            <!-- Campo de Nombre -->
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Tu nombre" value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de Correo Electrónico -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="correo@gmail.com" value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Introduce tu contraseña">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de Confirmación de Contraseña -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirma tu contraseña">
            </div>

            <!-- Botón de Envío -->
            <button type="submit" class="btn btn-primary">Registrarse</button>
        </form>
        <a href="{{ route('login') }}" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
    </div>
</body>
</html>