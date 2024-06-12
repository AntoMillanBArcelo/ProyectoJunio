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
                                <td>
                                    <button class="btn btn-danger btnDeleteSubactivity" data-id="${subactividad.id}">Borrar</button>
                                    <button class="btn btn-danger btnActualizarSubactivity" data-id="${subactividad.id}">Actualizar</button>
                                </td>
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

                    document.querySelectorAll('.btnActualizarSubactivity').forEach(button => {
                        button.addEventListener('click', function () {
                            const subactivityId = this.getAttribute('data-id');
                            const tr = this.closest('tr');
                            
                            const id = tr.querySelector('td:nth-child(1)').innerText;
                            const titulo = tr.querySelector('td:nth-child(2)').innerText;
                            const fechaInicio = tr.querySelector('td:nth-child(3)').innerText;
                            const fechaFin = tr.querySelector('td:nth-child(4)').innerText;
                            const descripcion = tr.querySelector('td:nth-child(5)').innerText;
                
                            tr.innerHTML = `
                                <td><input type="text" value="${id}" readonly></td>
                                <td><input type="text" value="${titulo}"></td>
                                <td><input type="text" value="${fechaInicio}"></td>
                                <td><input type="text" value="${fechaFin}"></td>
                                <td><input type="text" value="${descripcion}"></td>
                                <td><button class="btn btn-primary btnSaveSubactivity">Guardar</button></td>
                            `;
                            
                            tr.querySelector('.btnSaveSubactivity').addEventListener('click', function () {
                                const newTitulo = tr.querySelector('input:nth-child(2)').value;
                                const newFechaInicio = tr.querySelector('input:nth-child(3)').value;
                                const newFechaFin = tr.querySelector('input:nth-child(4)').value;
                                const newDescripcion = tr.querySelector('input:nth-child(5)').value;
                                
                                // Aquí puedes enviar una solicitud PUT al endpoint de actualización con los nuevos valores
                                // Por ahora, puedes imprimir los nuevos valores en la consola
                                console.log('Nuevo título:', newTitulo);
                                console.log('Nueva fecha de inicio:', newFechaInicio);
                                console.log('Nueva fecha de fin:', newFechaFin);
                                console.log('Nueva descripción:', newDescripcion);
                            });
                        });
                    });

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
