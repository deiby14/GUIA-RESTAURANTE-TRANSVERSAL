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

    if (password === "") {
        errorSpan.textContent = "Este campo no puede estar vacío.";
        input.classList.add("is-invalid");
        return false;
    } else if (!regex.test(password)) {
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
    const nombreValido = validarNombre(document.getElementById("nombre"));
    const emailValido = validarEmail(document.getElementById("email"));
    const passwordValido = validarPassword(document.getElementById("password"));

    const boton = document.getElementById("create_submit");

    if (nombreValido && emailValido && passwordValido) {
        boton.disabled = false;
    } else {
        boton.disabled = true;
    }
}

// Asignar eventos a los campos de entrada
document.getElementById("nombre").addEventListener("input", function () {
    validarNombre(this);
    verificarFormulario();
});

document.getElementById("email").addEventListener("input", function () {
    validarEmail(this);
    verificarFormulario();
});

document.getElementById("password").addEventListener("input", function () {
    validarPassword(this);
    verificarFormulario();
});



// edit
function validarNombre2(input) {
    let name = input.value.trim();
    let regex = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;
    let errorSpan = document.getElementById("errorName2");

    if (name.length < 3 || !regex.test(name)) {
        errorSpan.textContent = "El nombre debe contener solo letras y tener más de 3 caracteres.";
        input.classList.add("is-invalid");
    } else if (name=""){
        errorSpan.textContent = "Este campo no puede estar vacio";
        input.classList.add("is-invalid");
    }
    else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
    }
}

function validarEmail2(input) {
    let email = input.value.trim();
    let regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let errorSpan = document.getElementById("errorEmail2");

    if (!regex.test(email)) {
        errorSpan.textContent = "Ingrese un correo electrónico válido.";
        input.classList.add("is-invalid");
    }else if (email=""){
        errorSpan.textContent = "Este campo no puede estar vacio";
        input.classList.add("is-invalid");
    } else {
        errorSpan.textContent = "";
        input.classList.remove("is-invalid");
    }
}

function validarPassword2(input) {
    let password = input.value;
    let regex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Expresión regular para validar al menos 8 caracteres, una letra y un número.
    let errorSpan = document.getElementById("errorPassword2");

    // Si el campo está vacío, no aplicamos la validación y no mostramos ningún error
    if (password.trim() === "") {
        errorSpan.textContent = ""; // Limpiar cualquier error previo
        input.classList.remove("is-invalid"); // Remover el estado de error
        return;
    }

    // Si el campo no está vacío, validamos la contraseña con la expresión regular
    if (!regex.test(password)) {
        errorSpan.textContent = "La contraseña debe tener al menos 8 caracteres, incluir una letra y un número.";
        input.classList.add("is-invalid"); // Añadir clase de error
    } else {
        errorSpan.textContent = ""; // Limpiar el mensaje de error
        input.classList.remove("is-invalid"); // Remover clase de error
    }
}


