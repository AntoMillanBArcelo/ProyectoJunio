//pestaña.js
document.addEventListener('DOMContentLoaded', function() {
    var btnPestaña = document.getElementById('btnPestaña');
    var iframeContainer = document.getElementById('iframeContainer');
    var mainSection = document.getElementById('main');
    let selectElement = document.getElementById("fuente");
    const apiUrl = '/api/recursos';
    const apiUrl2 = '/api/grupos';
    let eventoSelect = document.getElementById("evento");
    const apiUrlEventos = '/api/eventos';
    const gruposSelect = document.getElementById('grupos-select');
    
  
    if (btnPestaña) {
        btnPestaña.addEventListener('click', function() {
            iframeContainer.style.display = 'block';

            mainSection.style.display = 'none';
        });
    }
    
   
    //API de recursos
    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        
        
        selectElement.innerHTML = '';
        
        data.forEach(resource => {
            const option = document.createElement('option');
            option.value = resource.id; // Asigna el ID al valor de la opción
            option.textContent = resource.Descripcion; // Asigna la descripción al texto de la opción
            selectElement.appendChild(option);
        });
    })
    .catch(error => {
        console.error('Error al obtener los recursos:', error);
    });


    // API de grupo
    fetch(apiUrl2)
    .then(response => response.json())
    .then(data => {
        gruposSelect.innerHTML = '';
        data.forEach(grupo => {
            const optionElement = document.createElement('option');
            optionElement.textContent = grupo.Nombre;
            optionElement.value = grupo.Id; // Asegúrate de que cada grupo tenga un campo "Id" o similar
            gruposSelect.appendChild(optionElement);
        });
    })
    .catch(error => {
        console.error('Error al obtener los grupos:', error);
    });

   // API de eventos
   fetch(apiUrlEventos)
   .then(response => response.json())
   .then(data => {
       eventoSelect.innerHTML = '<option value="">Seleccione un evento</option>';
       
       data.forEach(evento => {
           const option = document.createElement('option');
           option.value = evento.id; // Asigna el ID del evento al valor de la opción
           option.textContent = evento.titulo; // Asigna el título del evento al texto de la opción
           eventoSelect.appendChild(option);
       });
   })
   .catch(error => {
       console.error('Error al obtener los eventos:', error);
   });
});
