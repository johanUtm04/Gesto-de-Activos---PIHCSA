<div class="periferico-item p-3 mb-5 border rounded bg-light shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-secondary mb-0">
            <i class="fas fa-desktop"></i> Periferico #
            <span class="numero-index badge badge-secondary">
                {{ is_numeric($index) ? $index + 1 : 'Nuevo' }} 
            </span>
        </h6>
        
        <button type="button" 
                onclick="eliminarComponente(this, 'periferico-item')" 
                class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <input type="hidden" name="periferico[{{ $index }}][id]" value="{{ $periferico->id ?? '' }}">
    <input type="hidden" name="periferico[{{ $index }}][_delete]" value="">

    <div class="row">
    <div class="form-group col-md-3">
        <label class="small font-weight-bold">Tipo de periférico</label>
        <select name="periferico[{{ $index }}][tipo]" class="form-control form-control-sm">
            <option value="">Seleccione...</option>
            @foreach([
                'Mouse',
                'Teclado',
                'Ratón',
                'Monitor',
                'Audífonos',
                'Diadema',
                'Bocinas',
                'Webcam',
                'Micrófono',
                'Impresora',
                'Escáner',
                'Control / Gamepad',
                'Tablet gráfica',
                'Otro'
            ] as $t)
                <option value="{{ $t }}" {{ ($periferico->tipo ?? '') == $t ? 'selected' : '' }}>
                    {{ $t }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-3">
        <label class="small font-weight-bold">Marca</label>
        <select name="periferico[{{ $index }}][marca]" class="form-control form-control-sm">
            <option value="">Seleccione...</option>
            @foreach([
                'Logitech',
                'HP',
                'Dell',
                'Lenovo',
                'Microsoft',
                'Razer',
                'Corsair',
                'SteelSeries',
                'HyperX',
                'Redragon',
                'Asus',
                'Acer',
                'Samsung',
                'LG',
                'BenQ',
                'Sony',
                'JBL',
                'Bose',
                'Epson',
                'Canon',
                'Brother',
                'Generic / Genérica',
                'Otra'
            ] as $marca)
                <option value="{{ $marca }}" {{ ($periferico->marca ?? '') == $marca ? 'selected' : '' }}>
                    {{ $marca }}
                </option>
            @endforeach
        </select>
    </div>


    <div class="form-group col-md-3">
        <label class="small font-weight-bold">Serial</label>
        <input type="text" name="periferico[{{ $index }}][serial]" 
                value="{{ $periferico->serial ?? '' }}" class="form-control form-control-sm" placeholder="S/N">
    </div>

    <div class="form-group col-md-3">
        <label class="small font-weight-bold">Interfaz / Conexión</label>
        <select name="periferico[{{ $index }}][interface]" class="form-control form-control-sm">
            <option value="">Seleccione...</option>
            @foreach([
                'USB',
                'USB-C',
                'Bluetooth',
                'Inalámbrico (2.4 GHz)',
                'HDMI',
                'DisplayPort',
                'Jack 3.5 mm',
                'PS/2',
                'Wi-Fi',
                'Otro'
            ] as $int)
                <option value="{{ $int }}" {{ ($periferico->interface ?? '') == $int ? 'selected' : '' }}>
                    {{ $int }}
                </option>
            @endforeach
        </select>
    </div>

    </div>
    <small class="text-muted">ID Sistema: {{ $periferico->id ?? 'Pendiente' }}</small>
</div>