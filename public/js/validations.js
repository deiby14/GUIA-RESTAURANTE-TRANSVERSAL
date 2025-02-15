document.addEventListener('DOMContentLoaded', function() {
    // Validación del formulario de login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        // Obtener los campos
        const username = document.getElementById('name');
        const password = document.getElementById('password');

        // Validar usuario al hacer click
        username.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'El nombre de usuario es obligatorio');
            } else {
                clearError(this);
            }
        });

        // Validar contraseña al hacer click
        password.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'La contraseña es obligatoria');
            } else {
                clearError(this);
            }
        });
    }

    // Validación del formulario de registro
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        // Obtener los campos
        const username = document.getElementById('name');
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const passwordConfirmation = document.getElementById('password_confirmation');

        // Validar usuario al hacer click
        username.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'El nombre de usuario es obligatorio');
            } else {
                clearError(this);
            }
        });

        // Validar email al hacer click
        email.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'El email es obligatorio');
            } else if (!validateEmail(this.value)) {
                showError(this, 'Por favor, introduce un email válido');
            } else {
                clearError(this);
            }
        });

        // Validar contraseña al hacer click
        password.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'La contraseña es obligatoria');
            } else if (this.value.length < 8) {
                showError(this, 'La contraseña debe tener al menos 8 caracteres');
            } else {
                clearError(this);
            }
        });

        // Validar confirmación de contraseña al hacer click
        passwordConfirmation.addEventListener('click', function() {
            if (!this.value.trim()) {
                showError(this, 'Debe confirmar la contraseña');
            } else if (this.value !== password.value) {
                showError(this, 'Las contraseñas no coinciden');
            } else {
                clearError(this);
            }
        });
    }
});

// Función para mostrar errores
function showError(input, message) {
    // Crear el div de error si no existe
    let errorDiv = input.parentElement.querySelector('.error-message');
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message text-danger mt-1';
        input.parentElement.appendChild(errorDiv);
    }
    
    // Mostrar el mensaje de error
    errorDiv.textContent = message;
    input.style.borderColor = '#dc3545';
}

// Función para limpiar error de un campo específico
function clearError(input) {
    const errorDiv = input.parentElement.querySelector('.error-message');
    if (errorDiv) {
        errorDiv.remove();
    }
    input.style.borderColor = '#ced4da';
}

// Función para validar email
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}
