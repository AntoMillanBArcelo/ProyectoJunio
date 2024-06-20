document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
    var btnGuardarSimple = document.getElementById('g2');
    var btnGuardarCompuesta = document.getElementById('g1');
    var openModalButtons = document.querySelectorAll('.openPestañasModal');
    var actividadSelect = document.getElementById('actividad-select');
    var tituloContainer = document.getElementById('titulo-container');
    var tabLinks = document.querySelectorAll('.nav-link');
    var pestañasModal = new bootstrap.Modal(document.getElementById('pestañasModal')); 

    openModalButtons.forEach(function(openModalButton) {
        openModalButton.addEventListener('click', function() {
            var entityId = openModalButton.getAttribute('data-id');
            document.getElementById('idd').value = entityId;
            pestañasModal.show();  
        });
    });
    

    // Cambiar de pestaña al hacer clic en las pestanas
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function(event) {
            event.preventDefault();
            var target = document.querySelector(tab.getAttribute('href'));
            var allContent = document.querySelectorAll('.tab-pane');
            allContent.forEach(function(content) {
                content.classList.remove('show', 'active');
            });
            target.classList.add('show', 'active');
        });
    });

    // Aparece el input del titulo si la actiidad es simple
    actividadSelect.addEventListener('change', function() {
        if (actividadSelect.value === 'simple') {
            tituloContainer.style.display = 'block';
        } else {
            tituloContainer.style.display = 'none';
        }
    });

    // Deshabilitar enlaces de pestañas si se selecciona actividad es compuesta
    actividadSelect.addEventListener('change', function() {
        if (actividadSelect.value === 'compuesta') {
            tabLinks.forEach(function(link, index) {
                if (index > 0) {
                    link.classList.add('disabled');
                }
            });
            btnGuardarSimple.disabled = true;
        } else {
            tabLinks.forEach(function(link) {
                link.classList.remove('disabled');
            });
            btnGuardarSimple.disabled = false;
        }
    });
    
        //Guardar actividades compuestas
        btnGuardarCompuesta.addEventListener('click', function(event) {
            event.preventDefault();

            var descripcion = document.getElementById('descripcion').value;
            var inicio = document.getElementById('inicio').value;
            var fin = document.getElementById('fin').value;
            var evento = parseInt(document.getElementById('evento').value);

            var actividadDataSimple = {
                descripcion: descripcion,
                fechaInicio: inicio,
                fechaFin: fin,
                evento: evento,
            };

            fetch('/API/actividades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(actividadDataSimple)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                console.log('Actividad agregada exitosamente:', data);
            })
            .then(() => {
                location.reload(); 
            })
            .catch(error => {
                console.error('Error al agregar la actividad:', error);
                alert(`Error al agregar la actividad: ${error.message || error}`);
            });
        });

    //Guardar actividades simples
    btnGuardarSimple.addEventListener('click', function(event) {
        event.preventDefault();
    
        var descripcion = document.getElementById('descripcion').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var evento = parseInt(document.getElementById('evento').value);
        var aforo = parseInt(document.getElementById('aforo').value);
        var idPadre = document.getElementById('idd').value; 
        var titulo = document.getElementById('titulo').value;
        var espaciosSelect = document.getElementById('seleccionados');
        
        var espacios = Array.from(espaciosSelect.options)
            .filter(option => option.selected)
            .map(option => parseInt(option.value));
    
        const ponentes = [
            {
                nombre: document.getElementById('nombre').value,
                cargo: document.getElementById('cargo').value,
                recurso: document.getElementById('recurso').value
            }
        ];
    
        // Funcion para crear actividad padre
        function crearActividadPadre() {
            return fetch('API/actividades', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    descripcion: descripcion,
                    fechaInicio: inicio,
                    fechaFin: fin,
                    evento: evento
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            });
        }
    
        // Funcion para crear detalleActividad con id del padre
        function crearDetalleActividad(idPadre) {
            var actividadDataSimple = {
                descripcion: descripcion,
                fechaInicio: inicio,
                fechaFin: fin,
                evento: evento,
                aforo: aforo,
                id_padre: idPadre,
                espacios: espacios,
                ponentes: ponentes,
                titulo: titulo
            };
    
            return fetch('/API/subactividades/simple', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(actividadDataSimple)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            });
        }
    
        //Comprobar si idPAdre viene null o no, si viene null llamo a la funcion para crear actividad padre y
        //luego crear detalleActividad, si viene idPAdre con algun valor crea detalleActividad pasandole esa id :)
        if (!idPadre || isNaN(idPadre)) {
            crearActividadPadre()
            .then(data => {
                console.log('Actividad padre creada exitosamente:', data);
                return crearDetalleActividad(data.id);
            })
            .then(data => {
                console.log('Detalle de actividad creado exitosamente:', data);
                guardarPonente();
                asociarEventoConActividad(evento, data.id);
                location.reload(); 
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`Error: ${error.message || error}`);
            });
        } else {
            crearDetalleActividad(parseInt(idPadre))
            .then(data => {
                console.log('Detalle de actividad creado exitosamente:', data);
                guardarPonente();
                asociarEventoConActividad(evento, data.id);
                location.reload(); 
            })
            .catch(error => {
                console.error('Error:', error);
                alert(`Error: ${error.message || error}`);
            });
        }
    });
    

    // Borrar actividad
    document.querySelectorAll('button[id="btnDeleteActivity"]').forEach(button => {
        button.addEventListener('click', function () {
            const activityId = this.getAttribute('data-id');

            fetch(`/API/actividades/${activityId}`, {
                method: 'DELETE'
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al borrar la actividad');
                }
                return response.json();
            })
            .then(data => {
                const row = this.closest('tr');
                row.parentNode.removeChild(row); 
                console.log(data.message);
            })
            .catch(error => {
                console.error(error.message);
            });
        });
    });

    function guardarPonente() {
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
            evento_id: null
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
    
            const mostrarPonentes = document.getElementById('ponentesAgregados');
            const ponenteElement = document.createElement('div');
            ponenteElement.textContent = `Nombre: ${data.nombre}, Cargo: ${data.cargo}, Recurso: ${data.url}`;
            mostrarPonentes.appendChild(ponenteElement);
    
            document.getElementById('nombre').value = '';
            document.getElementById('cargo').value = '';
            document.getElementById('recurso').value = '';
        })
        .catch(error => {
            alert('Error al guardar el ponente: ' + error.message);
            console.error('Error:', error);
        });
    }

   // Función para guardar grupos
    /* function guardarGruposYActividad(actividadId, gruposSeleccionados) {
        const data = {
            actividadId: actividadId,
            grupos: gruposSeleccionados
        };

        return fetch('/API/detalle_actividad_grupo', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            console.log('Grupos relacionados con la actividad:', data);
        })
        .catch(error => {
            console.error('Error al guardar los grupos en detalle_actividad_grupo:', error);
            alert('Error al guardar los grupos en detalle_actividad_grupo: ' + error.message);
            throw error;
        });
    } */

    function asociarEventoConActividad(eventoId, actividadId) {
        const data = {
            eventoId: eventoId,
            detalleActividadId: actividadId
        };
    
        return fetch(`/API/asociar_evento_detalle_actividad/${actividadId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            console.log('Evento asociado correctamente:', data);
            return data;
        })
        .catch(error => {
            console.error('Error al asociar evento con la actividad:', error);
            throw error;
        });
    }
    

});
