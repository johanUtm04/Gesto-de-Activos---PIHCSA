@extends('adminlte::page')

@section('title', 'Editar Equipo | Activos TI')

@section('css')
<style>
    .section-title { border-bottom: 2px solid #007bff; padding-bottom: 5px; margin-bottom: 15px;color: #17a2b8; font-weight: 600;}

    .data-item { margin-bottom: 10px; padding-bottom: 5px; border-bottom: 1px dashed #ced4da;}

    .data-item:last-child {border-bottom: none;}

    .data-label {font-weight: 600;color: #495057;}

    .component-group {border: 1px solid #dee2e6;border-radius: .25rem;padding: 15px;margin-bottom: 20px;background-color: #f8f9fa;}
</style>
@stop

@section('content_header')
    <h1 class="font-weight-bold text-center">
        <i class="fas fa-desktop text-primary"></i> 
        Edición de Activo: {{ strtoupper($equipo->marca_equipo) }}
    </h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-outline-secondary btn-sm mt-2">
        <i class="fas fa-arrow-circle-left"></i> Volver a Inventario
    </a>
@stop


@section('content')
    <div class="container-fluid">
        <div class="row">

            {{-- COLUMNA IZQUIERDA: DATOS ACTUALES Y RELACIONES (Visibilidad) --}}
            <div class="col-md-5">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clipboard-list"></i> **Detalle y Estado Actual**
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <h5 class="section-title"><i class="fas fa-cogs"></i> Especificaciones Generales</h5>
                        
                        {{-- Datos Principales --}}
                        <div class="data-item">
                            <span class="data-label">Marca/Modelo:</span> 
                            <span class="float-right">{{ $equipo->marca_equipo }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Tipo de Equipo:</span> 
                            <span class="float-right">{{ $equipo->tipo_equipo }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Serial:</span> 
                            <span class="float-right text-bold">{{ $equipo->serial }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label"><i class="fab fa-windows"></i> S. Operativo:</span> 
                            <span class="float-right">{{ $equipo->sistema_operativo }}</span>
                        </div>
                        
                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-users-cog"></i> Responsabilidad y Ubicación</h5>

                        <div class="data-item">
                            <span class="data-label"><i class="fas fa-user-tag"></i> Usuario:</span> 
                            <span class="float-right text-primary">{{ $equipo->usuario->name ?? 'Sin asignar' }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label"><i class="fas fa-map-marker-alt"></i> Ubicación:</span> 
                            <span class="float-right text-primary">{{ $equipo->ubicacion->nombre ?? 'Sin ubicar' }}</span>
                        </div>

                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-money-bill-wave"></i> Información Contable</h5>

                        <div class="data-item">
                            <span class="data-label">Valor Inicial:</span> 
                            <span class="float-right text-success text-bold">${{ number_format($equipo->valor_inicial, 2) }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">F. Adquisición:</span> 
                            <span class="float-right">{{ $equipo->fecha_adquisicion }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Vida Útil Estimada:</span> 
                            <span class="float-right">{{ $equipo->vida_util_estimada }}</span>
                        </div>

                        <hr class="mt-4">

                        <h5 class="section-title"><i class="fas fa-puzzle-piece"></i> Componentes Asociados ({{ $equipo->perifericos->count() + $equipo->rams->count() + $equipo->procesadores->count() + $equipo->monitores->count() + $equipo->discosDuros->count() }})</h5>

                        {{-- Detalle Periféricos --}}
                        <h6><i class="fas fa-keyboard text-warning"></i> **Periféricos ({{ $equipo->perifericos->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->perifericos as $p)
                                <li>- {{ $p->tipo }} (Serial: {{ $p->serial }})</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle RAMs --}}
                        <h6><i class="fas fa-memory text-warning"></i> **RAM ({{ $equipo->rams->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->rams as $r)
                                <li>- {{ $r->capacidad_gb }}GB | {{ $r->tipo_chz }}</li>
                            @empty
                                <li class="text-muted">Ninguna.</li>
                            @endforelse
                        </ul>
                        
                        {{-- Detalle Procesadores --}}
                        <h6><i class="fas fa-microchip text-warning"></i> **Procesador ({{ $equipo->procesadores->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->procesadores as $proc)
                                <li>- {{ $proc->marca }} | {{ $proc->descripcion_tipo }}</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle Monitores --}}
                        <h6><i class="fas fa-tv text-warning"></i> **Monitores ({{ $equipo->monitores->count() }})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->monitores as $mon)
                                <li>- {{ $mon->marca }} ({{ $mon->escala_pulgadas }}")</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                        {{-- Detalle Discos Duros --}}
                        <h6><i class="fas fa-hdd text-warning"></i> **Discos ({{ $equipo->discosDuros->count()}})**</h6>
                        <ul class="list-unstyled mb-3 ml-3">
                            @forelse($equipo->discosDuros as $dd)
                                <li>- {{ $dd->capacidad }} {{ $dd->tipo_hdd_ssd }}</li>
                            @empty
                                <li class="text-muted">Ninguno.</li>
                            @endforelse
                        </ul>

                    </div> {{-- /card-body --}}
                </div> {{-- /card --}}
            </div> {{-- /col-md-5 --}}

            {{-- COLUMNA DERECHA: FORMULARIO DE EDICIÓN (Funcionalidad) --}}
            <div class="col-md-7">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-pen-square"></i> **Modificación de Datos**
                        </h3>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                            @csrf
                            @method('PUT')

                            {{-- SECCIÓN DATOS GENERALES EDITABLES --}}
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2 text-primary"><i class="fas fa-info-circle"></i> Datos Base</legend>

                                <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="marca_equipo"><i class="fas fa-tag"></i> Marca del Equipo</label>
                                    <select name="marca_equipo" id="marca_equipo" class="form-control">
                                        <option value="" {{ old('marca_equipo', $equipo->marca_equipo) == '' ? 'selected' : '' }}>Seleccione la marca</option>
                                        
                                        @php
                                            // Definimos los grupos y sus marcas para una gestión más limpia
                                            $categorias = [
                                                'Cómputo y Servidores' => ['Dell', 'HP', 'Lenovo', 'Apple', 'ASUS', 'Acer', 'MSI', 'Microsoft (Surface)', 'Huawei', 'Samsung'],
                                                'Infraestructura' => ['IBM', 'Supermicro', 'HPE', 'Oracle', 'Fujitsu'],
                                                'Redes y Telecomunicaciones' => ['Cisco', 'Ubiquiti', 'MikroTik', 'TP-Link', 'Aruba', 'Juniper', 'Fortinet', 'Huawei'],
                                                'Impresión' => ['HP', 'Epson', 'Canon', 'Brother', 'Xerox', 'Ricoh', 'Lexmark', 'Kyocera'],
                                                'Otros' => ['Genérico', 'Otra']
                                            ];
                                            $marcaActual = old('marca_equipo', $equipo->marca_equipo);
                                        @endphp

                                        @foreach($categorias as $categoria => $marcas)
                                            <optgroup label="{{ $categoria }}">
                                                @foreach($marcas as $marca)
                                                    <option value="{{ $marca }}" {{ $marcaActual == $marca ? 'selected' : '' }}>
                                                        {{ $marca }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="tipo_equipo"><i class="fas fa-laptop"></i> Tipo de Equipo</label>
                                    <select name="tipo_equipo" id="tipo_equipo" class="form-control">
                                        <option value="" {{ old('tipo_equipo', $equipo->tipo_equipo) == '' ? 'selected' : '' }}>Seleccione el tipo</option>
                                        
                                        @php
                                            // Definimos las categorías y los tipos de equipos para una gestión más limpia
                                            $categoriasEquipos = [
                                                'Dispositivos de Usuario' => ['Laptop', 'Desktop', 'All-in-One', 'Tablet', 'Smartphone', 'Workstation'],
                                                'Infraestructura' => ['Servidor', 'Rack', 'Switch', 'Router', 'Access Point', 'Firewall', 'UPS'],
                                                'Periféricos' => ['Monitor', 'Impresora', 'Multifuncional', 'Escáner', 'Proyector', 'Cámara'],
                                                'Otros' => ['Genérico', 'Otro']
                                            ];
                                            $tipoActual = old('tipo_equipo', $equipo->tipo_equipo);
                                        @endphp

                                        @foreach($categoriasEquipos as $categoria => $tipos)
                                            <optgroup label="{{ $categoria }}">
                                                @foreach($tipos as $tipo)
                                                    <option value="{{ $tipo }}" {{ $tipoActual == $tipo ? 'selected' : '' }}>
                                                        {{ $tipo }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    </select>
                                </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="serial"><i class="fas fa-barcode"></i> Serial</label>
                                        <input type="text" name="serial" id="serial" class="form-control"
                                            value="{{ old('serial', $equipo->serial) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="sistema_operativo"><i class="fab fa-windows"></i> Sistema Operativo</label>
                                        <select name="sistema_operativo" id="sistema_operativo" class="form-control" required>
                                            <option value="" disabled {{ old('sistema_operativo', $equipo->sistema_operativo) == '' ? 'selected' : '' }}>
                                                Seleccione el sistema operativo
                                            </option>

                                            @php
                                                $soActual = old('sistema_operativo', $equipo->sistema_operativo);
                                                
                                                $categoriasSO = [
                                                    'Windows' => ['Windows 11', 'Windows 10', 'Windows 8.1', 'Windows 7', 'Windows Server 2022', 'Windows Server 2019', 'Windows Server 2016'],
                                                    'macOS' => ['macOS Sonoma', 'macOS Ventura', 'macOS Monterey', 'macOS Big Sur', 'macOS Catalina'],
                                                    'Linux' => ['Ubuntu', 'Ubuntu LTS', 'Debian', 'CentOS', 'Rocky Linux', 'AlmaLinux', 'Red Hat Enterprise Linux', 'Fedora', 'Arch Linux'],
                                                    'Sistemas Móviles' => ['Android', 'iOS'],
                                                    'Virtualización / Hipervisores' => ['VMware ESXi', 'Proxmox VE', 'Hyper-V', 'XenServer'],
                                                    'Otros' => ['Chrome OS', 'FreeBSD', 'Otro', 'No aplica']
                                                ];
                                            @endphp

                                            @foreach($categoriasSO as $grupo => $opciones)
                                                <optgroup label="{{ $grupo }}">
                                                    @foreach($opciones as $opcion)
                                                        <option value="{{ $opcion }}" {{ $soActual == $opcion ? 'selected' : '' }}>
                                                            {{ $opcion }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>

                            {{-- SECCIÓN DATOS ASOCIADOS (Dropdowns) --}}
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2 text-primary"><i class="fas fa-link"></i> Asignación</legend>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="usuario_id"><i class="fas fa-user-tag"></i> Usuario Responsable</label>
                                        <select name="usuario_id" id="usuario_id" class="form-control select2" data-placeholder="Seleccione un usuario">
                                            <option value="">Seleccione...</option>
                                            @foreach($usuarios as $usuario)
                                            <option value="{{ $usuario->id }}"
                                                {{ $equipo->usuario_id == $usuario->id ? 'selected' : '' }}>
                                                {{ $usuario->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="ubicacion_id"><i class="fas fa-map-marker-alt"></i> Ubicación</label>
                                        <select name="ubicacion_id" id="ubicacion_id" class="form-control select2" data-placeholder="Seleccione la ubicación">
                                            <option value="">Seleccione...</option>
                                            @foreach($ubicaciones as $ubicacion)
                                            <option value="{{ $ubicacion->id }}"
                                                {{ $equipo->ubicacion_id == $ubicacion->id ? 'selected' : '' }}>
                                                {{ $ubicacion->nombre }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label for="valor_inicial"><i class="fas fa-dollar-sign"></i> Valor Inicial</label>
                                        <input type="number" name="valor_inicial" id="valor_inicial" class="form-control" step="0.01"
                                            value="{{ old('valor_inicial', $equipo->valor_inicial) }}">
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="fecha_adquisicion"><i class="fas fa-calendar-alt"></i> Fecha de Adquisición</label>
                                        <input type="date" name="fecha_adquisicion" id="fecha_adquisicion" class="form-control"
                                            value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}">
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="vida_util_estimada"><i class="fas fa-hourglass-half"></i> Vida Útil Estimada</label>
                                        <div class="input-group">
                                            <select class="form-control" name="vida_util_unidad" id="vida_util_unidad" required>
                                                @php
                                                    $unidadActual = old('vida_util_unidad', $equipo->vida_util_unidad ?? '');
                                                @endphp
                                                <option value="" disabled {{ $unidadActual == '' ? 'selected' : '' }}>Unidad</option>
                                                <option value="años" {{ $unidadActual == 'años' ? 'selected' : '' }}>Años</option>
                                                <option value="meses" {{ $unidadActual == 'meses' ? 'selected' : '' }}>Meses</option>
                                            </select>

                                            <input 
                                                type="number" 
                                                name="vida_util_estimada" 
                                                id="vida_util_input"
                                                class="form-control" 
                                                style="width: 50%;"
                                                placeholder="Cantidad"
                                                min="1"
                                                value="{{ old('vida_util_estimada', $equipo->vida_util_estimada) }}" 
                                                {{ $unidadActual ? '' : 'disabled' }}
                                                required>
                                        </div>
                                    </div>

                                    <script>
                                        document.getElementById('vida_util_unidad').addEventListener('change', function() {
                                            const inputPrecio = document.getElementById('vida_util_input');
                                            if (this.value !== "") {
                                                inputPrecio.disabled = false;
                                            }
                                        });
                                    </script>
                                </div>
                            </fieldset>


                            {{-- SECCIÓN COMPONENTES EDITABLES --}}
                            <h5 class="section-title mt-4"><i class="fas fa-tools"></i> Edición Detallada de Componentes</h5>

                            <div id="componentes-editables">

                                {{-- Periféricos --}}
                                <div class="component-group">
                                    <h6 class="text-info pl-3 border-left border-info font-weight-bold" style="border-left-width: 4px !important; line-height: 1.5;">
                                        <i class="fas fa-keyboard mr-2"></i> PERIFÉRICOS (EDITABLES)
                                    </h6>
                                        <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarPeriferico()">
                                        <i class="fas fa-plus"></i> Agregar periférico
                                    </button>
                                    <hr class="my-2">
                                    <div id="perifericos-container"
                                     data-perifericos-count="{{ $equipo->perifericos->count() }}">
                                    @foreach($equipo->perifericos as $index => $periferico)
                                    <div class="periferico-item p-2 mb-2 border rounded bg-white">
                                        <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> Periférico #{{ $index + 1 }} </h6>
                                        <input type="hidden" name="perifericos[{{ $index }}][id]" value="{{ $periferico->id }}"> 
                                        <input type="hidden" name="perifericos[{{ $index }}][_delete]" value="">

                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Tipo / Categoría</label>
                                                <select name="perifericos[{{ $index }}][tipo]" class="form-control form-control-sm">
                                                    <option value="">Seleccione tipo...</option>
                                                    <option value="Teclado" {{ $periferico->tipo == 'Teclado' ? 'selected' : '' }}>Teclado</option>
                                                    <option value="Mouse" {{ $periferico->tipo == 'Mouse' ? 'selected' : '' }}>Mouse</option>
                                                    <option value="Monitor" {{ $periferico->tipo == 'Monitor' ? 'selected' : '' }}>Monitor</option>
                                                    <option value="Diadema" {{ $periferico->tipo == 'Diadema' ? 'selected' : '' }}>Diadema</option>
                                                    <option value="Cámara" {{ $periferico->tipo == 'Cámara' ? 'selected' : '' }}>Cámara</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Marca</label>
                                                <select name="perifericos[{{ $index }}][marca]" class="form-control form-control-sm">
                                                    <option value="">Seleccione marca...</option>
                                                    <option value="Logitech" {{ $periferico->marca == 'Logitech' ? 'selected' : '' }}>Logitech</option>
                                                    <option value="HP" {{ $periferico->marca == 'HP' ? 'selected' : '' }}>HP</option>
                                                    <option value="Dell" {{ $periferico->marca == 'Dell' ? 'selected' : '' }}>Dell</option>
                                                    <option value="Genius" {{ $periferico->marca == 'Genius' ? 'selected' : '' }}>Genius</option>
                                                    <option value="Otro" {{ $periferico->marca == 'Otro' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>Serial</label>
                                                <input type="text" name="perifericos[{{ $index }}][serial]" 
                                                    class="form-control form-control-sm" 
                                                    placeholder="Serial del periférico"
                                                    value="{{ old('perifericos.' . $index . '.serial', $periferico->serial ?? '') }}">
                                            </div>

                                            <div class="form-group col-md-6">
                                                <label>Interfaz</label>
                                                <select name="perifericos[{{ $index }}][interface]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['HDMI', 'DisplayPort (DP)', 'VGA', 'DVI', 'USB-C'] as $interface)
                                                        <option value="{{ $interface }}" {{ $periferico->interface == $interface ? 'selected' : '' }}>{{ $interface }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarPeriferico(this)">
                                            <i class="fas fa-trash"></i> Eliminar periférico
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- Rams --}}
                                <div class="component-group">

                                    <h6 class="text-info pl-3 border-left border-info font-weight-bold" style="border-left-width: 4px !important; line-height: 1.5;">
                                        <i class="fas fa-memory mr-2"></i> MÓDULOS RAM (EDITABLES)
                                    </h6>                                    
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarRam()">
                                        <i class="fas fa-plus"></i> Agregar Ram
                                    </button>
                                    
                                    <hr class="my-2">
                                    <div id="rams-container"
                                     data-rams-count="{{ $equipo->rams->count() }}">
                                    @foreach($equipo->rams as $index => $ram)
                                    <div class="ram-item p-2 mb-2 border rounded bg-white">
                                        <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> RAM #{{ $index + 1 }} </h6>
                                        <input type="hidden" name="rams[{{ $index }}][id]" value="{{ $ram->id }}">
                                        <input type="hidden" name="rams[{{ $index }}][_delete]" value="">
                                        
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>Capacidad (GB)</label>
                                                <select name="rams[{{ $index }}][capacidad_gb]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach([2, 4, 8, 16, 32, 64] as $cap)
                                                        <option value="{{ $cap }}" {{ (old('rams.'.$index.'.capacidad_gb', $ram->capacidad_gb) == $cap) ? 'selected' : '' }}>{{ $cap }} GB</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-4">
                                                <label>Clock (MHz)</label>
                                                <select name="rams[{{ $index }}][clock_mhz]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach([1600, 2133, 2400, 2666, 3000, 3200, 3600, 4800, 5200, 5600, 6000] as $freq)
                                                        <option value="{{ $freq }}" {{ (old('rams.'.$index.'.clock_mhz', $ram->clock_mhz) == $freq) ? 'selected' : '' }}>{{ $freq }} MHz</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Tipo (DDR)</label>
                                                <select name="rams[{{ $index }}][tipo_chz]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['DDR3', 'DDR3L', 'DDR4', 'DDR5', 'LPDDR4', 'LPDDR5'] as $tipo)
                                                        <option value="{{ $tipo }}" {{ (old('rams.'.$index.'.tipo_chz', $ram->tipo_chz) == $tipo) ? 'selected' : '' }}>{{ $tipo }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarRam(this)">
                                            <i class="fas fa-trash"></i> Eliminar Ram
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- Procesadores --}}
                                <div class="component-group">
                                <h6 class="text-info pl-3 border-left border-info font-weight-bold" style="border-left-width: 4px !important; line-height: 1.5;">
                                    <i class="fas fa-microchip mr-2"></i> PROCESADORES (EDITABLES)
                                </h6>                                        
                                        <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarProcesador()">
                                        <i class="fas fa-plus"></i> Agregar Procesador
                                    </button>
                                    <hr class="my-2">
                                    <div id="procesadores-container"data-procesadores-count="{{ $equipo->procesadores->count() }}">
                                    @foreach($equipo->procesadores as $index => $procesador)
                                    <div class="procesador-item p-2 mb-2 border rounded bg-white">
                                        <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> Procesador #{{ $index + 1 }} </h6>
                                        <input type="hidden" name="procesadores[{{ $index }}][id]" value="{{ $procesador->id }}">
                                        <input type="hidden" name="procesadores[{{ $index }}][_delete]" value="">
                                        
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>Marca</label>
                                                <select name="procesadores[{{ $index }}][marca]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    <option value="Intel" {{ (old('procesadores.'.$index.'.marca', $procesador->marca) == 'Intel') ? 'selected' : '' }}>Intel</option>
                                                    <option value="AMD" {{ (old('procesadores.'.$index.'.marca', $procesador->marca) == 'AMD') ? 'selected' : '' }}>AMD</option>
                                                    <option value="Apple" {{ (old('procesadores.'.$index.'.marca', $procesador->marca) == 'Apple') ? 'selected' : '' }}>Apple (M1/M2/M3)</option>
                                                    <option value="Otro" {{ (old('procesadores.'.$index.'.marca', $procesador->marca) == 'Otro') ? 'selected' : '' }}>Otro</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group col-md-8">
                                                <label>Descripción / Modelo</label>
                                                <input type="text" name="procesadores[{{$index}}][descripcion_tipo]" 
                                                    class="form-control form-control-sm"
                                                    value="{{ old('procesadores.' . $index . '.descripcion_tipo', $procesador->descripcion_tipo ?? '') }}" 
                                                    placeholder="Ej: Core i5-10400F / Ryzen 5 5600G">
                                            </div> 
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarProcesador(this)">
                                            <i class="fas fa-trash"></i> Eliminar Procesador
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- Monitores --}}
                                <div class="component-group">
                                    <h6 class="text-info pl-3 border-left border-info font-weight-bold" style="border-left-width: 4px !important; line-height: 1.5;">
                                        <i class="fas fa-tv mr-2"></i> MONITORES (EDITABLES)
                                    </h6>                                    
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarMonitor()">
                                        <i class="fas fa-plus"></i> Agregar Procesador
                                    </button>
                                    <hr class="my-2">
                                   <div id="monitores-container"
                                    data-monitores-count="{{ $equipo->monitores->count() }}">
                                    @foreach($equipo->monitores as $index => $monitor)
                                    <div class="monitor-item p-2 mb-2 border rounded bg-white">
                                        <h6 class="text-secondary"><i class="fas fa-dot-circle"></i> Monitor #{{ $index + 1 }}</h6>

                                        <input type="hidden" name="monitores[{{ $index }}][id]" value="{{ $monitor->id }}">
                                        <input type="hidden" name="monitores[{{ $index }}][_delete]" value="">

                                        <div class="row">
                                            <div class="form-group col-md-3">
                                                <label>Marca</label>
                                                <select name="monitores[{{ $index }}][marca]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['HP', 'Dell', 'Lenovo', 'LG', 'Samsung', 'Acer', 'Asus', 'ViewSonic', 'BenQ'] as $marca)
                                                        <option value="{{ $marca }}" {{ $monitor->marca == $marca ? 'selected' : '' }}>{{ $marca }}</option>
                                                    @endforeach
                                                    <option value="Otra" {{ !in_array($monitor->marca, ['HP', 'Dell', 'Lenovo', 'LG', 'Samsung', 'Acer', 'Asus', 'ViewSonic', 'BenQ']) ? 'selected' : '' }}>Otra</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Serial</label>
                                                <input type="text" name="monitores[{{ $index }}][serial]" class="form-control form-control-sm" value="{{ $monitor->serial }}" placeholder="Serial único">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Pulgadas</label>
                                                <select name="monitores[{{ $index }}][escala_pulgadas]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['17', '19', '20', '21', '22', '24', '27', '32'] as $pulg)
                                                        <option value="{{ $pulg }}" {{ $monitor->escala_pulgadas == $pulg ? 'selected' : '' }}>{{ $pulg }}"</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label>Interfaz</label>
                                                <select name="monitores[{{ $index }}][interface]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['HDMI', 'DisplayPort (DP)', 'VGA', 'DVI', 'USB-C'] as $inter)
                                                        <option value="{{ $inter }}" {{ $monitor->interface == $inter ? 'selected' : '' }}>{{ $inter }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarMonitor(this)">
                                            <i class="fas fa-trash"></i> Eliminar Monitor
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- Discos Duros --}}
                                <div class="component-group">
                                    <h6 class="text-info pl-3 border-left border-info font-weight-bold" style="border-left-width: 4px !important; line-height: 1.5;">
                                    <i class="fas fa-hdd mr-2"></i> DISCOS DUROS (EDITABLES)
                                    </h6>
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary mt-2"
                                        onclick="agregarDiscoDuro()">
                                        <i class="fas fa-plus"></i> Agregar Disco Duro
                                    </button>

                                    <hr class="my-2">

                                    {{-- SOLO discos aquí --}}
                                    <div id="discosDuros-container" 
                                    data-discos-count="{{ $equipo->discosDuros->count() }}">
                                    @foreach($equipo->discosDuros as $index => $discoDuro)
                                    <div class="disco-item p-2 mb-2 border rounded bg-white">
                                        <h6 class="text-secondary">
                                            <i class="fas fa-dot-circle"></i> Disco Duro #{{ $index + 1 }}
                                        </h6>

                                        <input type="hidden" name="discoDuros[{{ $index }}][id]" value="{{ $discoDuro->id }}">
                                        <input type="hidden" name="discoDuros[{{ $index }}][_delete]" value="">

                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>Capacidad</label>
                                                <select name="discoDuros[{{$index}}][capacidad]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    @foreach(['120GB', '240GB', '480GB', '500GB', '1TB', '2TB', '4TB'] as $cap)
                                                        <option value="{{ $cap }}" {{ $discoDuro->capacidad == $cap ? 'selected' : '' }}>{{ $cap }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Tipo</label>
                                                <select name="discoDuros[{{$index}}][tipo_hdd_ssd]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    <option value="SSD" {{ $discoDuro->tipo_hdd_ssd == 'SSD' ? 'selected' : '' }}>SSD (Sólido)</option>
                                                    <option value="HDD" {{ $discoDuro->tipo_hdd_ssd == 'HDD' ? 'selected' : '' }}>HDD (Mecánico)</option>
                                                    <option value="M.2 NVMe" {{ $discoDuro->tipo_hdd_ssd == 'M.2 NVMe' ? 'selected' : '' }}>M.2 NVMe</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label>Interface</label>
                                                <select name="discoDuros[{{$index}}][interface]" class="form-control form-control-sm">
                                                    <option value="">Seleccione...</option>
                                                    <option value="SATA" {{ $discoDuro->interface == 'SATA' ? 'selected' : '' }}>SATA</option>
                                                    <option value="PCIe" {{ $discoDuro->interface == 'PCIe' ? 'selected' : '' }}>PCIe</option>
                                                    <option value="USB" {{ $discoDuro->interface == 'USB' ? 'selected' : '' }}>USB (Externo)</option>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="eliminarDiscoDuro(this)">
                                            <i class="fas fa-trash"></i> Eliminar Disco
                                        </button>
                                    </div>
                                    @endforeach
                                    </div>
                                </div>

                                {{-- BOTÓN FINAL (FUERA DE TODO COMPONENT-GROUP) --}}
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-success btn-lg btn-block">
                                        <i class="fas fa-database"></i> Aplicar Cambios y Registrar Historial
                                    </button>
                                </div>
                        </form>
                    </div> {{-- /card-body --}}
                </div> {{-- /card --}}
            </div> {{-- /col-md-7 --}}
        </div> {{-- row --}}
    </div> {{-- container --}}

@stop

{{-- -------------------------------------------------------------------------------- --}}
@section('js')
    {{-- Llamada al archivo externo --}}
    <script src="{{ asset('js/equipos/edit-equipos.js') }}"></script>
@stop