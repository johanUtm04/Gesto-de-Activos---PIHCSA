<div class="periferico-item p-3 mb-5 border rounded bg-light shadow-sm">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="text-secondary mb-0">
            <i class="fas fa-desktop"></i> Rams #
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
            <label class="small font-weight-bold">Tipo (DDR)</label>
            <select name="periferico[{{ $index }}][tipo]" class="form-control form-control-sm">
                <option value="">Seleccione...</option>
                @foreach(['DDR3', 'DDR4', 'DDR5', 'LPDDR4'] as $t)
                    <option value="{{ $t }}" {{ ($periferico->tipo ?? '') == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label class="small font-weight-bold">Marca</label>
            <input type="text" name="periferico[{{ $index }}][marca]" 
            value="{{ $periferico->marca ?? '' }}" class="form-control form-control-sm" placeholder="Kingston/Crucial">
        </div>

        <div class="form-group col-md-3">
            <label class="small font-weight-bold">Serial</label>
            <input type="text" name="periferico[{{ $index }}][serial]" 
                   value="{{ $periferico->serial ?? '' }}" class="form-control form-control-sm" placeholder="S/N">
        </div>

        <div class="form-group col-md-3">
            <label class="small font-weight-bold">Capacidad/Interface</label>
            <select name="periferico[{{ $index }}][interface]" class="form-control form-control-sm">
                <option value="">Seleccione...</option>
                @foreach(['8GB 3200MHz', '16GB 3200MHz', '32GB 4800MHz', '8GB 2666MHz'] as $int)
                    <option value="{{ $int }}" {{ ($periferico->interface ?? '') == $int ? 'selected' : '' }}>{{ $int }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <small class="text-muted">ID Sistema: {{ $periferico->id ?? 'Pendiente' }}</small>
</div>