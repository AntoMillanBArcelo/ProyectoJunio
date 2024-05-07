HTMLTableElement.prototype.saludo=function(){
    alert("Hola");
}
HTMLTableElement.prototype.editada=false;

HTMLTableElement.prototype.getData = function() {
    var tBody = this.tBodies[0];
    let datos = [];
    let filas = tBody.rows;
    let nFilas = filas.length;
    for (let i = 0; i < nFilas; i++) { 
        let fila = [];
        let nColumnas = filas[i].cells.length;
        for (let j = 0; j < nColumnas; j++) {
            if(!filas[i].cells[j].classList.contains("editada"))
            {           
                fila.push(filas[i].cells[j].innerHTML);
            }
        }
        datos.push(fila);
    }
    return datos;
}

HTMLTableElement.prototype.setData = function(datos) {
    var tBody = this.tBodies[0];
    tBody.innerHTML = "";
    let nFilas = datos.length;
    for (let i = 0; i < nFilas; i++) { 
        let fila = document.createElement("tr");
        let nColumnas = datos[i].length;
        for (let j = 0; j < nColumnas; j++) {
            let celda = document.createElement("td");
            celda.innerHTML=datos[i][j];
            fila.appendChild(celda);
        }
        tBody.appendChild(fila);
    }
}