<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipo;
use App\Models\User;
use Illuminate\Support\Str;

class EquipoWizardController extends Controller
{
    /**
     * Paso 1: Formulario inicial de creación del equipo
     */
    public function create()
    {
        $wizard = session('wizard_equipo');
        $usuarios = User::all();
        $equipo = data_get($wizard, 'equipo', []);
        
        return view('equipos.create', compact('equipo', 'usuarios'));
    }

    /**
     * Paso 2: Formulario de Ubicación
     */
    public function ubicacionForm($uuid)
    {
        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Sesión de wizard inválida o expirada.');
        }

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-ubicacion', compact('equipo', 'uuid'));
    }

    /**
     * Guardar Ubicación
     */
    public function saveUbicacion(Request $request)
    {
        $request->validate([
            'ubicacion_id' => 'required|exists:ubicaciones,id',
        ]);

        $wizard = session('wizard_equipo');
        
        // Guardar en la sesión
        session()->put('wizard_equipo.ubicacion', [
            'ubicacion_id' => $request->ubicacion_id,
        ]);

        $uuid = $wizard['uuid'];
        return redirect()->route('equipos.wizard-monitores', $uuid);
    }

    /**
     * Paso 3: Monitores
     */
    public function monitoresForm($uuid)
    {
        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Acceso no autorizado al flujo.');
        }

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-monitores', compact('equipo', 'uuid'));
    }

    public function saveMonitor(Request $request, $uuid)
    {
        $request->validate([
            'marca' => 'nullable|string',
            'serial' => 'nullable|string',
            'escala_pulgadas' => 'nullable|string',
            'interface' => 'nullable|string'
        ]);

        $datos = array_filter($request->only(['marca', 'serial', 'escala_pulgadas', 'interface']));

        if (empty($datos)) {
            session()->forget('wizard_equipo.monitor');
        } else {
            // Guardamos los datos para que el último paso los encuentre
            session()->put('wizard_equipo.monitor', $datos);
        }

        return redirect()->route('equipos.wizard-discos_duros', $uuid);
    }

    /**
     * Paso 4: Discos Duros
     */
    public function discoduroForm($uuid)
    {
        $wizard = session('wizard_equipo');
        if (!$wizard || $wizard['uuid'] !== $uuid) abort(403);

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-discos_duros', compact('equipo', 'uuid'));
    }

    public function saveDiscoduro(Request $request, $uuid)
    {
        $request->validate([
            'capacidad' => 'nullable|string',
            'tipo_hdd_ssd' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);

        $datos = array_filter($request->only(['capacidad', 'tipo_hdd_ssd', 'interface']));

        if (empty($datos)) {
            session()->forget('wizard_equipo.disco_duro');
        } else {
            session()->put('wizard_equipo.disco_duro', $datos);
        }

        return redirect()->route('equipos.wizard-ram', $uuid);
    }

    /**
     * Paso 5: Memoria RAM
     */
    public function ramForm($uuid)
    {
        $wizard = session('wizard_equipo');
        if (!$wizard || $wizard['uuid'] !== $uuid) abort(403);

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-rams', compact('equipo', 'uuid'));
    }

    public function saveRam(Request $request, $uuid)
    {
        $request->validate([
            'capacidad_gb' => 'nullable|string',
            'clock_mhz' => 'nullable|string',
            'tipo_chz' => 'nullable|string'
        ]);

        $datos = array_filter($request->only(['capacidad_gb', 'clock_mhz', 'tipo_chz']));

        if (empty($datos)) {
            session()->forget('wizard_equipo.ram');
        } else {
            session()->put('wizard_equipo.ram', $datos);
        }

        return redirect()->route('equipos.wizard-periferico', $uuid);
    }

    /**
     * Paso 6: Periféricos
     */
    public function perifericoForm($uuid)
    {
        $wizard = session('wizard_equipo');
        if (!$wizard || $wizard['uuid'] !== $uuid) abort(403);

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-periferico', compact('equipo', 'uuid'));
    }

    public function savePeriferico(Request $request, $uuid)
    {
        $request->validate([
            'tipo' => 'nullable|string',
            'marca' => 'nullable|string',
            'serial' => 'nullable|string',
            'interface' => 'nullable|string',
        ]);

        $datos = array_filter($request->only(['tipo', 'marca', 'serial', 'interface']));

        if (empty($datos)) {
            session()->forget('wizard_equipo.periferico');
        } else {
            session()->put('wizard_equipo.periferico', $datos);
        }

        return redirect()->route('equipos.wizard-procesador', $uuid);
    }

    /**
     * Paso 7: Procesador y GUARDADO FINAL
     */
    public function ProcesadorForm($uuid)
    {
        $wizard = session('wizard_equipo');
        if (!$wizard || $wizard['uuid'] !== $uuid) abort(403);

        $equipo = data_get($wizard, 'equipo');
        return view('equipos.wizard-procesador', compact('uuid', 'equipo'));
    }

    public function saveProcesador(Request $request, $uuid)
    {
        $request->validate([
            'marca' => 'nullable|string',
            'descripcion_tipo' => 'nullable|string',
            'frecuenciaMicro' => 'nullable|string',
        ]);

        // Guardar el procesador en la variable local primero
        $procesadorData = array_filter($request->only(['marca', 'descripcion_tipo', 'frecuenciaMicro']));

        if (empty($procesadorData)) {
            session()->forget('wizard_equipo.procesador');
        } else {
            session()->put('wizard_equipo.procesador', $procesadorData);
        }

        // Obtener TODO el wizard acumulado
        $wizard = session('wizard_equipo');

        if (!$wizard || $wizard['uuid'] !== $uuid) {
            abort(403, 'Sesión inválida al intentar guardar.');
        }

        // 1. Crear el Equipo Base
        $equipo = Equipo::create([
            ...$wizard['equipo'],
            'ubicacion_id' => $wizard['ubicacion']['ubicacion_id'] ?? null,
        ]);
        
        // 2. Crear relaciones (si existen datos en la sesión)
        if (!empty($wizard['monitor'])) {
            $equipo->monitores()->create($wizard['monitor']);
        }

        if (!empty($wizard['disco_duro'])) {
            $equipo->discosDuros()->create($wizard['disco_duro']);
        }
    
        if (!empty($wizard['ram'])) {
            $equipo->rams()->create($wizard['ram']);
        }

        if (!empty($wizard['periferico'])) {
            $equipo->perifericos()->create($wizard['periferico']);
        }

        if (!empty($wizard['procesador'])) {
            $equipo->procesadores()->create($wizard['procesador']);
        }

        // 3. Limpiar sesión
        session()->forget('wizard_equipo');

        // 4. Calcular paginación para redirigir al registro nuevo
        $perPage = 8;
        $position = Equipo::where('id', '<=', $equipo->id)->count();
        $page = ceil($position / $perPage);

        return redirect()->route('equipos.index', ['page' => $page])
            ->with('success', '¡Equipo y todos sus componentes registrados con éxito!')
            ->with('new_id', $equipo->id);
    }
}