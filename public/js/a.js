document.addEventListener('DOMContentLoaded', function() {
    
    var buttons = document.querySelectorAll('.btnPestaña');

    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('iframeContainer2').style.display = 'block';
            document.querySelectorAll('.card.w-75').forEach(function(card) {
                card.style.display = 'none';
            });
        });
    });

     // Obtiene el botón "Añadir Actividad" por su ID
     var openModalButton = document.getElementById('openPestañasModal');
     // Obtiene el modal por su ID
     var modal = document.getElementById('pestañasModal');

     // Agrega un evento de clic al botón "Añadir Actividad"
     openModalButton.addEventListener('click', function() {
         // Muestra el modal
         modal.style.display = 'block';
         // Asegúrate de que Bootstrap modal lo maneje adecuadamente
         $(modal).modal('show');
     });
});
