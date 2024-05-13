document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('csvFileInput').addEventListener('change', handleFileSelect);
    let btnAlta = document.getElementById("btnAlta");
    btnAlta.onclick=function(){
        alert("hola")
    }
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
});
