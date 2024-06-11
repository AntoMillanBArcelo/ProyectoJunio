//agregaPonente.js
document.addEventListener('DOMContentLoaded', function() 
{
    const eventoSelect = document.getElementById('evento');

    // Manejar el clic en el botón "Guardar"
    document.getElementById('guardarPonente').addEventListener('click', function() {
        // Obtener valores del formulario
        const eventoId = eventoSelect.value;
        const nombre = document.getElementById('nombre').value;
        const cargo = document.getElementById('cargo').value;
        const recurso = document.getElementById('recurso').value;

        // Verificar que los datos requeridos están presentes
        if (!eventoId || !nombre || !cargo || !recurso) {
            alert('Por favor complete todos los campos requeridos.');
            return;
        }

        // Crear el objeto de datos para enviar a la API
        const data = {
            nombre: nombre,
            cargo: cargo,
            url: recurso,
            evento_id: eventoId
        };

        // Enviar los datos a la API usando Fetch
        fetch('/API/ponentes', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                return response.json().then(error => {
                    throw new Error(error.message);
                });
            }
        })
        .then(data => {
            alert('Ponente guardado correctamente.');
            console.log('Ponente guardado:', data);
        })
        .catch(error => {
            alert('Error al guardar el ponente: ' + error.message);
            console.error('Error:', error);
        });
    });
});
