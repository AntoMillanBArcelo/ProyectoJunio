//contenidoFichero es el texto que se encuentra en el fichero
//patron expresión regular con el formato de cada linea
//nCampos número de campos por línea

function obtenerInformacion(contenidoFichero,patron,nCampos){
    let lineas=contenidoFichero.split("\n");
    let nLineas=lineas.length;
    let informacion=[];
    for (let i=0; i<nLineas;i++){
        if (patron.test(lineas[i])){
            let partes=lineas[i].split(";");
            if (partes.length=nCampos)
                informacion.push(partes);
        } 
    }

    if (nLineas!=informacion.length){
        informacion=[];
    }
    return informacion;
}




//
