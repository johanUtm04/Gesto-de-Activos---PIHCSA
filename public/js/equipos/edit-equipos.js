        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
            });
        });


//LOGICA PARA AGREGAR PERIFERICOS
//Variable que toma el numero de perifericos, o bien de relaciones

//Condicion 

// PERIFERICOS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const container = document.getElementById('perifericos-container');
let perifericoIndex = parseInt(container.dataset.perifericosCount);

function agregarPeriferico() {
    // Tomamos el container de los perifericos
    const container = document.getElementById('perifericos-container');

    // Agregamos la seccion HTML con los SELECTS en lugar de INPUTS
    const html = `
    <div class="periferico-item">
        <input type="hidden" name="perifericos[${perifericoIndex}][_delete]" value="">
        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Periférico #${perifericoIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Tipo</label>
                    <select name="perifericos[${perifericoIndex}][tipo]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="Teclado">Teclado</option>
                        <option value="Mouse">Mouse</option>
                        <option value="Monitor">Monitor</option>
                        <option value="Diadema">Diadema</option>
                        <option value="Cámara">Cámara</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Marca</label>
                    <select name="perifericos[${perifericoIndex}][marca]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="Logitech">Logitech</option>
                        <option value="HP">HP</option>
                        <option value="Dell">Dell</option>
                        <option value="Genius">Genius</option>
                        <option value="Lenovo">Lenovo</option>
                        <option value="Generico">Genérico</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Serial</label>
                    <input type="text"
                           name="perifericos[${perifericoIndex}][serial]"
                           class="form-control form-control-sm"
                           placeholder="Serial del periférico">
                </div>
            </div>

            <button type="button"
                class="btn btn-sm btn-outline-danger mt-2"
                onclick="eliminarPeriferico(this)">
                <i class="fas fa-trash-alt"></i> Eliminar periférico
            </button>
        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    perifericoIndex++;
}

//Eliminar Periferico
function eliminarPeriferico(btn) {
    if (!confirm('¿Deseas eliminar este periférico?')) {
        return;
    }
    const item = btn.closest('.periferico-item');
    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }
    // 2. vaciar los campos reales
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');
    // 3. ocultar visualmente
    item.style.display = 'none';
}
//PERIFERICOS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-


// RAMS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerRam = document.getElementById('rams-container');
let ramIndex = parseInt(containerRam.dataset.ramsCount);

function agregarRam() {
    const containerRam = document.getElementById('rams-container');
    const html = `
    <div class="ram-item">
        <input type="hidden" name="rams[${ramIndex}][_delete]" value="">
        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> RAM #${ramIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Capacidad (GB)</label>
                    <select name="rams[${ramIndex}][capacidad_gb]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="4">4 GB</option>
                        <option value="8">8 GB</option>
                        <option value="16">16 GB</option>
                        <option value="32">32 GB</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Clock (MHz)</label>
                    <select name="rams[${ramIndex}][clock_mhz]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="2400">2400 MHz</option>
                        <option value="2666">2666 MHz</option>
                        <option value="3200">3200 MHz</option>
                        <option value="4800">4800 MHz</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo (DDR)</label>
                    <select name="rams[${ramIndex}][tipo_chz]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="DDR3">DDR3</option>
                        <option value="DDR4">DDR4</option>
                        <option value="DDR5">DDR5</option>
                    </select>
                </div>
            </div>

            <button type="button"
                class="btn btn-sm btn-outline-danger mt-2"
                onclick="eliminarRam(this)">
                <i class="fas fa-trash"></i> Eliminar RAM
            </button>
        </div>
    </div>
    `;

    containerRam.insertAdjacentHTML('beforeend', html);
    ramIndex++;
}

// Eliminar RAM (soft delete)
function eliminarRam(btn) {
    if (!confirm('¿Deseas eliminar esta RAM?')) {
        return;
    }

    const item = btn.closest('.ram-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    // 2. vaciar inputs visibles
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}


//PROCESADOR.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerProcesador = document.getElementById('procesadores-container');
let procesadorIndex = parseInt(containerProcesador.dataset.procesadoresCount);

function agregarProcesador() {
    const container = document.getElementById('procesadores-container');

    const html = `
    <div class="procesador-item">
        <input type="hidden" name="procesadores[${procesadorIndex}][_delete]" value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Procesador #${procesadorIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Marca</label>
                    <select name="procesadores[${procesadorIndex}][marca]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="Intel">Intel</option>
                        <option value="AMD">AMD</option>
                        <option value="Apple">Apple</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group col-md-8">
                    <label>Descripción / Modelo</label>
                    <input type="text"
                           name="procesadores[${procesadorIndex}][descripcion_tipo]"
                           class="form-control form-control-sm"
                           placeholder="Ej: Core i7-12700K">
                </div>
            </div>

            <button type="button"
                    class="btn btn-sm btn-outline-danger mt-2"
                    onclick="eliminarProcesador(this)">
                <i class="fas fa-trash"></i> Eliminar Procesador
            </button>
        </div>
    </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    procesadorIndex++;
}



