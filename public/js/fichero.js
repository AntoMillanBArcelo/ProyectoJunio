datos = [["cañ", "Cañon de Proyeccion"],
["portW", "Portatil Windows"],
["portL", "Portatil Linux"],
["internet", "Conexion a Internet"],
["pantT", "Pantalla Tactil"]];

datos2 = [["cañ", "Cañon de Proyeccion"],
["portW", "Portatil Windows"]]

window.addEventListener("load", function()
{
    var fichero = document.getElementById("fichero");
    var fuente = document.getElementById("fuente");
    var seleccionados = document.getElementById("seleccionados");
    var pasarIzq = document.getElementById("pasarIzq");
    var pasarIzqTodos = document.getElementById("pasarIzqTodos");
    var pasarDer = document.getElementById("pasarDer");
    var pasarDerTodos = document.getElementById("pasarDerTodos");

    fichero.onchange= function () 
    {
        let ficheroSubido = this.files[0];
        if ((/\.csv$/i).test(ficheroSubido.name)) 
        {
            let lector=new FileReader();
            lector.readAsText(ficheroSubido);
            lector.onload=function() 
            {
                let profesores = obtenerInformacion(this.result, /^.+;.{7}\d{3};.{7}\d{3}@.+\r?$/, 3);
                console.log(profesores);
            }
        }
        else
        {
            alert("El fichero subido no tiene el formato csv");
        }
    }
    let datosMostrar=[];
    for(let i=0; i<datos.length;i++)
    {
        let encontrado = false;
        
    }

    vaciarSelect(fuente);
    cargarDatosSelect(datos, fuente);

    pasarIzq.onclick = function(){
        pasarSeleccionadosSelect(seleccionados, fuente);
    }
    pasarIzqTodos.onclick = function(){
        pasarTodosSelect(seleccionados, fuente);
    }
    pasarDer.onclick = function(){
        pasarSeleccionadosSelect( fuente, seleccionados);
    }
    pasarDerTodos.onclick = function(){
        pasarTodosSelect( fuente, seleccionados);
    }

    /* datoss(seleccionados); */
})

