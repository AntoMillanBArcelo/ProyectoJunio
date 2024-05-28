document.addEventListener('DOMContentLoaded', function() {
    var btnPestaña = document.getElementById('btnPestaña');
    var iframeContainer = document.getElementById('iframeContainer');
    var mainSection = document.getElementById('main');
    let selectElement = document.getElementById("fuente");
    const apiUrl = '/api/recursos';
    const apiUrl2 = '/api/grupos';
    const gruposContainer = document.getElementById('grupos-container');
    const gruposSelect = document.getElementById('grupos-select');

    if (btnPestaña) {
        btnPestaña.addEventListener('click', function() {
            // Mostrar el iframeContainer
            iframeContainer.style.display = 'block';

            // Ocultar el mainSection después de que se muestre el iframeContainer
            mainSection.style.display = 'none';
        });
    }
   
    //API de recursos
    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        console.log(data); // Imprime los datos en la consola para verificar su estructura
        
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
});
