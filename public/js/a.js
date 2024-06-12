document.addEventListener('DOMContentLoaded', function() {
    var openModalButtons = document.querySelectorAll('.openPestañasModal');
    var modal = new bootstrap.Modal(document.getElementById('pestañasModal'), {
        backdrop: 'static',
        keyboard: false
    });

    openModalButtons.forEach(function(openModalButton) {
        openModalButton.addEventListener('click', function() {
            modal.show();
        });
    });

    var buttons = document.querySelectorAll('.btnPestaña');
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            document.getElementById('iframeContainer2').style.display = 'block';
            document.querySelectorAll('.card.w-75').forEach(function(card) {
                card.style.display = 'none';
            });
        });
    });
});


