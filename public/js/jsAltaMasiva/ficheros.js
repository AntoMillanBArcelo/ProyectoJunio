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

  fichero.onchange = function() {
    let ficheroSubido = this.files[0];
    if ((/\.csv$/i).test(ficheroSubido.name)) {
      let lector = new FileReader();
      lector.readAsText(ficheroSubido);
      lector.onload = function() {
        let profesores = obtenerInformacion(this.result, /^([^;]+);([^;]+);(\d{4}-\d{2}-\d{2})\r?$/, 3);/*  /^.+;.{7}\d{3};.{7}\d{3}@.+\r?$/ */
        console.log(profesores);
        mostrarTabla(profesores);
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
          if (index === 0) rowData['nombre'] = cell.innerText;
          if (index === 1) rowData['correo'] = cell.innerText;
          if (index === 2) rowData['fecha_nac'] = cell.innerText; 
        });
        tableData.push(rowData);
      });

      tableData.forEach(data => {
        fetch('http://127.0.0.1:8000/api/alumnos', {
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
});
