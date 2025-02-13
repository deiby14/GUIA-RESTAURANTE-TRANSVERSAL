<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Iniciar Sesión</h2>
        <form method="POST" action="{{ route('login') }}" novalidate> 
            @csrf

            <!-- Campo de Correo Electrónico -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="correo@gmail.com" value="{{ old('email') }}">
                <!-- Mostrar error debajo del campo -->
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Campo de Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Introduce su contraseña">
                <!-- Mostrar error debajo del campo -->
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Botón de Envío -->
            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
            <a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a>

        </form>
       
    </div>

</body>
</html>