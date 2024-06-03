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

    // Escuchar el evento click en el botón de guardar
    btnGuardarSimple.addEventListener('click', function() {
        // Obtener los valores de los campos del formulario
        var id = document.getElementById('id').value;
        var aforo = document.getElementById('aforo').value;
        var inicio = document.getElementById('inicio').value;
        var fin = document.getElementById('fin').value;
        var descripcion = document.getElementById('descripcion').value;
        var evento = document.getElementById('evento').value;
        // Obtener los valores del ponente
        var nombrePonente = document.getElementById('nombre').value;
        var cargoPonente = document.getElementById('cargo').value;
        var urlPonente = document.getElementById('url').value;

        // Construir el objeto con los datos del ponente
        var ponenteData = {
            nombre: nombrePonente,
            cargo: cargoPonente,
            url: urlPonente
        };

        // Construir el objeto con los datos de la actividad
        var actividadData = {
            tipo: 'simple',
            id: id,
            aforo: aforo,
            fechaInicio: inicio,
            fechaFin: fin,
            descripcion: descripcion,
            evento: evento, // Agregar el campo de evento a los datos de la actividad
            ponente: ponenteData // Agregar los datos del ponente a los datos de la actividad
        };

        var actividadDataCompuesta = {
            tipo: 'compuesta',
            id: id,
            aforo: aforo,
            fechaInicio: inicio,
            fechaFin: fin,
            descripcion: descripcion,
            evento: evento, 
        };
        
        debugger;
        console.log(actividadDataCompuesta)
        // Realizar la solicitud POST para agregar la actividad con el ponente
        fetch('/API/actividades', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(actividadDataCompuesta)
            
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al agregar la actividad');
            }
            return response.json();
        })
        .then(data => {
            // Manejar la respuesta del servidor si es necesario
            console.log('Actividad agregada exitosamente:', data);
            // Aquí puedes realizar alguna acción adicional si es necesario
        })
        .catch(error => {
            console.error('Error al agregar la actividad:', error);
            // Aquí puedes manejar el error de alguna manera
        });
    });
    
    // Inicializar el estado según la selección predeterminada
    actividadSelect.dispatchEvent(new Event('change'));
});
