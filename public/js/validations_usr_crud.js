// crear
function validarNombre(input) {
    let name = input.value.trim();
    let regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
    let errorSpan = document.getElementById("errorName");

    if (name === "") {
        errorSpan.textContent = "Este campo no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    } else if (name.length < 3 || !regex.test(name)) {
        errorSpan.textContent = "El nombre debe contener solo letras y tener más de 3 caracteres.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

function validarEmail(input) {
    let email = input.value.trim();
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let errorSpan = document.getElementById("errorEmail");

    if (email === "") {
        errorSpan.textContent = "Este campo no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    } else if (!regex.test(email)) {
        errorSpan.textContent = "Ingrese un correo electrónico válido.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

function validarPassword(input) {
    let password = input.value;
    let regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/;
    let errorSpan = document.getElementById("errorPassword");

    if (!regex.test(password)) {
        errorSpan.textContent = "La contraseña debe tener al menos 8 caracteres, incluir una letra y un número.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

function verificarFormulario() {
    const nombreValido = validarNombre(document.getElementById("name")); // Cambié "nombre" por "name"
    const emailValido = validarEmail(document.getElementById("email"));
    const passwordValido = validarPassword(document.getElementById("password"));

    const boton = document.getElementById("create_submit"); // Asegúrate de usar el ID correcto

    if (nombreValido && emailValido && passwordValido) {
        boton.disabled = false;
    } else {
        boton.disabled = true;
    }
}

// Asignar eventos a los campos
document.getElementById("name").addEventListener("blur", function () {
    validarNombre(this);
    verificarFormulario();
});

document.getElementById("email").addEventListener("blur", function () {
    validarEmail(this);
    verificarFormulario();
});

document.getElementById("password").addEventListener("blur", function () {
    validarPassword(this);
    verificarFormulario();
});


// Verificar el formulario al cargar la página (por si hay valores predefinidos)
verificarFormulario();


// ---------------------------------------------------------------------------------------
// edit
// Función para validar el nombre
function validarNombre2(input, userId) {
    let name = input.value.trim();
    let regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
    let errorSpan = document.getElementById("errorName2-" + userId);

    if (name === "") {
        errorSpan.textContent = "Este campo no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    } else if (name.length < 3 || !regex.test(name)) {
        errorSpan.textContent = "El nombre debe contener solo letras y tener más de 3 caracteres.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

// Función para validar el email
function validarEmail2(input, userId) {
    let email = input.value.trim();
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let errorSpan = document.getElementById("errorEmail2-" + userId);

    if (email === "") {
        errorSpan.textContent = "Este campo no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    } else if (!regex.test(email)) {
        errorSpan.textContent = "Ingrese un correo electrónico válido.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

// Función para validar la contraseña
function validarPassword2(input, userId) {
    let password = input.value.trim();
    let errorSpan = document.getElementById("errorPassword2-" + userId);

    if (password !== "" && password.length < 6) {
        errorSpan.textContent = "La contraseña debe tener al menos 6 caracteres.";
        input.classList.add("is-invalid");
        return false;
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
        return true;
    }
}

// Función para verificar el formulario completo
function verificarFormulario2(userId) {
    const nombreValido = validarNombre2(document.getElementById("name2-" + userId), userId);
    const emailValido = validarEmail2(document.getElementById("email2-" + userId), userId);
    const passwordValido = validarPassword2(document.getElementById("password2-" + userId), userId);

    const boton = document.getElementById("edit_submit-" + userId);

    if (nombreValido && emailValido && passwordValido) {
        boton.disabled = false;
    } else {
        boton.disabled = true;
    }
}

// Asignar eventos dinámicamente a los campos de cada modal
document.addEventListener("DOMContentLoaded", function () {
    // Obtener todos los modales de edición
    const modales = document.querySelectorAll('[id^="editUserModal"]');

    modales.forEach((modal) => {
        const userId = modal.id.replace("editUserModal", ""); // Extraer el ID del usuario

        // Asignar eventos a los campos del modal actual
        const nombreInput = document.getElementById("name2-" + userId);
        const emailInput = document.getElementById("email2-" + userId);
        const passwordInput = document.getElementById("password2-" + userId);

        if (nombreInput) {
            nombreInput.addEventListener("blur", function () {
                validarNombre2(this, userId);
                verificarFormulario2(userId);
            });
        }

        if (emailInput) {
            emailInput.addEventListener("blur", function () {
                validarEmail2(this, userId);
                verificarFormulario2(userId);
            });
        }

        if (passwordInput) {
            passwordInput.addEventListener("blur", function () {
                validarPassword2(this, userId);
                verificarFormulario2(userId);
            });
        }

        // Verificar el formulario al cargar el modal (por si hay valores predefinidos)
        verificarFormulario2(userId);
    });
});