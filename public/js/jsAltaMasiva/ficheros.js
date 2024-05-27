datos=[["cañ","Cañon de Proyección"],
["portW","Portatil Windows"],
["portL","Portatil Linux"],
["internet","Conexión a Internet"],
["pantT","Pantalla Táctil"]
];

datos2=[["portL","Portatil Linux"],
 ["internet","Conexión a Internet"]
];
document.addEventListener("DOMContentLoaded", function() {
  let fichero = document.getElementById("fichero");
  let fuente = document.getElementById("fuente");
  let seleccionados = document.getElementById("seleccionados");
  let pasarIzq = document.getElementById("pasarIzq");
  let pasarIzqTodos = document.getElementById("pasarIzqTodos");
  let pasarDer = document.getElementById("pasarDer");
  let pasarDerTodos = document.getElementById("pasarDerTodos");
  let checkActEdTabla = document.getElementById("actEdTabla");
  let btnGuardar = document.getElementById("btnGuardar");
  let tabla = document.getElementById("ponentes");
  let btnRellenarTabla = document.getElementById("btnRellenarTabla");
  let btnAlta = document.getElementById("btnAlta");
  let entidad = btnAlta.getAttribute("data-entidad");
  let apiUrl;
  
  fichero.onchange = function() {
    let ficheroSubido = this.files[0];
    if ((/\.csv$/i).test(ficheroSubido.name)) {
      let lector = new FileReader();
      lector.readAsText(ficheroSubido);
      lector.onload = function() {
        let datos;
        if (entidad === 'User') {
          datos = obtenerInformacion(this.result, /^.+;.{7}\d{3};.{7}\d{3}@.+\r?$/, 3);
        } else if (entidad === 'Alumno') {
          datos = obtenerInformacion(this.result, /^([^;]+);([^;]+);(\d{2}-\d{2}-\d{4})\r?$/, 3);
        } else if (entidad === 'Edificio') {
          datos = obtenerInformacion(this.result, /^.*$/, 3);
        }
        console.log(datos);
        mostrarTabla(datos);
      }
    } else {
      alert("El fichero subido no tiene el formato csv");
    }
  };


  let datosMostrar = [];
  for (let i = 0; i < datos.length; i++) {
    let encontrado = false;
    for (let j = 0; j < datos2.length; j++) {
      if (datos2[j][0] == datos[i][0]) {
        encontrado = true;
        break;
      }
    }
    if (!encontrado) {
      datosMostrar.push(datos[i]);
    }
  }

  cargarDatosSelect(datosMostrar, fuente);
  cargarDatosSelect(datos2, seleccionados);

  pasarIzq.onclick = function() {
    pasarSeleccionadosSelect(seleccionados, fuente);
  };
  pasarIzqTodos.onclick = function() {
    pasarTodosSelect(seleccionados, fuente);
  };
  pasarDer.onclick = function() {
    pasarSeleccionadosSelect(fuente, seleccionados);
  };
  pasarDerTodos.onclick = function() {
    pasarTodosSelect(fuente, seleccionados);
  };

  function pulsadoBorrar(fila) {
    return function() {
      let respuesta = confirm("¿Estás seguro que quieres borrar?");
      if (respuesta) {
        fila.parentElement.removeChild(fila);
      }
    };
  }

  function pulsadoEditar(fila) {
    return function() {
      fila.editar();
    };
  }

  function pulsadoGuardar(fila) {
    return function() {
      fila.guardar();
    };
  }

  function pulsadoCancelar(fila) {
    return function() {
      fila.cancelar();
    };
  }

  checkActEdTabla.onchange = function() {
    if (this.checked) {
      tabla.activarEdicion(pulsadoBorrar, pulsadoEditar, pulsadoGuardar, pulsadoCancelar);
    } else {
      tabla.desactivarEdicion();
    }
  };

  btnGuardar.onclick = function() {
    if (checkActEdTabla.checked) {
      alert("Desactiva la edición para guardar los cambios");
    } else {
      let tableData = [];
      let rows = tabla.querySelectorAll("tbody tr");
      rows.forEach(row => {
        let rowData = {};
        row.querySelectorAll("td").forEach((cell, index) => {
          if (entidad === 'User') {
            if (index === 0) rowData['nombre'] = cell.innerText;
            if (index === 1) rowData['nick'] = cell.innerText;
            if (index === 2) rowData['email'] = cell.innerText;
          } else if (entidad === 'Alumno') {
            if (index === 0) rowData['nombre'] = cell.innerText;
            if (index === 1) rowData['correo'] = cell.innerText;
            if (index === 2) rowData['fecha_nac'] = cell.innerText;
          }
        });
        tableData.push(rowData);
      });

      let url = entidad === 'User' ? '/api/users' : (entidad === 'Alumno' ? 'http://127.0.0.1:8000/api/alumnos' : '');
      if (url) {
        tableData.forEach(data => {
          debugger
          fetch(url, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
          })
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            console.log('Success:', data);
          })
          .catch((error) => {
            console.error('Error:', error);
          });
        });
      }
      window.location.reload();
    }
  };

  // Función para mostrar los datos en la tabla
  function mostrarTabla(datos) {
    let tbody = tabla.querySelector("tbody");
    tbody.innerHTML = ""; // Limpiar la tabla antes de agregar los nuevos datos
    datos.forEach(dato => {
      let fila = document.createElement("tr");
      dato.forEach(celda => {
        let td = document.createElement("td");
        td.textContent = celda;
        fila.appendChild(td);
      });
      tbody.appendChild(fila);
    });
  }

 
  btnRellenarTabla.addEventListener("click", function() {
    
   console.log(entidad);
   console.log(apiUrl)
    if (entidad === 'User') {
      apiUrl = '/api/users';
    } else if (entidad === 'Alumno') {
      apiUrl = '/api/alumnos';
    } else if (entidad === 'Edificio') {
      apiUrl = '/api/edificios';
    }

    fetch(apiUrl)
      .then(response => response.json())
      .then(data => {
        tabla.querySelector("tbody").innerHTML = "";
        
        data.forEach(item => {
          let row = document.createElement("tr");
          Object.values(item).forEach(value => {
            let cell = document.createElement("td");
            cell.textContent = value;
            row.appendChild(cell);
          });
          tabla.querySelector("tbody").appendChild(row);
        });
      })
      .catch(error => {
        console.error('Error al obtener los datos:', error);
      });
  });
});
