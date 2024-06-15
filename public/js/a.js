document.addEventListener('DOMContentLoaded', function() {
    var openModalButtons = document.querySelectorAll('.openPestañasModal');
    const btnEditActivitys = document.querySelectorAll('.btnEditActivity');
    const editarActividadModal = new bootstrap.Modal(document.getElementById('editarActividadModal'));

    btnEditActivitys.forEach(function(btnEditActivity) {
        btnEditActivity.addEventListener('click', function() {
            const actividadId = btnEditActivity.getAttribute('data-id');
            obtenerDatosActividad(actividadId)
                .then(datosActividad => {
                    document.getElementById('descripcion').value = datosActividad.descripcion;
                    document.getElementById('fechaHoraIni').value = datosActividad.fechaHoraIni;
                    document.getElementById('fechaHoraFin').value = datosActividad.fechaHoraFin;
                    document.getElementById('evento').value = datosActividad.evento;
                    document.getElementById('actividadId').value = actividadId;
                    editarActividadModal.show();
                })
                .catch(error => {
                    console.error('Error al obtener los datos de la actividad:', error);
                });
        });
    });

    document.getElementById('guardarCambios').addEventListener('click', function(event) {
        event.preventDefault();

        const actividadId = document.getElementById('actividadId').value;
        const descripcion = document.getElementById('descripcion').value;
        const fechaHoraIni = document.getElementById('fechaHoraIni').value;
        const fechaHoraFin = document.getElementById('fechaHoraFin').value;
        const evento = document.getElementById('evento').value;

        const actividadData = {
            descripcion: descripcion,
            fechaInicio: fechaHoraIni,
            fechaFin: fechaHoraFin,
            evento: evento
        };

        fetch(`/API/actividades/${actividadId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(actividadData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al actualizar la actividad');
            }
            return response.json();
        })
        .then(response => {
            alert('Actividad actualizada exitosamente');
            editarActividadModal.hide();
            location.reload();
        })
        .catch(error => {
            console.error('Error al actualizar la actividad:', error);
            alert(`Error al actualizar la actividad: ${error.message || error}`);
        });
    });

    function obtenerDatosActividad(id) {
        return fetch(`/API/actividades/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al obtener los datos de la actividad');
                }
                return response.json();
            })
            .catch(error => {
                console.error('Error al obtener los datos de la actividad:', error);
                throw error; 
            });
    }

    var modalElement = document.getElementById('pestañasModal');
    if (modalElement) {
        var modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });

        openModalButtons.forEach(function(openModalButton) {
            openModalButton.addEventListener('click', function() {
                modal.show();
            });
        });
    } else {
        console.error('El elemento con ID "pestañasModal" no se encontró.');
    }

    var buttons = document.querySelectorAll('.btnPestaña');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            var iframeContainer = document.getElementById('iframeContainer2');
            if (iframeContainer) {
                iframeContainer.style.display = 'block';
                document.querySelectorAll('.card.w-75').forEach(function(card) {
                    card.style.display = 'none';
                });
            } else {
                console.error('El elemento con ID "iframeContainer2" no se encontró.');
            }
        });
    });
});
