//agregaActividad.js
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


    //Esto bloquea la navegacion de pestana si es compuesto
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

   
        var actividadSelect = document.getElementById('actividad-select');
        var tituloContainer = document.getElementById('titulo-container');
    
        actividadSelect.addEventListener('change', function() {
            if (actividadSelect.value === 'simple') {
                tituloContainer.style.display = 'block';
            } else {
                tituloContainer.style.display = 'none';
            }
        });
  
    
    btnGuardarCompuesta.addEventListener('click', function(event) {
        event.preventDefault();

        var id = document.getElementById('idd').value;
        var aforo = document.getElementById('aforo').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var descripcion = document.getElementById('descripcion').value;
        var evento = document.getElementById('evento').value;

        var actividadDataCompuesta = {
            tipo: 2,
            id: id,
            aforo: aforo,
            fechaInicio: inicio,
            fechaFin: fin,
            descripcion: descripcion,
            evento: evento
        };

        fetch('/API/actividades', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(actividadDataCompuesta)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            console.log('Actividad compuesta agregada exitosamente:', data);
        })
        .catch(error => {
            console.error('Error al agregar la actividad compuesta:', error);
            alert(`Error al agregar la actividad compuesta: ${error.message || error}`);
        });
    });

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
            id_padre: parseInt(idPadre, 10), // Convertir id_padre a entero
            recursos: recursos,
            grupos: grupos,
            titulo: titulo 
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
        })
        .catch(error => {
            console.error('Error al agregar la actividad simple:', error);
            alert(`Error al agregar la actividad simple: ${error.message || error}`);
        });
    });
    
});