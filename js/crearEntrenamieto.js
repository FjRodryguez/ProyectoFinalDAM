document.addEventListener('DOMContentLoaded', function () {
    fetch('../JSON/datos.json')
        .then(response => response.json())
        .then(jsonData => {
            window.data = jsonData;
        })
        .catch(error => console.error('Error al cargar el JSON:', error));
});

function mostrarContenido(dataKey, dropdown) {
    if (window.data) {
        const dataItems = window.data[dataKey];
        dataItems.forEach(item => {
            const option = document.createElement('option');
            option.value = item.nombre;
            option.textContent = item.nombre;
            dropdown.appendChild(option);
        });
    }
}

function cargarTecnicas(estiloDropdown) {
    if (window.data) {
        const selectedEstilo = estiloDropdown.value;
        const tecnicasDropdown = estiloDropdown.closest('.form-row').querySelector("#tecnicas");
        tecnicasDropdown.innerHTML = '<option value="">Seleccionar</option>';
        if (selectedEstilo) {
            const estilo = window.data.estilos.find(e => e.nombre === selectedEstilo);
            if (estilo) {
                estilo.tecnicas.forEach(tecnica => {
                    const option = document.createElement('option');
                    option.value = tecnica.nombre;
                    option.textContent = tecnica.nombre;
                    tecnicasDropdown.appendChild(option);
                });
            }
        }
    }
}

function cargarDescripcion(tecnicasDropdown) {
    if (window.data) {
        const selectedTecnica = tecnicasDropdown.value;
        const textarea = tecnicasDropdown.closest('.form-group').querySelector("#descripcion");
        if (selectedTecnica) {
            const selectedEstilo = tecnicasDropdown.closest('.form-row').querySelector("#estilos").value;
            const estilo = window.data.estilos.find(e => e.nombre === selectedEstilo);
            if (estilo) {
                const tecnica = estilo.tecnicas.find(t => t.nombre === selectedTecnica);
                if (tecnica) {
                    textarea.value = tecnica.descripcion;
                }
            }
        }
    }
}

function agregarEjercicio(seccionId) {
    const ejercicio = document.createElement('div');
    ejercicio.className = 'form-group';
    ejercicio.innerHTML = `<div class="form-row">
    <div class="col">
        <label>Repeticiones</label>
        <input type="text" name="${seccionId}[repeticiones][]" class="form-control mb-2">
    </div>
    <div class="col">
        <label>Metros</label>
        <input type="text" name="${seccionId}[metros][]" class="form-control mb-2">
    </div>
    <div class="col">
        <label>Tiempo</label>
        <div class="form-row">
            <div class="col">
                <input type="number" name="${seccionId}[minutos][]" class="form-control" placeholder="Min">
            </div>
            <div class="col">
                <input type="number" name="${seccionId}[segundos][]" class="form-control" placeholder="Seg">
            </div>
        </div>
    </div>
    </div>
    <div class="form-row">
        <div class="col">
            <label>Estilo</label>
            <select name="${seccionId}[estilo][]" id="estilos" class="form-control mb-2" onchange="cargarTecnicas(this)">
                <option value="">Seleccionar</option>
            </select>
        </div>
        <div class="col">
            <label>Técnica</label>
            <select name="${seccionId}[tecnica][]" id="tecnicas" class="form-control mb-2" onchange="cargarDescripcion(this)">
                <option value="">Seleccionar</option>
            </select>
        </div>
        <div class="col">
            <label>Ritmo</label>
            <select name="${seccionId}[ritmo][]" id="ritmos" class="form-control mb-2">
                <option value="">Seleccionar</option>
            </select>
        </div>
        <div class="col">
            <label>Material</label>
            <select name="${seccionId}[material][]" id="materiales" class="form-control mb-2">
                <option value="">Seleccionar</option>
            </select>
        </div>
    </div>
<textarea class="form-control mb-2" rows="2" placeholder="Descripción de la técnica" id="descripcion" readonly></textarea>
<button type="button" class="btn btn-danger btn-sm btn-eliminar" onclick="eliminarEjercicio(this)">Eliminar</button>
    `;
    document.getElementById(seccionId).appendChild(ejercicio);

    if (window.data) {
        const estilosDropdown = ejercicio.querySelector("#estilos");
        const ritmosDropdown = ejercicio.querySelector("#ritmos");
        const materialesDropdown = ejercicio.querySelector("#materiales");

        mostrarContenido("estilos", estilosDropdown);
        mostrarContenido("ritmos", ritmosDropdown);
        mostrarContenido("materiales", materialesDropdown);
    }
}

function eliminarEjercicio(btnEliminar) {
    btnEliminar.closest('.form-group').remove();
}
