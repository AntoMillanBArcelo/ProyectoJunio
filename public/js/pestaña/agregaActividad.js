document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
    var btnGuardarSimple = document.getElementById('g2');
    var btnGuardarCompuesta = document.getElementById('g1');
    var openModalButtons = document.querySelectorAll('.openPestañasModal');

    openModalButtons.forEach(function(openModalButton) {
        openModalButton.addEventListener('click', function() {
            var entityId = openModalButton.getAttribute('data-id');
            document.getElementById('idd').value = entityId;
            modal.show();
        });
    });

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

    var actividadSelect = document.getElementById('actividad-select');
    var tabLinks = document.querySelectorAll('.nav-link');

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

    var tituloContainer = document.getElementById('titulo-container');
    actividadSelect.addEventListener('change', function() {
        if (actividadSelect.value === 'simple') {
            tituloContainer.style.display = 'block';
        } else {
            tituloContainer.style.display = 'none';
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
        var btnGuardarSimple = document.getElementById('g2');
        var btnGuardarCompuesta = document.getElementById('g1');
        var openModalButtons = document.querySelectorAll('.openPestañasModal');
    
        openModalButtons.forEach(function(openModalButton) {
            openModalButton.addEventListener('click', function() {
                var entityId = openModalButton.getAttribute('data-id');
                document.getElementById('idd').value = entityId;
                modal.show();
            });
        });
    
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
    
        var actividadSelect = document.getElementById('actividad-select');
        var tabLinks = document.querySelectorAll('.nav-link');
    
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
    
        var tituloContainer = document.getElementById('titulo-container');
        actividadSelect.addEventListener('change', function() {
            if (actividadSelect.value === 'simple') {
                tituloContainer.style.display = 'block';
            } else {
                tituloContainer.style.display = 'none';
            }
        });
    
        document.getElementById('btnGuardarSimple').addEventListener('click', function(event) {
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
            })
            .catch(error => {
                console.error('Error al agregar la actividad simple:', error);
                alert(`Error al agregar la actividad simple: ${error.message || error}`);
            });
        }, { once: true });
    
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
    });
    
    
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
  
    btnGuardarSimple.addEventListener('click', function(event) {
        event.preventDefault();
    
        var descripcion = document.getElementById('descripcion').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var evento = parseInt(document.getElementById('evento').value);
        var aforo = parseInt(document.getElementById('aforo').value); 
        var idPadre = parseInt(document.getElementById('idd').value); 
        var titulo = document.getElementById('titulo').value;
    
        var espaciosSelect = document.getElementById('seleccionados');
        var espacios = [];
    
        for (var i = 0; i < espaciosSelect.options.length; i++) {
            if (espaciosSelect.options[i].selected) {
                espacios.push(parseInt(espaciosSelect.options[i].value));
            }
        }
    
        var actividadDataSimple = {
            descripcion: descripcion,
            fechaInicio: inicio,
            fechaFin: fin,
            evento: evento, 
            aforo: aforo, 
            id_padre: idPadre,
            espacios: espacios,
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
            location.reload(); 
        })
        .catch(error => {
            console.error('Error al agregar la actividad simple:', error);
            alert(`Error al agregar la actividad simple: ${error.message || error}`);
        });
    });
    
    
    
        //Borrar actividades
        document.querySelectorAll('button[id="btnDeleteActivity"]').forEach(button => {
            button.addEventListener('click', function () {
                const activityId = this.getAttribute('data-id');
                console.log(activityId);
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