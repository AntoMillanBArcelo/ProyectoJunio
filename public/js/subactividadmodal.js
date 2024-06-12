document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('button[id="btnViewSubactivities"]').forEach(button => {
        button.addEventListener('click', function () {
            const activityId = this.getAttribute('data-id');
            fetch(`/actividad/${activityId}/subactividades`)
                .then(response => response.json())
                .then(data => {
                    const subactividadesContent = document.getElementById('subactividadesContent');
                    subactividadesContent.innerHTML = '';

                    if (data.subactividades.length > 0) {
                        const table = document.createElement('table');
                        table.classList.add('table', 'table-striped');
                        const thead = document.createElement('thead');
                        thead.innerHTML = `
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        `;
                        table.appendChild(thead);
                        const tbody = document.createElement('tbody');

                        data.subactividades.forEach(subactividad => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                                <td>${subactividad.id}</td>
                                <td>${subactividad.Titulo}</td>
                                <td>${subactividad.FechaHoraIni}</td>
                                <td>${subactividad.FechaHoraFin}</td>
                                <td>${subactividad.descripcion}</td>
                                <td><button class="btn btn-danger btnDeleteSubactivity" data-id="${subactividad.id}">Borrar</button></td>
                            `;
                            tbody.appendChild(tr);
                        });

                        table.appendChild(tbody);
                        subactividadesContent.appendChild(table);
                    } else {
                        subactividadesContent.innerHTML = '<p>No hay subactividades para esta actividad.</p>';
                    }

                    const modal = new bootstrap.Modal(document.getElementById('subactividadesModal'));
                    modal.show();

                    // Añadir event listeners para botones de borrar
                    document.querySelectorAll('.btnDeleteSubactivity').forEach(button => {
                        button.addEventListener('click', function () {
                            const subactivityId = this.getAttribute('data-id');
                            if (confirm('¿Estás seguro de que deseas borrar esta subactividad?')) {
                                fetch(`/API/subactividades/${subactivityId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(response => {
                                    if (response.ok) {
                                        // Actualizar la vista para eliminar la fila de la tabla
                                        this.closest('tr').remove();
                                    } else {
                                        response.json().then(data => {
                                            alert('Error al borrar la subactividad: ' + data.error);
                                        });
                                    }
                                })
                                .catch(error => {
                                    alert('Error al borrar la subactividad: ' + error.message);
                                });
                            }
                        });
                    });
                });
        });
    });
});
