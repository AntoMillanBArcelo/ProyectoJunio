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
            option.value = resource.id; 
            option.textContent = resource.Descripcion;
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
        const checkboxesContainer = document.getElementById('checkboxes-container');
        checkboxesContainer.innerHTML = ''; // Limpiar contenido anterior

        data.forEach(grupo => {
            const checkboxDiv = document.createElement('div');
            checkboxDiv.classList.add('form-check');

            const checkboxInput = document.createElement('input');
            checkboxInput.classList.add('form-check-input');
            checkboxInput.type = 'checkbox';
            checkboxInput.value = grupo.Id;
            checkboxInput.id = `grupo-${grupo.Id}`;

            const checkboxLabel = document.createElement('label');
            checkboxLabel.classList.add('form-check-label');
            checkboxLabel.htmlFor = `grupo-${grupo.Id}`;
            checkboxLabel.textContent = grupo.Nombre;

            checkboxDiv.appendChild(checkboxInput);
            checkboxDiv.appendChild(checkboxLabel);
            checkboxesContainer.appendChild(checkboxDiv);
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
           option.value = evento.id; 
           option.textContent = evento.titulo; 
           eventoSelect.appendChild(option);
       });
   })
   .catch(error => {
       console.error('Error al obtener los eventos:', error);
   });
});
