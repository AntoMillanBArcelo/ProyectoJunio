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

    //Guardar actividades
    btnGuardarSimple.addEventListener('click', function(event) {
        event.preventDefault();

        var descripcion = document.getElementById('descripcion').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var evento = parseInt(document.getElementById('evento').value);
        console.log(evento);
        var aforo = parseInt(document.getElementById('aforo').value);
        var idPadre = parseInt(document.getElementById('idd').value);
        var titulo = document.getElementById('titulo').value;
        var espaciosSelect = document.getElementById('seleccionados');
        var espacios = Array.from(espaciosSelect.options)
            .filter(option => option.selected)
            .map(option => parseInt(option.value));
        var gruposSeleccionados = Array.from(document.querySelectorAll('input[name="grupo"]:checked'))
            .map(checkbox => parseInt(checkbox.value));
            
            const ponentes = [
                {
                    nombre: document.getElementById('nombre').value,
                    cargo: document.getElementById('cargo').value,
                    recurso: document.getElementById('recurso').value
                }
            ];
            console.log(ponentes)
        var actividadDataSimple = {
            descripcion: descripcion,
            fechaInicio: inicio,
            fechaFin: fin,
            evento: evento,
            aforo: aforo,
            id_padre: idPadre,
            espacios: espacios,
            ponentes: ponentes,
            grupos: gruposSeleccionados,
            titulo: titulo,
        };

        fetch('/API/subactividades/simple', {
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
            console.log('Actividad simple agregada exitosamente:', data);
            guardarPonente();
            location.reload(); 
        })
        .catch(error => {
            console.error('Error al agregar la actividad simple:', error);
            alert(`Error al agregar la actividad simple: ${error.message || error}`);
        });
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
    
});
