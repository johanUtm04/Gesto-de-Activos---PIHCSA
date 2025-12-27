# 3. Arquitectura del Sistema

## 3.1 Visión general

En esta sección se definen las rutas que utiliza la aplicación. Aquí se declaran los *endpoints* y se maneja la lógica de navegación mediante controladores o funciones (*closures*).  
La capa de enrutamiento cumple con las siguientes funciones principales:

- **Enrutamiento (Routing)**
- **Manejo de peticiones**
- **Aplicación de Middleware**
- **Agrupación de rutas**

---

## 3.2 Convenciones de rutas

- **Rutas REST:**  
  Pendiente de estandarización completa.

- **Prefijos:**  
  Cada ruta cuenta con un nombre claro y descriptivo en español, representando la acción que ocurre al acceder a dicha URL.

- **Nombres de rutas:**  
  Los nombres de las rutas están completamente en español y utilizan barras (`/`) cuando una acción deriva en otra, proporcionando al usuario una referencia visual clara de su navegación dentro del sistema.

- **Middleware:**  
  El uso de middleware permite dividir el acceso según los roles principales, ocultando botones o incluso secciones completas.  
  El rol **Administrador** cuenta con acceso total al sistema, mientras que los roles **Sistemas** y **Contabilidad** tienen permisos limitados.

---

## 3.3 Rutas por módulo

### Módulo: Autenticación y Acceso

| Método | Ruta       | Controlador | Acción | Descripción                     | Middleware     |
|-------|------------|-------------|--------|----------------------------------|----------------|
| GET   | /          | Closure     | —      | Pantalla de inicio de sesión     | —              |
| GET   | /dashboard | Closure     | —      | Dashboard principal del sistema  | auth, verified |

---

### Módulo: Gestión de Equipos (Inventario)

| Método | Ruta                    | Controlador      | Acción    | Descripción                     | Middleware |
|-------|--------------------------|------------------|-----------|----------------------------------|------------|
| GET   | /equipos                 | EquipoController | index     | Listado principal de activos     | auth       |
| GET   | /equipos/historial       | EquipoController | historial | Historial de cambios de activos  | auth       |
| POST  | /equipos                 | EquipoController | store     | Registro de un nuevo activo      | auth       |
| GET   | /equipos/{equipo}/edit   | EquipoController | edit      | Edición de un activo             | auth       |
| PUT   | /equipos/{equipo}        | EquipoController | update    | Actualización de un activo       | auth       |
| DELETE| /equipos/{equipo}        | EquipoController | destroy   | Eliminación lógica del activo    | auth       |

---

### Módulo: Wizard de Creación de Activos

| Método | Ruta                       | Controlador            | Acción         | Descripción                    | Middleware |
|-------|----------------------------|------------------------|----------------|--------------------------------|------------|
| GET   | /equipos/wizard/create     | EquipoWizardController | create         | Inicio del wizard de registro  | auth       |
| GET   | /equipos/{uuid}/wizard     | EquipoWizardController | show           | Vista general del wizard       | auth       |
| GET   | /equipos/{uuid}/ubicacion  | EquipoWizardController | ubicacionForm  | Asignación de ubicación        | auth       |
| POST  | /equipos/{uuid}/ubicacion  | EquipoWizardController | saveUbicacion  | Guardar ubicación              | auth       |
| GET   | /equipos/{uuid}/monitores  | EquipoWizardController | monitoresForm  | Registro de monitores          | auth       |
| POST  | /equipos/{uuid}/monitores  | EquipoWizardController | saveMonitor    | Guardar monitores              | auth       |
| GET   | /equipos/{uuid}/discoduro  | EquipoWizardController | discoduroForm  | Registro de discos duros       | auth       |
| POST  | /equipos/{uuid}/discoduro  | EquipoWizardController | saveDiscoduro  | Guardar discos duros           | auth       |
| GET   | /equipos/{uuid}/ram        | EquipoWizardController | ramForm        | Registro de memoria RAM        | auth       |
| POST  | /equipos/{uuid}/ram        | EquipoWizardController | saveRam        | Guardar módulos de RAM         | auth       |
| GET   | /equipos/{uuid}/periferico | EquipoWizardController | perifericoForm | Registro de periféricos        | auth       |
| POST  | /equipos/{uuid}/periferico | EquipoWizardController | savePeriferico | Guardar periféricos            | auth       |
| GET   | /equipos/{uuid}/procesador | EquipoWizardController | procesadorForm | Registro de procesador         | auth       |
| POST  | /equipos/{uuid}/procesador | EquipoWizardController | saveProcesador | Guardar procesador             | auth       |

---

### Módulo: Mantenimiento de Activos

| Método | Ruta                      | Controlador      | Acción       | Descripción                 | Middleware |
|-------|---------------------------|------------------|--------------|-----------------------------|------------|
| GET   | /equipos/{equipo}/addwork | EquipoController | indexaddwork | Formulario de mantenimiento | auth       |
| POST  | /equipos/{equipo}/addwork | EquipoController | addwork      | Registro de mantenimiento   | auth       |

