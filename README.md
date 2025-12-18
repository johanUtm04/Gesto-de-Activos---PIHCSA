# Inventario de Activos TI

Sistema web desarrollado en **Laravel + AdminLTE** para el control, registro y administración de activos de TI (equipos, componentes y periféricos) mediante un **wizard paso a paso**, con enfoque en buena UX, claridad visual y mantenibilidad.

<p align="center">
  <img src="/public/vendor/adminlte/dist/img/logohd.png" alt="Inventario de Activos TI" width="200">
</p>


---

## Tecnologías utilizadas

* **Laravel** (Backend / MVC)
* **Blade** (Vistas)
* **AdminLTE 3** (UI / Dashboard)
* **Bootstrap 4** (Estilos base)
* **jQuery** (Interacciones UI)
* **MySQL** (Base de datos)

---

## Funcionalidad principal

### ✔ Registro de Activos TI

El registro de un activo se realiza mediante un **Wizard guiado**, dividido en pasos claros:

1. **Datos base del equipo**
2. **Ubicación**
3. **Monitor(es)** *(opcional)*
4. **Disco(s) duro(s)** *(opcional)*
5. **Memoria RAM** *(opcional)*
6. **Periféricos** *(opcional)*
7. **Procesador (final)**

Cada paso:

* Puede **guardarse u omitirse**
* Muestra el **progreso visual**
* Mantiene consistencia de diseño con AdminLTE

---

## UX / UI destacadas

### 🔹 Resaltado visual al crear / editar

Cuando se crea un nuevo equipo:

* Se redirige automáticamente a la **página correcta de la paginación**
* La fila del equipo recién creado se **resalta visualmente**

#### Blade (fila resaltada)

```blade
<tr class="{{ session('highlight_id') == $equipo->id ? 'highlight-row' : '' }}">
```

#### CSS

```css
.highlight-row {
    animation: highlightFade 2.5s ease-out;
    background-color: #d4edda !important;
}

@keyframes highlightFade {
    0% { background-color: #c3e6cb; }
    100% { background-color: transparent; }
}
```

---

## Listado de inventario

* Tabla paginada
* Resumen visual de componentes (badges)
* Acciones por fila:

  * Ver detalles (modal)
  * Editar
  * Registrar mantenimiento
  * Eliminar

### Modal de detalles

Muestra información completa del activo:

* Datos base
* Asignación y valor
* Componentes asociados

Se alimenta vía **data-attributes** del botón.

---

## Paginación inteligente

Para asegurar que el highlight funcione incluso con paginación:

### Cálculo de página al crear equipo

```php
$perPage = 12;
$position = Equipo::where('id', '<=', $equipo->id)->count();
$page = ceil($position / $perPage);

return redirect()
    ->route('equipos.index', ['page' => $page])
    ->with('success', 'Equipo creado correctamente')
    ->with('highlight_id', $equipo->id);
```

---

## Validación de formularios

### Ejemplo: Validación de datos base + arreglo de periféricos

```php
$request->validate([
    'marca_equipo' => 'nullable|string|max:255',
    'tipo_equipo' => 'required|string|max:255',
    'serial' => 'nullable|string|max:255',
    'sistema_operativo' => 'required|string|max:50',
    'usuario_id' => 'required|integer|exists:users,id',
    'ubicacion_id' => 'nullable|integer|exists:ubicaciones,id',
    'valor_inicial' => 'required|numeric|min:0|max:999999.99',
    'fecha_adquisicion' => 'required|date',
    'vida_util_estimada' => 'required|string|max:255',

    // Periféricos (arreglo)
    'perifericos' => 'nullable|array',
    'perifericos.*.tipo' => 'required|string|max:255',
    'perifericos.*.marca' => 'nullable|string|max:255',
    'perifericos.*.serial' => 'nullable|string|max:255',
    'perifericos.*.interface' => 'nullable|string|max:255',
]);
```

---

## Estructura mental del proyecto

* **Controllers** → lógica de negocio
* **Views (Blade)** → presentación
* **Models** → relaciones y datos
* **Session flash** → UX (mensajes, highlights)
* **Wizard** → flujo controlado y claro

---

## Buenas prácticas aplicadas

* Separación de responsabilidades
* Validaciones centralizadas
* UX clara (feedback visual)
* Componentes opcionales (no forzados)

---



## ✨ Autor
Johan Jael Lòpez Reyes (Universidad Tecnologica de Morelia)
Proyecto desarrollado como sistema de gestión de activos TI con enfoque académico y profesional.

---

> "Primero que funcione, luego que se vea bien, y al final que se sienta
