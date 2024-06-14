document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
    var btnGuardarSimple = document.getElementById('g2');
    var btnGuardarCompuesta = document.getElementById('g1');
    var openModalButtons = document.querySelectorAll('.openPestañasModal');
    var actividadSelect = document.getElementById('actividad-select');
    var tabLinks = document.querySelectorAll('.nav-link');
    var tituloContainer = document.getElementById('titulo-container');
    var fuenteSelect = document.getElementById('fuente');
    var seleccionadosSelect = document.getElementById('seleccionados');

    // Función para construir la URL con los parámetros de recursos
    function buildURLWithParams(baseURL, params) {
        const url = new URL(baseURL);
        Object.keys(params).forEach(key => url.searchParams.append(key, params[key]));
        return url;
    }

    // Obteniendo las salas según los recursos seleccionados
    function fetchSalas() {
        const recursoIds = Array.from(seleccionadosSelect.options).map(option => option.value);
        if (recursoIds.length > 0) {
            const params = { recursos: recursoIds.join(',') };
            const url = buildURLWithParams('/API/salas', params);
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Salas:', data);
                })
                .catch(error => {
                    console.error('Error fetching salas:', error);
                });

        } else {
            console.warn('No se han seleccionado recursos');
        }
    }

    // Llama a fetchSalas cuando sea necesario, por ejemplo, al hacer doble clic en una opción
    fuenteSelect.addEventListener('dblclick', fetchSalas);
    seleccionadosSelect.addEventListener('dblclick', fetchSalas);


    // Modal button event listeners
    openModalButtons.forEach(function(openModalButton) {
        openModalButton.addEventListener('click', function() {
            var entityId = openModalButton.getAttribute('data-id');
            document.getElementById('idd').value = entityId;
            modal.show();
        });
    });

    // Tabs event listeners
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

    // Actividad select change event listener
    actividadSelect.addEventListener('change', function() {
        var isCompuesta = actividadSelect.value === 'compuesta';
        tabLinks.forEach(function(link, index) {
            if (index > 0) {
                link.classList.toggle('disabled', isCompuesta);
            }
        });
        btnGuardarSimple.disabled = isCompuesta;
        tituloContainer.style.display = actividadSelect.value === 'simple' ? 'block' : 'none';
    });

    // Save simple activity
    btnGuardarSimple.addEventListener('click', function(event) {
        event.preventDefault();

        var descripcion = document.getElementById('descripcion').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var evento = document.getElementById('evento').value;
        var aforo = document.getElementById('aforo').value;
        var idPadre = document.getElementById('idd').value;
        var titulo = document.getElementById('titulo').value;

        var recursos = Array.from(document.getElementById('seleccionados').options).map(option => option.value);
        var grupos = Array.from(document.getElementById('grupos-select').options).map(option => option.value);

        var actividadDataSimple = {
            descripcion: descripcion,
            fechaInicio: inicio,
            fechaFin: fin,
            evento: evento,
            aforo: aforo,
            id_padre: parseInt(idPadre, 10),
            recursos: recursos,
            grupos: grupos,
            titulo: titulo,
        };

        fetch('/API/actividades/simple', {
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
            insertActivityInTable(data);
            location.reload(); // Refresh the page after successful activity save
        })
        .catch(error => {
            console.error('Error al agregar la actividad simple:', error);
            alert(`Error al agregar la actividad simple: ${error.message || error}`);
        });
    }, { once: true });

    // Insert new activity in the table
    function insertActivityInTable(activity) {
        var tableContainer = document.querySelector(`table[data-id="${activity.id_padre}"] tbody`);
        if (tableContainer) {
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>${activity.descripcion}</td>
                <td>${activity.fechaInicio}</td>
                <td>${activity.fechaFin}</td>
                <td>${activity.evento.nombre}</td>
                <td>
                    <button class="btn btn-primary openPestañasModal" data-id="${activity.id}">Añadir Actividad</button>
                    <button type="button" class="btn btn-primary btnPestaña" data-id="${activity.id}" id="btnEditActivity">Editar Actividad</button>
                    <button type="button" class="btn btn-danger" data-id="${activity.id}" id="btnDeleteActivity">Borrar Actividad</button>
                </td>
            `;
            tableContainer.appendChild(newRow);
        } else {
            console.error('No se encontró la tabla para la id_padre proporcionada');
        }
    }

    // Delete activity
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
});
