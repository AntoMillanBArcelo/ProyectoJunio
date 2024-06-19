document.addEventListener('DOMContentLoaded', function() {
    fetch('/API/actividad')
        .then(response => response.json())
        .then(data => {
            const container = document.querySelector('.card-columns');
            
            data.forEach(actividad => {
                const card = document.createElement('div');
                card.classList.add('card');

                const img = document.createElement('img');
                img.classList.add('card-img-top');
                img.src = "https://via.placeholder.com/500"; 
                img.alt = "Card image cap";
                card.appendChild(img);

                const cardBody = document.createElement('div');
                cardBody.classList.add('card-body');
                
                const cardTitle = document.createElement('h5');
                cardTitle.classList.add('card-title');
                cardTitle.textContent = actividad.descripcion;
                cardBody.appendChild(cardTitle);

                const cardText = document.createElement('p');
                cardText.classList.add('card-text');
                cardText.textContent = `Fecha Inicio: ${new Date(actividad.FechaHoraIni).toLocaleString()}, Fecha Fin: ${new Date(actividad.FechaHoraFin).toLocaleString()}`;
                cardBody.appendChild(cardText);

                if (actividad.evento && actividad.evento.nombre) {
                    const eventoText = document.createElement('p');
                    eventoText.classList.add('card-text');
                    eventoText.textContent = `Evento: ${actividad.evento.nombre}`;
                    cardBody.appendChild(eventoText);
                }

                const smallText = document.createElement('p');
                smallText.classList.add('card-text');
                smallText.innerHTML = `<small class="text-muted"><i class="fas fa-eye"></i>1000 <i class="far fa-user"></i>admin <i class="fas fa-calendar-alt"></i>${new Date(actividad.FechaHoraIni).toLocaleDateString()}</small>`;
                cardBody.appendChild(smallText);

                card.appendChild(cardBody);

                if (actividad.detalleActividads.length > 0) {
                    const subactividadesList = document.createElement('div');
                    subactividadesList.classList.add('subactividades');

                    actividad.detalleActividads.forEach(subactividad => {
                        const subactividadItem = document.createElement('div');
                        subactividadItem.classList.add('subactividad');

                        const subactividadTitulo = document.createElement('h3');
                        subactividadTitulo.textContent = subactividad.titulo;
                        subactividadTitulo.classList.add('subactividad-titulo');
                        subactividadItem.appendChild(subactividadTitulo);

                        const subactividadFechaIni = document.createElement('p');
                        subactividadFechaIni.textContent = `Fecha Inicio: ${new Date(subactividad.fecha_hora_ini).toLocaleString()}`;
                        subactividadFechaIni.classList.add('subactividad-fecha');
                        subactividadItem.appendChild(subactividadFechaIni);

                        const subactividadFechaFin = document.createElement('p');
                        subactividadFechaFin.textContent = `Fecha Fin: ${new Date(subactividad.fecha_hora_fin).toLocaleString()}`;
                        subactividadFechaFin.classList.add('subactividad-fecha');
                        subactividadItem.appendChild(subactividadFechaFin);

                        if (subactividad.espacio) {
                            const subactividadEspacio = document.createElement('p');
                            subactividadEspacio.textContent = `Espacio: ${subactividad.espacio}`;
                            subactividadEspacio.classList.add('subactividad-espacio');
                            subactividadItem.appendChild(subactividadEspacio);
                        }

                        const ponentesList = document.createElement('ul');
                        ponentesList.classList.add('ponentes');
                        subactividad.ponentes.forEach(ponente => {
                            const ponenteItem = document.createElement('li');
                            ponenteItem.textContent = `${ponente.nombre} (${ponente.cargo}) - ${ponente.url}`;
                            ponenteItem.classList.add('ponente');
                            ponentesList.appendChild(ponenteItem);
                        });

                        subactividadItem.appendChild(ponentesList);
                        subactividadesList.appendChild(subactividadItem);
                    });

                    cardBody.appendChild(subactividadesList);
                }

                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error('Error al obtener las actividades:', error);
        });
});
