    @extends('adminlte::page')

    @section('title', 'Editar Equipo')

    @section('content_header')
    <h1 class="text-center font-weight-bold">
        EDITAR DATOS DE {{ strtoupper($equipo->marca_equipo) }}
    </h1>

    <a href="{{ route('equipos.index') }}" class="btn btn-secondary mt-2">Volver</a>
    @stop


    @section('content')
    <div class="container mt-4">

        <div class="row">

            {{-- LEFT SIDE  CURRENT DATA --}}
            <div class="col-md-6">
                <div class="card p-3" style="background:#0f0f0f; color:white; border:1px solid #333;">
                    <h4 class="mb-3 text-info">Datos Actuales</h4>

                    <p><strong>Nombre:</strong><br> {{ $equipo->marca_equipo }}</p>
                    <hr>

                    <p><strong>Tipo:</strong><br> {{ $equipo->tipo_equipo }}</p>
                    <hr>

                    <p><strong>Serial:</strong><br> {{ $equipo->serial }}</p>
                    <hr>

                    <p><strong>Sistema Operativo:</strong><br> {{ $equipo->sistema_operativo }}</p>
                    <hr>

                    <p><strong>Usuario Responsable:</strong><br> {{ $equipo->usuario->name ?? '-' }}</p>
                    <hr>

                    <p><strong>Ubicación:</strong><br> {{ $equipo->ubicacion->nombre ?? '-' }}</p>
                    <hr>

                    <p><strong>Valor Inicial:</strong><br> ${{ number_format($equipo->valor_inicial, 2) }}</p>
                    <hr>

                    <p><strong>Fecha de Adquisición:</strong><br> {{ $equipo->fecha_adquisicion }}</p>
                    <hr>

                    <p><strong>Vida Útil Estimada:</strong><br> {{ $equipo->vida_util_estimada }}</p>

                    <h4 class="mb-3 text-info">Otros datos</h4>

                    <!-- Perifericos -->
                    <div class="perifericos-list-container mb-4">
                        <h4>Periféricos Asociados ({{ $equipo->perifericos->count() }})</h4>

                        @forelse($equipo->perifericos as $periferico)
                        <div class="card p-2 mb-2 bg-light d-flex justify-content-between align-items-center flex-row">
                            <span class="text-dark">
                            <strong>{{ $periferico->tipo }}</strong> (Serial: {{ $periferico->serial }})
                            </span>
                        </div>
                        @empty
                        <p class="text-secondary">Este equipo no tiene periféricos asociados.</p>
                        @endforelse
                    </div>
                    <!-- RAMS -->
                    <div class="perifericos-list-container mb-4">
                        <h4>Rams Asociados ({{ $equipo->rams->count() }})</h4>
                        @forelse($equipo->rams as $ram)
                        <div class="card p-2 mb-2 bg-light d-flex justify-content-between align-items-center flex-row">
                            <span class="text-dark">
                            <strong> Capacidad en GB: </strong>{{ $ram->capacidad_gb }}
                            <strong> Clock: </strong>{{ $ram->clock_mhz }}
                            <strong> Tipo CHz: </strong>{{ $ram->tipo_chz }}
                            </span>
                        </div>
                        @empty
                        <p class="text-secondary">Este equipo no tiene periféricos asociados.</p>
                        @endforelse
                    </div>

                    <!-- Procesadores -->
                    <div class="perifericos-list-container mb-4">
                        <h4>Procesadores Asociados ({{ $equipo->procesadores->count() }})</h4>
                        @forelse($equipo->procesadores as $procesador)
                        <div class="card p-2 mb-2 bg-light d-flex justify-content-between align-items-center flex-row">
                            <span class="text-dark">
                            <strong> Marca: </strong>{{ $procesador->marca }}
                            <strong> Clock: </strong>{{ $procesador->descripcion_tipo }}
                            </span>
                        </div>
                        @empty
                        <p class="text-secondary">Este equipo no tiene periféricos asociados.</p>
                        @endforelse
                    </div>





                    

                </div>
            </div>

            {{-- RIGHT SIDE  FORM TO UPDATE DATA --}}
            <div class="col-md-6">
                <div class="card p-3" style="background:#ffffff; border:1px solid #ccc;">
                    <h4 class="mb-3 text-primary">Datos Modificados</h4>

                    <form action="{{ route('equipos.update', $equipo) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Marca del Equipo</label>
                            <input type="text" name="marca_equipo" class="form-control"
                                value="{{ old('marca_equipo', $equipo->marca_equipo) }}">
                        </div>

                        <div class="form-group">
                            <label>Tipo de Equipo</label>
                            <input type="text" name="tipo_equipo" class="form-control"
                                value="{{ old('tipo_equipo', $equipo->tipo_equipo) }}">
                        </div>

                        <div class="form-group">
                            <label>Serial</label>
                            <input type="text" name="serial" class="form-control"
                                value="{{ old('serial', $equipo->serial) }}">
                        </div>

                        <div class="form-group">
                            <label>Sistema Operativo</label>
                            <input type="text" name="sistema_operativo" class="form-control"
                                value="{{ old('sistema_operativo', $equipo->sistema_operativo) }}">
                        </div>

                        <div class="form-group">
                            <label>Usuario Responsable</label>
                            <select name="usuario_id" class="form-control">
                                <option value="">Seleccione...</option>
                                @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id }}"
                                    {{ $equipo->usuario_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ubicación</label>
                            <select name="ubicacion_id" class="form-control">
                                <option value="">Seleccione...</option>
                                @foreach($ubicaciones as $ubicacion)
                                <option value="{{ $ubicacion->id }}"
                                    {{ $equipo->ubicacion_id == $ubicacion->id ? 'selected' : '' }}>
                                    {{ $ubicacion->nombre }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Valor Inicial</label>
                            <input type="number" name="valor_inicial" class="form-control" step="0.01"
                                value="{{ old('valor_inicial', $equipo->valor_inicial) }}">
                        </div>

                        <div class="form-group">
                            <label>Fecha de Adquisición</label>
                            <input type="date" name="fecha_adquisicion" class="form-control"
                                value="{{ old('fecha_adquisicion', $equipo->fecha_adquisicion) }}">
                        </div>

                        <div class="form-group">
                            <label>Vida Útil Estimada</label>
                            <input type="text" name="vida_util_estimada" class="form-control"
                                value="{{ old('vida_util_estimada', $equipo->vida_util_estimada) }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">
                            Guardar Cambios (Involucrara un registro en el historial)
                        </button>
                        

                    <!-- Editables extra -->
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
                    <!-- Perifericos -->
                     <h4 class="mb-3 text-info">Otros datos</h4>

                     <h4 class="mb-3 text-info">Perifericos :v</h4>
                    <div id="perifericos-container  ">
                        <!-- $equipos->perifericos es similar a hacer esto
                        [
                            Periferico{id: 10, tipo: 'USB', serial: 'ABC001'},
                            Periferico{id: 11, tipo: 'HDMI', serial: 'XYZ123'},
                            Periferico{id: 12, tipo: 'Audio', serial: 'QWE222'},
                        ] 
                        -->
                        @foreach($equipo->perifericos as $index => $periferico)
                        <div class="periferico-item card p-3 mb-3 border-secondary">
                            <h6 class="text-secondary">Periférico #{{ $index + 1 }} </h6>

                            <!-- Al hacer name = "perifericos[]" le estoy enviando un array
                            el id siempre se queda como id, de esta manera -> name="perifericos[0][id]" -->
                            <input type="hidden" name="perifericos[{{ $index }}][id]" value="{{ $periferico->id }}"> <!--Tomamos el Id de la relacion--> 
                            <!-- Osea aqui basicamente estamos armando esto 
                            perifericos[1][id] = 12
                            perifericos[1] = {
                                id: 12
                            } -->


                            <div class="form-group">
                                <label>Tipo / Marca</label>
                                <input type="text" name="perifericos[{{ $index }}][tipo]" class="form-control form-control-sm"
                                    placeholder="Ej: Teclado, Monitor, Mouse"
                                
                                    value="{{ old('perifericos.' . $index . '.tipo', $periferico->tipo ?? '') }}">  <!--old mantiene el valor aunque salga un error-->
                            </div>

                            <div class="form-group">
                                <label>Serial</label>
                                <input type="text" name="perifericos[{{ $index }}][serial]" class="form-control form-control-sm"
                                    placeholder="Serial del periférico"
                                    value="{{ old('perifericos.' . $index . '.serial', $periferico->serial ?? '') }}">
                            </div>

                        </div>
                        @endforeach
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------- -->
                    <h4 class="mb-3 text-info">Ramsiñas</h4>
                        <div id="rams-container">
                        @foreach($equipo->rams as $index => $ram)
                        <!-- Capacidad en GB -->
                            <div class="ram item card p-3 mb-3 border-secondary">
                            <h6 class="text-secondary">RAM #{{ $index + 1 }} </h6>
                             <input type="hidden" name="rams[{{ $index }}][id]" value="{{ $ram->id }}">
                            <div class="form-group">
                                <label>Capacidad de la Memoria Ram</label>
                                    <input type="text" name="rams[{{$index}}][capacidad_gb]" id=""
                                    placeholder="waza"
                                    value=" {{old('rams.' . $index . '.capacidad_gb', $ram->capacidad_gb ?? '')}} "
                                    >
                            </div>
                            <div class="form-group">
                                <label>Clock MHz</label>
                                    <input type="text" name="rams[{{$index}}][clock_mhz]"
                                    placeholder="waza"
                                    value=" {{old('rams.' . $index . '.clock_mhz', $ram->clock_mhz ?? '')}} "
                                    >
                            </div>
                            <div class="form-group">
                                <label>Tipo Chz</label>
                                <input type="text" name="rams[{{$index}}][tipo_chz]"
                                placeholder="waza"
                                value=" {{old('rams.' . $index . '.tipo_chz ', $ram->tipo_chz ?? '')}} "
                                >
                            </div>                           
                        
                        </div>
                        @endforeach


                    <h4 class="mb-3 text-info">Procesadores</h4>
                        <div id="procesadores-container">
                        @foreach($equipo->procesadores as $index => $procesador)
                            <div class="procesador item card p-3 mb-3 border-secondary">
                            <h6 class="text-secondary">Procesador #{{ $index + 1 }} </h6>
                             <input type="hidden" name="procesadores[{{ $index }}][id]" value="{{ $procesador->id }}">
                            <div class="form-group">
                                <label>Marca</label>
                                    <input type="text" name="procesadores[{{$index}}][marca]" id=""
                                    placeholder="waza"
                                    value=" {{old('procesadores.' . $index . '.marca', $procesador->marca ?? '')}} "
                                    >
                            </div>
                            <div class="form-group">
                                <label>Descripcion </label>
                                <input type="text" name="procesadores[{{$index}}][descripcion_tipo]"
                                placeholder="waza"
                                value=" {{old('procesadore.' . $index . '.descripcion_tipo ', $procesador->descripcion_tipo ?? '')}} "
                                >
                            </div>                           
                        
                        </div>
                        @endforeach
                        
                        
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @stop
