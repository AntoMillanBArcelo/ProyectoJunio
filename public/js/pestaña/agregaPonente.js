document.addEventListener('DOMContentLoaded', function() 
{
    const eventoSelect = document.getElementById('evento');

    document.getElementById('guardarPonente').addEventListener('click', function() {
        const eventoId = eventoSelect.value;
        const nombre = document.getElementById('nombre').value;
        const cargo = document.getElementById('cargo').value;
        const recurso = document.getElementById('recurso').value;

        if (!nombre || !cargo || !recurso) {
            alert('Por favor complete todos los campos requeridos.');
            return;
        }

        const data = {
            nombre: nombre,
            cargo: cargo,
            url: recurso,
            evento_id: eventoId ? eventoId : null // Permitir que evento_id sea nulo
        };
      
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
