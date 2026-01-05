<?php

namespace App\Http\Controllers;

// --- IMPORTACIÓN DE MODELOS ---
use App\Models\Equipo;
use App\Models\Ubicacion;
use App\Models\Historial_log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    /**
     * Muestra el listado principal de activos.
     * Limpia sesiones previas del Wizard para evitar conflictos de datos.
     */
    public function index(Request $request)
    {
        session()->forget('wizard_equipo');

        //Oye Laravel, prepárate para traerme equipos y tráelos con todas sus piezas (RAM, Discos, etc.) de una vez
        $query = Equipo::with(['usuario', 'ubicacion', 'monitores', 'discosDuros', 'rams', 'perifericos', 'procesadores']);
        #"Viene Algo en Buscador -seccion-"
        if ($request->filled('seccion')) {
            # code...
            $busqueda = $request->seccion;
            $query->where(function($seccion) use ($busqueda) {
            $seccion->where('marca_equipo', 'LIKE', '%' . $busqueda . '%')
              ->orWhere('serial', 'LIKE', '%' . $busqueda . '%')
              ->orWhere('tipo_equipo', 'LIKE', '%' . $busqueda . '%');
            });
        }

        #Filtro por Ubicacion
        if ($request->filled('ubicacion_id')) {
        $query->where('ubicacion_id', $request->ubicacion_id);
        }

        #Filtro por Tipo de Activo
        if ($request->filled('tipo_equipo')) {
            $query->where('tipo_equipo', $request->tipo_equipo);
        }

        $equipos = $query->latest()->paginate(11)->appends($request->all());
        $ubicaciones = Ubicacion::all();
        return view('equipos.index', compact('equipos', 'ubicaciones'));
    }

    /**
     * Valida e inicia el proceso de creación (Wizard).
     * Genera un UUID único para trackear la sesión del equipo nuevo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'marca_equipo'      => 'nullable|string|max:255',
            'tipo_equipo'       => 'required|string|max:255',
            'serial'            => 'nullable|string|max:255',
            'sistema_operativo' => 'required|string|max:35', 
            'usuario_id'        => 'required|integer|exists:users,id',
            'ubicacion_id'      => 'nullable|integer|exists:ubicaciones,id',
            'valor_inicial'     => 'nullable|numeric|min:0|max:99999999.99',
            'fecha_adquisicion' => 'required|date',
            'vida_util_estimada'=> 'required|string|max:255',
        ]);

        $data = $request->all();

        // Valores por defecto si vienen vacíos
        $data['serial']        = $request->serial ?? 'INT-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        $data['marca_equipo']  = $request->marca_equipo ?? 'Sin marca asignada';
        $data['valor_inicial'] = $request->valor_inicial ?? 0;

        $uuid = Str::uuid()->toString();
        
        // Guardamos en sesión para los siguientes pasos del Wizard
        session()->put('wizard_equipo.uuid', $uuid);
        session()->put('wizard_equipo.equipo', $data);

        return redirect()->route('equipos.wizard-ubicacion', $uuid);
    }

    /**
     * Carga la vista de edición con todas sus relaciones.
     * Se usa Eager Loading para evitar el problema de N+1 consultas.
     */
    public function edit(Equipo $equipo)
    {
        $equipo->load(['monitores', 'discosDuros', 'rams', 'perifericos', 'procesadores']);
        
        $usuarios    = User::all();
        $ubicaciones = Ubicacion::all();
        
        return view('equipos.edit', compact('equipo', 'usuarios', 'ubicaciones'));
    }

    /**
     * Procesa la actualización masiva del equipo y sus componentes dinámicos.
     */
    public function update(Request $request, Equipo $equipo)
    {
        // 1. Actualizar datos base del equipo
        $equipo->update($request->only([
            'marca_equipo', 'tipo_equipo', 'serial', 'sistema_operativo', 
            'usuario_id', 'ubicacion_id', 'valor_inicial', 
            'fecha_adquisicion', 'vida_util_estimada'
        ]));

        // 2. Sincronizar relaciones dinámicas (RAM, Discos, etc.)
        /**
         * Aqui lo que pasa es que pasa es que que se busca la funcion sincrona 
         */
        $this->syncRelation($equipo->perifericos(),  $request->input('periferico', []));
        $this->syncRelation($equipo->rams(),         $request->input('ram', []));
        $this->syncRelation($equipo->procesadores(), $request->input('procesador', []));
        $this->syncRelation($equipo->monitores(),    $request->input('monitor', []));
        $this->syncRelation($equipo->discosDuros(),  $request->input('discoDuro', []));


        $perPage = 11;
        $position = Equipo::where('id', '<=', $equipo->id)->count();
        $page = ceil($position / $perPage);

        return redirect()->route('equipos.index', ['page' => $page])
        ->with('warning', 'Equipo actualizado correctamente')
        ->with('actualizado->id', $equipo->id);
    }

    /**
     * Muestra el detalle completo de un activo.
     */
    public function show($id)
    {
        $equipo = Equipo::with(['usuario', 'ubicacion', 'monitores', 'discosDuros', 'rams', 'perifericos', 'procesadores'])
        ->findOrFail($id); 

        return view('equipos.detalles', compact('equipo'));
    }

    /**
     * Registro de mantenimiento en el historial (Log).
     */


    /**
     * Elimina el equipo y calcula la redirección de página.
     */
    public function destroy(Equipo $equipo)
    {
        $position = Equipo::where('id', '<=', $equipo->id)->count();
        $page     = ceil($position / 11);
        
        $equipo->delete();

        return redirect()->route('equipos.index', ['page' => $page])
                         ->with('danger', 'Equipo eliminado correctamente');
    }

    // --- MÉTODOS PRIVADOS DE LÓGICA (HELPER FUNCTIONS) ---

    /**
     * Sincroniza una relación HasMany: crea nuevos, actualiza existentes o elimina.
     */
    protected function syncRelation($relation, array $items)
    {
        foreach ($items as $item) {
            // 1. Verificar si el usuario marcó para eliminar
            if (!empty($item['_delete'])) {
                if (!empty($item['id'])) {
                    // Si tiene ID, lo borramos físicamente de la BD
                    $model = $relation->getRelated()->find($item['id']);
                    if ($model) {
                    $model->delete(); 
                }
                }
                // Si era un ítem nuevo que se marcó para eliminar antes de guardar, 
                // simplemente lo ignoramos y pasamos al siguiente.
                continue;
            }

            // 2. Preparar los datos (quitamos _delete para que no choque con la BD)
            $id = $item['id'] ?? null;
            $data = collect($item)->forget(['id', '_delete'])->toArray();
            // 3. Actualizar o Crear
            // Laravel buscará por ID, si lo halla actualiza, si es null crea.
            $relation->updateOrCreate(['id' => $id], $data);
        }
    }

    private function isEmptyRecord($data) 
    {
        $filtered = collect($data)->except(['id', '_delete'])->filter();
        return $filtered->isEmpty();
    }


    public function indexaddwork (Equipo $equipo){
        $usuarios    = User::all();
        return view('equipos.addwork', compact('equipo', 'usuarios'));
    }



        public function saveWork (Equipo $equipo, Request $request)
    {
        $data = $request->validate([
            'tipo_evento'  => 'required|string',
            'fecha_evento' => 'required|date',
            'contexto'     => 'required|string',
            'costo'        => 'required|numeric',
        ]);

            Historial_log::create([
                  'activo_id'         => $equipo->id,
                   'usuario_accion_id' => auth()->id(),
                      'tipo_registro'     => 'MANTENIMIENTO', 
                      'detalles_json' => [
                        'mensaje' => 'Nuevo Mantenimiento agregado',
                        'usuario_asignado' => $historial->name ?? 'conexion mal hecha we',
                        'rol' => $historial->rol ?? 'conexion mal hecha amor',
                        'cambios'          => [
                            'Mantenimiento Creado' => [
                                'antes'   => 'Inexistente',
                                'despues' => "<ul class='list-unstyled mb-0'>" .
                                "<li><b>Marca:</b> $data[tipo_evento]</li>" .
                                "<li><b>S/N:</b> $data[fecha_evento]</li>" .
                                "<li><b>Interface:</b> $data[contexto]</li>" .
                                 "<li><b>Interface:</b> $data[costo]</li>" .
                                "</ul>"                    
                                ]
                        ]   
                      ]
                ]);


        $perPage = 11;
        $position = Equipo::where('id', '<=', $equipo->id)->count();
        $page = ceil($position / $perPage);

        return redirect()->route('equipos.index', ['page' => $page])->with('secondary', 'Mantenimiento registrado')
        ->with('new_mantenimiento', $equipo->id);
    }

}