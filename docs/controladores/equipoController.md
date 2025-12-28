# EquipoController

---

## Propósito / Purpose

### Español
El `EquipoController` es el controlador principal encargado de la **gestión integral de activos (equipos)** dentro del sistema.  
Centraliza las operaciones CRUD, la edición avanzada de componentes relacionados y el registro de mantenimientos, asegurando trazabilidad y control mediante auditoría.

### English
The `EquipoController` is the main controller responsible for **comprehensive asset (equipment) management** within the system.  
It centralizes CRUD operations, advanced editing of related components, and maintenance logging, ensuring traceability and control through auditing.

---

## Responsabilidades / Responsibilities

### Español
- Mostrar el inventario de activos con paginación
- Iniciar el flujo de creación de activos (wizard)
- Editar activos mediante vista comparativa
- Actualizar información principal y componentes relacionados
- Registrar mantenimientos
- Eliminar activos de forma lógica
- Registrar auditoría de cambios

### English
- Display paginated asset inventory
- Start the asset creation wizard flow
- Edit assets using a split comparison view
- Update main asset data and related components
- Register maintenance events
- Perform logical asset deletion
- Log audit records for changes

---

## Métodos del Controlador / Controller Methods

| Método | HTTP | Ruta | Descripción |
|------|------|------|-------------|
| index | GET | /equipos | Listado principal de activos |
| create | GET | /equipos/create | Inicio del wizard de creación |
| store | POST | /equipos | Almacena datos base del activo |
| edit | GET | /equipos/{equipo}/edit | Vista de edición dividida |
| update | PUT | /equipos/{equipo} | Actualización completa del activo |
| indexaddwork | GET | /equipos/{equipo}/addwork | Vista de mantenimiento |
| addwork | POST | /equipos/{equipo}/addwork | Registro de mantenimiento |
| destroy | DELETE | /equipos/{equipo} | Eliminación lógica del activo |

---

## Detalle de Métodos / Method Details

### `index()`

**ES:**  
Muestra el listado principal de activos con paginación.  
Limpia cualquier sesión activa del wizard para evitar inconsistencias.

**EN:**  
Displays the main paginated asset list.  
Clears any active wizard session to avoid inconsistencies.

---

### `create()`

**ES:**  
Inicializa el flujo de creación de activos mediante wizard, cargando usuarios y ubicaciones disponibles.

**EN:**  
Initializes the asset creation wizard flow, loading available users and locations.

---

### `store(Request $request)`

**ES:**  
Valida y almacena los datos base del activo.  
Genera un UUID único y guarda la información en sesión para continuar el wizard.

**Características clave:**
- Validaciones de datos
- Generación automática de serial interno
- Inicialización de sesión `wizard_equipo`

**EN:**  
Validates and stores base asset data.  
Generates a unique UUID and stores data in session to continue the wizard.

---

### `edit(Equipo $equipo)`

**ES:**  
Devuelve una vista de edición dividida que permite comparar los valores actuales con los nuevos.

**EN:**  
Returns a split-view edit screen allowing comparison between current and new values.

---

### `update(Request $request, Equipo $equipo)`

**ES:**  
Actualiza la información principal del activo y gestiona la edición de componentes relacionados:
- Periféricos
- RAM
- Procesadores
- Monitores
- Discos duros

Incluye:
- Creación
- Actualización
- Eliminación condicional
- Auditoría de cambios
- Redirección inteligente según paginación

**EN:**  
Updates the main asset information and manages related components:
- Peripherals
- RAM
- Processors
- Monitors
- Hard drives

Includes:
- Creation
- Update
- Conditional deletion
- Change auditing
- Intelligent pagination redirect

---

### `indexaddwork(Equipo $equipo)`

**ES:**  
Muestra el formulario para registrar mantenimientos del activo.

**EN:**  
Displays the asset maintenance registration form.

---

### `addwork(Equipo $equipo, Request $request)`

**ES:**  
Registra un evento de mantenimiento en el historial del activo, asociándolo al usuario autenticado.

**EN:**  
Registers a maintenance event in the asset history, linked to the authenticated user.

---

### `destroy(Equipo $equipo)`

**ES:**  
Elimina el activo de forma lógica y redirige al usuario a la página correcta del inventario.

**EN:**  
Performs a logical deletion of the asset and redirects the user to the correct inventory page.

---

## Seguridad / Security

### Español
- Requiere autenticación (`auth`)
- Acceso controlado por roles
- Validación de datos de entrada
- Registro de auditoría mediante `AuditService`

### English
- Requires authentication (`auth`)
- Role-based access control
- Input validation
- Audit logging via `AuditService`

---

## Modelos Relacionados / Related Models

- Equipo
- User
- Ubicacion
- Historial_log
- Monitor
- DiscoDuro
- Procesador
- RAM
- Periferico

---

## Consideraciones de Escalabilidad / Scalability Notes

### Español
- La lógica de componentes puede migrarse a Services si crece la complejidad
- El sistema de auditoría está preparado para extenderse
- El wizard permite agregar nuevos pasos sin afectar el flujo actual

### English
- Component logic can be migrated to Services if complexity grows
- Audit system is ready for extension
- Wizard flow supports adding new steps without breaking existing logic

---

## 📎 Notas Finales / Final Notes

Este controlador está diseñado como un **núcleo funcional del sistema**, priorizando claridad, trazabilidad y facilidad de mantenimiento.

This controller is designed as a **core functional component of the system**, prioritizing clarity, traceability, and maintainability.
