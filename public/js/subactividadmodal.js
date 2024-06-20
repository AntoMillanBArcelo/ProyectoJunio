document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('button[id="btnViewSubactivities"]').forEach(button => {
        button.addEventListener('click', function () {
            const activityId = this.getAttribute('data-id');
            fetch(`/actividad/${activityId}/subactividades`)
                .then(response => response.json())
                .then(data => {
                    const subactividadesContent = document.getElementById('subactividadesContent');
                    if (!subactividadesContent) {
                        console.error('error');
                        return;
                    }

                    const tbody = subactividadesContent.querySelector('tbody');
                    tbody.innerHTML = '';

                    if (data.subactividades.length > 0) {
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
                                    <button class="btn btn-primary btnActualizarSubactivity" data-id="${subactividad.id}">Actualizar</button>
                                </td>
                            `;
                            tbody.appendChild(tr);
                        });

                        tbody.addEventListener('click', function (event) {
                            if (event.target.classList.contains('btnActualizarSubactivity')) {
                                const tr = event.target.closest('tr');
                                const id = tr.querySelector('td:nth-child(1)').innerText;
                                const titulo = tr.querySelector('td:nth-child(2)').innerText;
                                const fechaInicio = tr.querySelector('td:nth-child(3)').innerText;
                                const fechaFin = tr.querySelector('td:nth-child(4)').innerText;
                                const descripcion = tr.querySelector('td:nth-child(5)').innerText;

                                tr.innerHTML = `
                                    <td>${id}</td>
                                    <td><input type="text" id="titulo" class="form-control" value="${titulo}"></td>
                                    <td><input type="datetime-local" id="fechaInicio" class="form-control" value="${fechaInicio}"></td>
                                    <td><input type="datetime-local" id="fechaFin" class="form-control" value="${fechaFin}"></td>
                                    <td><input type="text" id="descripcion" class="form-control" value="${descripcion}"></td>
                                    <td>
                                        <button class="btn btn-primary btnSaveSubactivity">Guardar</button>
                                    </td>
                                `;
                                tr.querySelector('.btnSaveSubactivity').addEventListener('click', function () {
                                    const newTitulo = tr.querySelector('#titulo').value;
                                    const newFechaInicio = tr.querySelector('#fechaInicio').value;
                                    const newFechaFin = tr.querySelector('#fechaFin').value;
                                    const newDescripcion = tr.querySelector('#descripcion').value;

                                    fetch(`/API/subactividades/${id}`, {
                                        method: 'PUT',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            titulo: newTitulo,
                                            fechaInicio: newFechaInicio,
                                            fechaFin: newFechaFin,
                                            descripcion: newDescripcion
                                        }),
                                    })
                                    .then(response => {
                                        if (response.ok) {
                                            console.log('Subactividad actualizada correctamente');
                                            location.reload();
                                        } else {
                                            throw new Error('Error al actualizar la subactividad');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al actualizar la subactividad:', error);
                                    });
                                });
                            } else if (event.target.classList.contains('btnDeleteSubactivity')) {
                                const id = event.target.getAttribute('data-id');

                                fetch(`/API/subactividades/${id}`, {
                                    method: 'DELETE'
                                })
                                .then(response => {
                                    if (response.ok) {
                                        console.log('Subactividad eliminada correctamente');
                                        location.reload();
                                    } else {
                                        throw new Error('Error al eliminar la subactividad');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error al eliminar la subactividad:', error);
                                });
                            }
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="6">No hay subactividades para esta actividad.</td></tr>';
                    }

                    const modal = new bootstrap.Modal(document.getElementById('subactividadesModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error al obtener subactividades:', error);
                });
        });
    });
});
