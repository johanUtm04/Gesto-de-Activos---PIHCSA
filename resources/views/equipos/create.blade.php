@extends('adminlte::page')

@section('title', 'Registrar Nuevo Activo TI')

@section('css')
<style>
    .wizard-steps {
        font-size: 14px;
    }

    .wizard-step {
        color: #adb5bd;
    }

    .wizard-step i {
        font-size: 22px;
        margin-bottom: 4px;
        display: block;
    }

    .wizard-step.active {
        color: #28a745;
        font-weight: 600;
    }

    .fieldset-group {
        border: 1px solid #ced4da;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: .25rem;
        background-color: #ffffff;
    }

    .fieldset-group legend {
        width: inherit;
        padding: 0 10px;
        border-bottom: none;
        font-size: 1.1em;
        font-weight: 600;
        color: #007bff;
    }

    .fieldset-group i.fa-3x {
        opacity: 0.25;
    }

    .form-group label {
        font-weight: 500;
    }

    .custom-input {
    display: none;
    margin-top: 10px;
    }
</style>
@stop

@section('content_header')
<div class="mb-3">
    <h1 class="font-weight-bold mb-1">
        <i class="fas fa-plus-circle text-success"></i> Registrar Nuevo Activo
    </h1>
    <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Volver al inventario
    </a>
</div>

{{-- WIZARD --}}
<div class="card mb-3">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between text-center wizard-steps">
            <div class="wizard-step active">
                <i class="fas fa-desktop"></i>
                <div>Activo</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-map-marker-alt"></i>
                <div>Ubicacion</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-microchip"></i>
                <div>Componentes</div>
            </div>
            <div class="wizard-step">
                <i class="fas fa-flag-checkered"></i>
                <div>Final</div>
            </div>
        </div>
    </div>
</div>
@stop

@section('content')

{{-- ERRORES --}}
@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <strong><i class="fas fa-exclamation-triangle"></i> Revisa los datos</strong>
    <button type="button" class="close" data-dismiss="alert">
        <span>&times;</span>
    </button>
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('equipos.store') }}" method="POST">
@csrf

