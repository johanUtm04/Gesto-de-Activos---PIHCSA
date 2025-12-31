<div class="discoDuro-item p-3 mb-5 border rounded bg-light shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-secondary mb-0">
            <i class="fas fa-hdd"></i> Disco Duro #
            <span class="numero-index badge badge-secondary">
                {{ is_numeric($index) ? $index + 1 : 'Nuevo' }} 
            </span>
        </h6>
        
        <button type="button" 
                onclick="eliminarComponente(this, 'discoDuro-item')" 
                class="btn btn-sm btn-outline-danger">
            <i class="fas fa-trash"></i>
        </button>
    </div>

    <input type="hidden" name="discoDuro[{{ $index }}][id]" value="{{ $discoDuro->id ?? '' }}">
    
    <input type="hidden" name="discoDuro[{{ $index }}][_delete]" value="">

    <div class="row">
        <div class="form-group col-md-4">
            <label class="small font-weight-bold">Capacidad</label>
            <select name="discoDuro[{{$index}}][capacidad]" class="form-control form-control-sm">
                <option value="">Seleccione...</option>
                @foreach(['120GB', '240GB', '480GB', '500GB', '1TB', '2TB'] as $cap)
                    <option value="{{ $cap }}" {{ ($discoDuro->capacidad ?? '') == $cap ? 'selected' : '' }}>
                        {{ $cap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label class="small font-weight-bold">Tipo</label>
            <select name="discoDuro[{{$index}}][tipo_hdd_ssd]" class="form-control">
                <option value="">Seleccione...</option>
                @foreach(['SSD', 'HDD', 'M.2 NVMe'] as $tipo)
                    <option value="{{ $tipo }}" {{ ($discoDuro->tipo_hdd_ssd ?? '') == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-4">
            <label class="small font-weight-bold">Interface</label>
            <select name="discoDuro[{{$index}}][interface]" class="form-control form-control-sm">
                <option value="">Seleccione...</option>
                @foreach(['SATA', 'NVMe', 'USB', 'SAS'] as $interface)
                    <option value="{{ $interface }}" {{ ($discoDuro->interface ?? '') == $interface ? 'selected' : '' }}>
                        {{ $interface }}
                    </option>
                @endforeach
            </select>
        </div>

        <p>El ID DE ESTE DISCODURO ES: {{$discoDuro->id ?? ''}}</p>
    </div>
</div>