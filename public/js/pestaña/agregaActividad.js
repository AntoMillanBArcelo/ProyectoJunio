document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
    var btnGuardarSimple = document.getElementById('g1');

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

    // Control tabs accessibility based on select input
    var actividadSelect = document.getElementById('actividad-select');
    var tabLinks = document.querySelectorAll('.nav-link');

    actividadSelect.addEventListener('change', function() {
        if (actividadSelect.value === 'compuesta') {
            tabLinks.forEach(function(link, index) {
                if (index > 0) { // Disable tabs 2, 3, and 4
                    link.classList.add('disabled');
                }
            });
        } else {
            tabLinks.forEach(function(link) {
                link.classList.remove('disabled');
            });
        }
    });

    // Escuchar el evento change en el selector de tipo de actividad
    actividadSelect.addEventListener('change', function() {
        // Si la opción seleccionada es "simple"
        if (actividadSelect.value === 'simple') {
            // Deshabilitar el botón de guardar
            btnGuardarSimple.disabled = true;
        } else {
            // Habilitar el botón de guardar en otros casos
            btnGuardarSimple.disabled = false;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        var btnGuardarSimple = document.getElementById('g1');
    
        btnGuardarSimple.addEventListener('click', function(event) {
            event.preventDefault();
    
            var id = document.getElementById('id').value;
            var aforo = document.getElementById('aforo').value;
            var inicio = document.getElementById('inicio').value;
            var fin = document.getElementById('fin').value;
            var descripcion = document.getElementById('descripcion').value;
            var evento = document.getElementById('evento').value;
    
            var actividadDataCompuesta = {
                tipo: 2, // Cambia 'compuesta' a 2 según la lógica del backend
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
                console.log('Actividad agregada exitosamente:', data);
            })
            .catch(error => {
                console.error('Error al agregar la actividad:', error);
                alert(`Error al agregar la actividad: ${error.message || error}`);
            });
        });
    });
    
    
    // Inicializar el estado según la selección predeterminada
    actividadSelect.dispatchEvent(new Event('change'));
});