function eliminarProcesador(btn) {
    if (!confirm('¿Deseas eliminar este procesador?')) {
        return;
    }

    const item = btn.closest('.procesador-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    // 2. vaciar inputs visibles
    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}



//MONITOR.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerMonitor = document.getElementById('monitores-container');
let monitorIndex = parseInt(containerMonitor.dataset.monitoresCount);

function agregarMonitor() {
    const container = document.getElementById('monitores-container');
    const html = `
    <div class="monitor-item">
        <input type="hidden" name="monitores[${monitorIndex}][_delete]" value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Monitor #${monitorIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-3">
                    <label>Marca</label>
                    <select name="monitores[${monitorIndex}][marca]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="HP">HP</option>
                        <option value="Dell">Dell</option>
                        <option value="Lenovo">Lenovo</option>
                        <option value="LG">LG</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Acer">Acer</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Serial</label>
                    <input type="text" name="monitores[${monitorIndex}][serial]" class="form-control form-control-sm" placeholder="Serial">
                </div>

                <div class="form-group col-md-3">
                    <label>Pulgadas</label>
                    <select name="monitores[${monitorIndex}][escala_pulgadas]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="19">19"</option>
                        <option value="21">21"</option>
                        <option value="22">22"</option>
                        <option value="24">24"</option>
                        <option value="27">27"</option>
                    </select>
                </div>

                <div class="form-group col-md-3">
                    <label>Interfaz</label>
                    <select name="monitores[${monitorIndex}][interface]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="HDMI">HDMI</option>
                        <option value="DisplayPort (DP)">DisplayPort (DP)</option>
                        <option value="VGA">VGA</option>
                    </select>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarMonitor(this)">
                <i class="fas fa-trash"></i> Eliminar Monitor
            </button>
        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    monitorIndex++;
}

function eliminarMonitor(btn) {
    if (!confirm('¿Deseas eliminar este monitor?')) {
        return;
    }

    const item = btn.closest('.monitor-item');

    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    item.style.display = 'none';
}

//DISCOS DUROS.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-.-
const containerDiscoDuro = document.getElementById('discosDuros-container');
let discoDuroIndex = parseInt(containerDiscoDuro.dataset.discosCount);

function agregarDiscoDuro() {
    const container = document.getElementById('discosDuros-container');
    const html = `
    <div class="disco-item">
        <input type="hidden" name="discoDuros[${discoDuroIndex}][_delete]" value="">

        <div class="p-2 mb-2 border rounded bg-white">
            <h6 class="text-secondary">
                <i class="fas fa-dot-circle"></i> Disco Duro #${discoDuroIndex + 1}
            </h6>

            <div class="row">
                <div class="form-group col-md-4">
                    <label>Capacidad</label>
                    <select name="discoDuros[${discoDuroIndex}][capacidad]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="240GB">240GB</option>
                        <option value="480GB">480GB</option>
                        <option value="1TB">1TB</option>
                        <option value="2TB">2TB</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Tipo</label>
                    <select name="discoDuros[${discoDuroIndex}][tipo_hdd_ssd]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="SSD">SSD</option>
                        <option value="HDD">HDD</option>
                        <option value="M.2 NVMe">M.2 NVMe</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label>Interface</label>
                    <select name="discoDuros[${discoDuroIndex}][interface]" class="form-control form-control-sm">
                        <option value="">Seleccione...</option>
                        <option value="SATA">SATA</option>
                        <option value="PCIe">PCIe</option>
                    </select>
                </div>
            </div>

            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarDiscoDuro(this)">
                <i class="fas fa-trash"></i> Eliminar Disco
            </button>
        </div>
    </div>
    `;

    containerDiscoDuro.insertAdjacentHTML('beforeend', html);
    discoDuroIndex++;
}

function eliminarDiscoDuro(btn) {
    if (!confirm('¿Deseas eliminar este disco duro?')) {
        return;
    }

    const item = btn.closest('.disco-item');

    // 1. marcar eliminación
    const deleteInput = item.querySelector('[name$="[_delete]"]');
    if (deleteInput) {
        deleteInput.value = 1;
    }

    item.querySelectorAll('input:not([type="hidden"])')
        .forEach(input => input.value = '');

    // 3. ocultar visualmente
    item.style.display = 'none';
}