<div class="card card-outline card-success">
    <div class="card-body">

        <div class="row">

            {{-- COLUMNA IZQUIERDA --}}
            <div class="col-md-6">
                <fieldset class="fieldset-group">
                    <legend><i class="fas fa-info-circle"></i> Base del Activo</legend>

                    {{-- Silueta --}}
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-laptop fa-3x"></i>
                        <div class="small mt-1">Información del equipo</div>
                    </div>

                    <div class="form-group">
                    <label>Marca</label>
                    <select name="marca_equipo" id="marca_equipo" class="form-control">
                        <option value="" selected>Seleccione la marca del Activo</option>
                        <optgroup label="Cómputo y Servidores">
                            <option>Dell</option>
                            <option>HP</option>
                            <option>Lenovo</option>
                            <option>Apple</option>
                            <option>ASUS</option>
                            <option>Acer</option>
                            <option>MSI</option>
                            <option>Microsoft (Surface)</option>
                            <option>Huawei</option>
                            <option>Samsung</option>
                        </optgroup>

                        <optgroup label="Infraestructura">
                            <option>IBM</option>
                            <option>Supermicro</option>
                            <option>HPE</option>
                            <option>Oracle</option>
                            <option>Fujitsu</option>
                        </optgroup>

                        <optgroup label="Redes y Telecomunicaciones">
                            <option>Cisco</option>
                            <option>Ubiquiti</option>
                            <option>MikroTik</option>
                            <option>TP-Link</option>
                            <option>Aruba</option>
                            <option>Juniper</option>
                            <option>Fortinet</option>
                            <option>Huawei</option>
                        </optgroup>

                        <optgroup label="Impresión">
                            <option>HP</option>
                            <option>Epson</option>
                            <option>Canon</option>
                            <option>Brother</option>
                            <option>Xerox</option>
                            <option>Ricoh</option>
                            <option>Lexmark</option>
                            <option>Kyocera</option>
                        </optgroup>

                        <optgroup label="Almacenamiento">
                            <option>Seagate</option>
                            <option>Western Digital</option>
                            <option>Kingston</option>
                            <option>Samsung</option>
                            <option>Crucial</option>
                            <option>SanDisk</option>
                            <option>Synology</option>
                            <option>QNAP</option>
                        </optgroup>

                        <optgroup label="Periféricos">
                            <option>Logitech</option>
                            <option>HP</option>
                            <option>Dell</option>
                            <option>Microsoft</option>
                            <option>Razer</option>
                            <option>HyperX</option>
                            <option>SteelSeries</option>
                            <option>Genius</option>
                        </optgroup>

                        <optgroup label="Energía y Protección">
                            <option>APC</option>
                            <option>Tripp Lite</option>
                            <option>Eaton</option>
                            <option>CyberPower</option>
                            <option>Forza</option>
                        </optgroup>

                        <optgroup label="Seguridad">
                            <option>Hikvision</option>
                            <option>Dahua</option>
                            <option>ZKTeco</option>
                            <option>Bosch</option>
                        </optgroup>

                        <optgroup label="Otros">
                            <option>Genérico</option>
                            <option value="OTRO_VALOR">--Otro--</option>
                        </optgroup>
                    </select>
                        <input type="text" id="marca_equipo_input" 
                        class="form-control custom-input" 
                        placeholder="Escriba el campos"
                        name="marca_equipo_input"  
                        value="">
                    </div>

                    <div class="form-group">
                        <label>Tipo de activo </label>
                        <select name="tipo_equipo" id="tipo_equipo" class="form-control" required>
                            <option value="" disabled selected>Seleccione el tipo de activo</option>

                            <optgroup label="Equipos de Cómputo">
                                <option value="Laptop">Laptop</option>
                                <option value="PC Escritorio">PC de Escritorio</option>
                                <option value="All in One">All in One</option>
                                <option value="Workstation">Workstation</option>
                                <option value="Thin Client">Thin Client</option>
                                <option value="Servidor">Servidor</option>
                            </optgroup>

                            <optgroup label="Dispositivos Móviles">
                                <option value="Tablet">Tablet</option>
                                <option value="Smartphone">Smartphone</option>
                                <option value="PDA / Handheld">PDA / Handheld</option>
                            </optgroup>

                            <optgroup label="Impresión y Digitalización">
                                <option value="Impresora">Impresora</option>
                                <option value="Multifuncional">Multifuncional</option>
                                <option value="Escáner">Escáner</option>
                                <option value="Plotter">Plotter</option>
                            </optgroup>

                            <optgroup label="Redes y Comunicaciones">
                                <option value="Router">Router</option>
                                <option value="Switch">Switch</option>
                                <option value="Access Point">Access Point</option>
                                <option value="Firewall">Firewall</option>
                                <option value="Modem">Módem</option>
                            </optgroup>

                            <optgroup label="Periféricos">
                                <option value="Monitor">Monitor</option>
                                <option value="Teclado">Teclado</option>
                                <option value="Mouse">Mouse</option>
                                <option value="Webcam">Webcam</option>
                                <option value="Bocinas">Bocinas</option>
                                <option value="Audífonos">Audífonos</option>
                                <option value="Proyector">Proyector</option>
                            </optgroup>

                            <optgroup label="Almacenamiento">
                                <option value="Disco Duro HDD">Disco Duro (HDD)</option>
                                <option value="Disco Estado Solido SSD">Disco de Estado Sólido (SSD)</option>
                                <option value="NAS">NAS</option>
                                <option value="SAN">SAN</option>
                                <option value="Unidad Externa">Unidad Externa</option>
                            </optgroup>

                            <optgroup label="Seguridad">
                                <option value="Camara CCTV">Cámara CCTV</option>
                                <option value="Control de Acceso">Control de Acceso</option>
                                <option value="Biometrico">Biométrico</option>
                            </optgroup>

                            <optgroup label="Otros">
                                <option value="Licencia de Software">Licencia de Software</option>
                                <option value="UPS">UPS / No Break</option>
                                <option value="OTRO_VALOR">--Otro--</option>
                            </optgroup>
                        </select>
                        <input type="text" id="tipo_equipo_input" 
                        class="form-control custom-input" 
                        placeholder="Escriba el campos"
                        name="tipo_equipo_input"  
                        value="">
                    </div>


                    <div class="form-group">
                        <label>Serial</label>
                        <input type="text" name="serial" class="form-control"
                               placeholder="Número de serie"
                               value="{{ old('serial', $equipo['serial'] ?? '') }}">
                        <small class="form-text text-muted">
                            Identificador único del activo
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Sistema Operativo</label>
                        <select name="sistema_operativo" class="form-control" required>
                            <option value="" disabled selected>Seleccione el sistema operativo</option>

                            <optgroup label="Windows">
                                <option>Windows 11</option>
                                <option>Windows 10</option>
                                <option>Windows 8.1</option>
                                <option>Windows 7</option>
                                <option>Windows Server 2022</option>
                                <option>Windows Server 2019</option>
                                <option>Windows Server 2016</option>
                            </optgroup>

                            <optgroup label="macOS">
                                <option>macOS Sonoma</option>
                                <option>macOS Ventura</option>
                                <option>macOS Monterey</option>
                                <option>macOS Big Sur</option>
                                <option>macOS Catalina</option>
                            </optgroup>

                            <optgroup label="Linux">
                                <option>Ubuntu</option>
                                <option>Ubuntu LTS</option>
                                <option>Debian</option>
                                <option>CentOS</option>
                                <option>Rocky Linux</option>
                                <option>AlmaLinux</option>
                                <option>Red Hat Enterprise Linux</option>
                                <option>Fedora</option>
                                <option>Arch Linux</option>
                            </optgroup>

                            <optgroup label="Sistemas Móviles">
                                <option>Android</option>
                                <option>iOS</option>
                            </optgroup>

                            <optgroup label="Virtualización / Hipervisores">
                                <option>VMware ESXi</option>
                                <option>Proxmox VE</option>
                                <option>Hyper-V</option>
                                <option>XenServer</option>
                            </optgroup>

                            <optgroup label="Otros">
                                <option>Chrome OS</option>
                                <option>FreeBSD</option>
                                <option>No aplica</option>
                            </optgroup>
                        </select>
                    </div>

                </fieldset>
            </div>

            {{-- COLUMNA DERECHA --}}
            <div class="col-md-6">
                <fieldset class="fieldset-group">
                    <legend><i class="fas fa-clipboard-check"></i> Asignación y Valor</legend>

                    {{-- Silueta --}}
                    <div class="text-center mb-3 text-muted">
                        <i class="fas fa-user-cog fa-3x"></i>
                        <div class="small mt-1">Responsable y valor</div>
                    </div>

                    <div class="form-group">
                        <label>Usuario responsable </label>
                        <select name="usuario_id" class="form-control select2" required>
                            <option value="">Seleccione un usuario</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ old('usuario_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label>Valor inicial </label>
                        <input type="number" name="valor_inicial" class="form-control"
                        step="0.01" placeholder="15000.00"
                        value="{{ old('valor_inicial', $equipo['valor_inicial'] ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Fecha de adquisición </label>
                        <input type="date" name="fecha_adquisicion" class="form-control"
                               value="{{ old('fecha_adquisicion', $equipo['fecha_adquisicion'] ?? '') }}" required>
                    </div>

                    <!-- Input con select asociado -->
                    <div class="form-group">
                        <label>Vida útil estimada </label>
                            <div class="input-group">
                            <select class="form-control" name="vida_util_unidad" required>
                                <option value="" disabled selected>Seleccione unidad</option>
                                <option value="años">Años</option>
                                <option value="meses">Meses</option>
                            </select>
                        </div>
                        <input 
                        type="number"
                        name="vida_util_estimada" 
                        class="form-control"
                        placeholder="Cantidad"
                        value="{{ old('vida_util_estimada', $equipo['vida_util_estimada'] ?? '') }}" 
                         disabled
                        required>
                    </div>
                </fieldset>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <div class="card-footer text-right">
        <button type="submit" class="btn btn-success btn-lg">
            <i class="fas fa-arrow-right"></i> Continuar
        </button>
        
        <a href="{{ route('equipos.index') }}" class="btn btn-secondary btn-lg">
            Cancelar
        </a>
    </div>
</div>
</form>

@stop


@section('js')
<script>
    //Tomamos el nombre del select y del input para poder hacer operaciones con ellos 
    const unidad = document.querySelector('[name="vida_util_unidad"]');
    const valor = document.querySelector('[name="vida_util_estimada"]');

    //Evento que se ejeucta cada que el usuario cambia la opcion de Select 
    unidad.addEventListener('change', () => {
        valor.disabled =false;
        valor.placeholder = unidad.value === 'años'
        ? 'Ej. 5' : 'Ej. 60';
    });

    //1.-JavaScript para input dinamico
    $(document).ready(function() {
    function setupSelectOtro(selectId, inputId) {
        const $select = $(`#${selectId}`);
        const $input = $(`#${inputId}`);

        //Si se nota un cambio en la etiqueta <select>
        $select.on('change', function() {


            if ($(this).val() === 'OTRO_VALOR') {
                $input
                .val('')  
                .fadeIn().
                focus();
            } else {
                $input
                .hide()
                .val(''); 
            }
        });
    }
    //Select | Input Oculto
    setupSelectOtro('marca_equipo', 'marca_equipo_input');
    setupSelectOtro('tipo_equipo', 'tipo_equipo_input');

});

</script>
@stop