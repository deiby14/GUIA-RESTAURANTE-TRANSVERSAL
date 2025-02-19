// Funciones de validación para crear restaurante
function validarNombreRestaurante(input) {
    let nombre = input.value.trim();
    let errorSpan = document.getElementById("errorNombre");
    
    if (nombre === "" || nombre.length < 3) {
        errorSpan.textContent = "El nombre debe tener al menos 3 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function validarDireccion(input) {
    let direccion = input.value.trim();
    let errorSpan = document.getElementById("errorDireccion");
    
    if (direccion === "" || direccion.length < 5) {
        errorSpan.textContent = "La dirección debe tener al menos 5 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function validarDescripcion(input) {
    let descripcion = input.value.trim();
    let errorSpan = document.getElementById("errorDescripcion");
    
    if (descripcion === "" || descripcion.length < 10) {
        errorSpan.textContent = "La descripción debe tener al menos 10 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function verificarFormularioRestaurante() {
    const nombreInput = document.getElementById("nombre");
    const direccionInput = document.getElementById("direccion");
    const descripcionInput = document.getElementById("descripcion");
    const ciudadSelect = document.getElementById("ciudad_id");
    const tipoComidaSelect = document.getElementById("tipocomida_id");
    
    const nombreValido = validarNombreRestaurante(nombreInput);
    const direccionValida = validarDireccion(direccionInput);
    const descripcionValida = validarDescripcion(descripcionInput);
    const selectsValidos = ciudadSelect.value !== "" && tipoComidaSelect.value !== "";

    const submitButton = document.querySelector("#createRestauranteModal button[type='submit']");
    submitButton.disabled = !(nombreValido && direccionValida && descripcionValida && selectsValidos);
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    const inputs = ['nombre', 'direccion', 'descripcion'];
    inputs.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('input', function() {
                switch(id) {
                    case 'nombre':
                        validarNombreRestaurante(this);
                        break;
                    case 'direccion':
                        validarDireccion(this);
                        break;
                    case 'descripcion':
                        validarDescripcion(this);
                        break;
                }
                verificarFormularioRestaurante();
            });
        }
    });

    ['ciudad_id', 'tipocomida_id'].forEach(id => {
        const select = document.getElementById(id);
        if (select) {
            select.addEventListener('change', verificarFormularioRestaurante);
        }
    });

    // Deshabilitar el botón al cargar
    const submitButton = document.querySelector("#createRestauranteModal button[type='submit']");
    if (submitButton) {
        submitButton.disabled = true;
    }

    // Configurar validaciones para formularios de edición
    const modalesEdicion = document.querySelectorAll('[id^="editRestauranteModal"]');
    
    modalesEdicion.forEach(modal => {
        const restauranteId = modal.id.replace('editRestauranteModal', '');
        
        const inputs = [
            {id: `nombre-${restauranteId}`, validacion: validarNombreRestauranteEdit},
            {id: `direccion-${restauranteId}`, validacion: validarDireccionEdit},
            {id: `descripcion-${restauranteId}`, validacion: validarDescripcionEdit}
        ];

        inputs.forEach(({id, validacion}) => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', function() {
                    validacion(this, restauranteId);
                    verificarFormularioRestauranteEdit(restauranteId);
                });
            }
        });

        [`ciudad_id-${restauranteId}`, `tipocomida_id-${restauranteId}`].forEach(id => {
            const select = document.getElementById(id);
            if (select) {
                select.addEventListener('change', () => verificarFormularioRestauranteEdit(restauranteId));
            }
        });

        // Deshabilitar el botón al cargar
        const submitButton = modal.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
        }
    });
});

// Funciones de validación para editar restaurante
function validarNombreRestauranteEdit(input, restauranteId) {
    let nombre = input.value.trim();
    let errorSpan = document.getElementById(`errorNombre-${restauranteId}`);
    
    if (nombre === "" || nombre.length < 3) {
        errorSpan.textContent = "El nombre debe tener al menos 3 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function validarDireccionEdit(input, restauranteId) {
    let direccion = input.value.trim();
    let errorSpan = document.getElementById(`errorDireccion-${restauranteId}`);
    
    if (direccion === "" || direccion.length < 5) {
        errorSpan.textContent = "La dirección debe tener al menos 5 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function validarDescripcionEdit(input, restauranteId) {
    let descripcion = input.value.trim();
    let errorSpan = document.getElementById(`errorDescripcion-${restauranteId}`);
    
    if (descripcion === "" || descripcion.length < 10) {
        errorSpan.textContent = "La descripción debe tener al menos 10 caracteres";
        input.classList.add("is-invalid");
        return false;
    }
    errorSpan.textContent = "";
    input.classList.remove("is-invalid");
    return true;
}

function verificarFormularioRestauranteEdit(restauranteId) {
    const nombreInput = document.getElementById(`nombre-${restauranteId}`);
    const direccionInput = document.getElementById(`direccion-${restauranteId}`);
    const descripcionInput = document.getElementById(`descripcion-${restauranteId}`);
    const ciudadSelect = document.getElementById(`ciudad_id-${restauranteId}`);
    const tipoComidaSelect = document.getElementById(`tipocomida_id-${restauranteId}`);
    
    const nombreValido = validarNombreRestauranteEdit(nombreInput, restauranteId);
    const direccionValida = validarDireccionEdit(direccionInput, restauranteId);
    const descripcionValida = validarDescripcionEdit(descripcionInput, restauranteId);
    const selectsValidos = ciudadSelect.value !== "" && tipoComidaSelect.value !== "";

    const submitButton = document.querySelector(`#editRestauranteModal${restauranteId} button[type='submit']`);
    submitButton.disabled = !(nombreValido && direccionValida && descripcionValida && selectsValidos);
}