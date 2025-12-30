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
    public function index()
    {
        session()->forget('wizard_equipo');
        
        $equipos = Equipo::with(['usuario', 'ubicacion'])->paginate(11);
        
        return view('equipos.index', compact('equipos'));
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
        // Nota: 'discoDuros' debe coincidir con el atributo 'name' del HTML
        $this->syncRelation($equipo->perifericos(),  $request->input('perifericos', []));
        $this->syncRelation($equipo->rams(),         $request->input('rams', []));
        $this->syncRelation($equipo->procesadores(), $request->input('procesadores', []));
        $this->syncRelation($equipo->monitores(),    $request->input('monitores', []));
        $this->syncRelation($equipo->discosDuros(),  $request->input('discoDuros', []));

        // 3. Cálculo de página para retornar al mismo lugar en el index
        $page = ceil(Equipo::where('id', '<=', $equipo->id)->count() / 11);
        
        return redirect()->route('equipos.index', ['page' => $page])
                         ->with('warning', 'Equipo actualizado correctamente');
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
    public function addwork(Equipo $equipo, Request $request)
    {
        $data = $request->validate([
            'tipo_evento'  => 'required|string',
            'fecha_evento' => 'required|date',
            'contexto'     => 'required|string',
            'costo'        => 'nullable|numeric',
        ]);

        Historial_log::create([
            'activo_id'         => $equipo->id,
            'usuario_accion_id' => auth()->id(),
            'tipo_registro'     => 'MANTENIMIENTO',
            'detalles_json'     => $data, // Laravel lo castea automáticamente si el modelo tiene 'casts'
        ]);

        return redirect()->route('equipos.index')->with('success', 'Mantenimiento registrado');
    }

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
    private function syncRelation($relation, $dataArray)
    {
        foreach ($dataArray as $data) {
            // Saltamos si el array no tiene datos útiles
            if (empty(array_filter($data))) continue;

            if (isset($data['id'])) {
                $record = $relation->find($data['id']);
                if ($record) {
                    // Si el usuario marcó para borrar o los campos están vacíos
                    if (!empty($data['_delete']) || $this->isEmptyRecord($data)) {
                        $record->delete();
                    } else {
                        // Actualizamos omitiendo campos de control
                        $record->update(collect($data)->except(['id', '_delete'])->toArray());
                    }
                }
            } else {
                // Si no tiene ID y tiene contenido real, es un registro nuevo
                if (!$this->isEmptyRecord($data) && empty($data['_delete'])) {
                    $relation->create(collect($data)->except(['_delete'])->toArray());
                }
            }
        }
    }

    /**
     * Verifica si el conjunto de datos de un componente está vacío de información útil.
     */
    private function isEmptyRecord($data) 
    {
        $filtered = collect($data)->except(['id', '_delete'])->filter();
        return $filtered->isEmpty();
    }
}