document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('csvFileInput').addEventListener('change', handleFileSelect);
    document.getElementById('btnRellenarTabla').addEventListener('click', rellenarTablaConAPI);

    function handleFileSelect(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            const csvData = e.target.result;
            const lines = csvData.split(/\r\n|\n/);

            const tableBody = document.querySelector('#dataTable tbody');

            lines.forEach(function(line, index) {
                if (index > 0) { 
                    const row = document.createElement('tr');
                    const cells = line.split(';');

                    cells.forEach(function(cell) {
                        const cellElement = document.createElement('td');
                        cellElement.textContent = cell;
                        row.appendChild(cellElement);
                    });

                    tableBody.appendChild(row);
                }
            });
        };

        reader.readAsText(file);
    }

    function rellenarTablaConAPI() {
        // Aquí haces la solicitud a tu API y llenas la tabla con los datos recibidos
        // Por ejemplo:
        fetch('/api/alumnos')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#dataTable tbody');
                tableBody.innerHTML = ''; // Limpiamos el contenido actual de la tabla

                data.forEach(item => {
                    const row = document.createElement('tr');
                    const nombreCell = document.createElement('td');
                    nombreCell.textContent = item.nombre;
                    row.appendChild(nombreCell);

                    const nickCell = document.createElement('td');
                    nickCell.textContent = item.nick;
                    row.appendChild(nickCell);

                    const correoCell = document.createElement('td');
                    correoCell.textContent = item.correo;
                    row.appendChild(correoCell);

                    tableBody.appendChild(row);
                });
            })
            .catch(error => console.error('Error al obtener los datos de la API:', error));
    }
});
