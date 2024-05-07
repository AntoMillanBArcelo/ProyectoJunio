//Función que pasandole un array bidimensional genera los option del select añadiendo al final
//datos es un array
//donde es un objeto DOM select
function cargarDatosSelect(datos, donde) 
{
    for (let index = 0; index < datos.length; index++) 
    {
       let option = document.createElement("option");
       
       option.value = datos[index][0];
       option.innerHTML = datos[index][1];

       donde.appendChild(option);
    }
}

//Funcion que pasandole un objeto DOM select lo vacia
function vaciarSelect(select)
{
    select.innerHTML = ""
}


//Funcion pasar seleccionados
//Pasa los elementos seleccionados en origen a destino
function pasarSeleccionadosSelect(origen, destino)
{
    while(origen.selectedOptions.length>0)
    {
        let candidato = origen.selectedOptions[0];
        candidato.selected = false;
        destino.appendChild(candidato);
    }
}

function pasarTodosSelect(origen, destino)
{
    while(origen.options.length>0)
    {
        let candidato = origen.options[0];
        candidato.selected = false;
        destino.appendChild(candidato);
    }
}

function datoss(select) 
{
    let s = [];
    for (let index = 0; index < select.options.length; index++) 
    {
        let dato = [select.options[index].value, select.options[index].innerHTML];
        s.push(dato);
    }

    return s;
}  