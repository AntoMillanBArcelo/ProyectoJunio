 // Este código se ejecutará después de que se haya cargado el DOM
 window.addEventListener("load", function()
 {
    // Obtener el botón
    let btn = document.getElementById("button");

    // Obtener la ventana modal
    let modal = document.getElementById("myModal");

    // Obtener el elemento <span> que cierra la ventana modal
    let span = document.querySelector(".close");

    // Cuando el usuario hace clic en el botón, abre la ventana modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // Cuando el usuario hace clic en <span> (x), cierra la ventana modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // Cuando el usuario hace clic fuera de la ventana modal, también la cierra
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});