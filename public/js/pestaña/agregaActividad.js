document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('[data-mdb-toggle="tab"]');
    var btnGuardarSimple = document.getElementById('g1');
    var openModalButtons = document.querySelectorAll('.openPestañasModal');
    

    openModalButtons.forEach(function(openModalButton) {
        openModalButton.addEventListener('click', function() {
            // Obtener el valor del atributo data-id del botón clicado
            var entityId = openModalButton.getAttribute('data-id');
            // Establecer el valor del campo id en el formulario dentro del modal
            document.getElementById('idd').value = entityId;
            // Mostrar el modal
            modal.show();
        });
    });

    tabs.forEach(function(tab) 
    {
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
            tabLinks.forEach(function(link, index) 
            {
                if (index > 0) 
                    { 
                    link.classList.add('disabled');
                }
            });
        } 
        else 
        {
            tabLinks.forEach(function(link) {
                link.classList.remove('disabled');
            });
        }
    });


    actividadSelect.addEventListener('change', function() {
        
        if (actividadSelect.value === 'simple') 
            {         
            btnGuardarSimple.disabled = true;
        } 
        else 
        {
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
                console.log('Actividad agregada exitosamente:', data);
            })
            .catch(error => {
                console.error('Error al agregar la actividad:', error);
                alert(`Error al agregar la actividad: ${error.message || error}`);
            });
        });
    });
    
    actividadSelect.dispatchEvent(new Event('change'));
});