---

### Módulo: Depreciación

| Método | Ruta                      | Controlador            | Acción     | Descripción                        | Middleware |
|-------|---------------------------|------------------------|------------|------------------------------------|------------|
| GET   | /depreciacion             | DepreciacionController | index      | Listado de activos depreciables    | auth       |
| GET   | /depreciacion/{equipo}    | DepreciacionController | show       | Detalle de depreciación por activo | auth       |
| GET   | /depreciacion/reporte/pdf | DepreciacionController | exportPdf | Generación de reporte en PDF       | auth       |

---

### Módulo: Gestión de Usuarios

| Método | Ruta                         | Controlador               | Acción  | Descripción              | Middleware |
|-------|------------------------------|---------------------------|---------|--------------------------|------------|
| GET   | /gestionUsuarios             | GestionUsuariosController | index   | Listado de usuarios      | auth       |
| GET   | /gestionUsuarios/create      | GestionUsuariosController | create  | Alta de usuario          | auth       |
| POST  | /gestionUsuarios             | GestionUsuariosController | store   | Guardar usuario          | auth       |
| GET   | /gestionUsuarios/{user}/edit | GestionUsuariosController | edit    | Edición de usuario       | auth       |
| PUT   | /gestionUsuarios/{user}      | GestionUsuariosController | update  | Actualización de usuario | auth       |
| DELETE| /gestionUsuarios/{user}      | GestionUsuariosController | destroy | Eliminación de usuario   | auth       |

---

### Módulo: Gestión de Ubicaciones

| Método | Ruta                                 | Controlador                  | Acción  | Descripción                | Middleware |
|-------|--------------------------------------|------------------------------|---------|----------------------------|------------|
| GET   | /gestionUbicaciones                  | GestionUbicacionesController | index   | Listado de ubicaciones     | auth       |
| GET   | /gestionUbicaciones/create           | GestionUbicacionesController | create  | Alta de ubicación          | auth       |
| POST  | /gestionUbicaciones                  | GestionUbicacionesController | store   | Guardar ubicación          | auth       |
| GET   | /gestionUbicaciones/{ubicacion}/edit | GestionUbicacionesController | edit    | Edición de ubicación       | auth       |
| PUT   | /gestionUbicaciones/{ubicacion}      | GestionUbicacionesController | update  | Actualización de ubicación | auth       |
| DELETE| /gestionUbicaciones/{ubicacion}      | GestionUbicacionesController | destroy | Eliminación de ubicación   | auth       |

---

### Módulo: Historial Global

| Método | Ruta       | Controlador         | Acción | Descripción                   | Middleware |
|-------|------------|---------------------|--------|-------------------------------|------------|
| GET   | /historial | HistorialController | index  | Auditoría global del sistema  | auth       |

---

## 3.4 Flujo de navegación

Esta sección describe cómo el usuario se desplaza dentro del sistema de acuerdo con su rol y permisos asignados, garantizando una experiencia guiada y controlada.

---

## 3.5 Seguridad y Middleware

**Autenticación:**  
La autenticación es obligatoria para cada sesión de la aplicación web, permitiendo una auditoría completa de las acciones de cada usuario.

**Permisos:**  
Los permisos dependen del rol autenticado:
- **ADMIN:** Acceso total al sistema
- **SISTEMAS:** Acceso limitado, sin gestión de usuarios ni ubicaciones
- **CONTABILIDAD:** Acceso de solo lectura y consulta de auditoría

**Políticas:**  
Se pueden implementar *Laravel Policies* para definir reglas de autorización más específicas a nivel de modelo.

---

# English

# 3. System Architecture

## 3.1 Overview

This section defines the routes used by the application, where endpoints are declared and navigation logic is handled through controllers or closures.  
The routing layer fulfills the following responsibilities:

- **Routing**
- **Request handling**
- **Middleware application**
- **Route grouping**

---

## 3.2 Route Conventions

- **REST Routes:**  
  Pending full standardization.

- **Prefixes:**  
  Each route uses a clear and descriptive name that reflects the action performed when accessing the URL.

- **Route Naming:**  
  Route names are written entirely in Spanish and use forward slashes (`/`) to visually represent navigation flow when one action leads to another.

- **Middleware:**  
  Middleware enforces access control between user roles, ensuring that only administrators have full system access, while other roles have restricted permissions.

---

## 3.3 Routes by Module

*(See Spanish section for full route tables, which apply equally to the English version.)*

---

## 3.4 Navigation Flow

This section explains how users navigate through the system based on their assigned roles and permissions.

---

## 3.5 Security and Middleware

**Authentication:**  
Authentication is mandatory for every web session and enables full traceability of user actions.

**Permissions:**  
Permissions depend on the authenticated role:
- **ADMIN:** Full access
- **SYSTEMS:** Limited access
- **ACCOUNTING:** Read-only access with audit visibility

**Policies:**  
Laravel policies can be implemented to define fine-grained authorization rules.

---
