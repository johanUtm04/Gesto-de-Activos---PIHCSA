# GestionUsuariosController

---

## Propósito / Purpose

### Español
El `GestionUsuariosController` se encarga de la **administración de usuarios del sistema**, permitiendo crear, listar, editar y eliminar usuarios.  
Este controlador está orientado a **roles administrativos**, garantizando control y organización del acceso al sistema.

### English
The `GestionUsuariosController` is responsible for **system user management**, allowing administrators to create, list, edit, and delete users.  
This controller is designed for **administrative roles**, ensuring structured access control across the system.

---

## Responsabilidades / Responsibilities

### Español
- Listar usuarios con paginación
- Crear nuevos usuarios
- Editar información de usuarios existentes
- Eliminar usuarios
- Redirigir correctamente según la paginación
- Proporcionar feedback visual (alerts y highlights)

### English
- List users with pagination
- Create new users
- Edit existing user information
- Delete users
- Redirect correctly based on pagination
- Provide visual feedback (alerts and highlights)

---

## Métodos del Controlador / Controller Methods

| Método | HTTP | Ruta | Descripción |
|------|------|------|-------------|
| index | GET | /gestionUsuarios | Listado de usuarios |
| create | GET | /gestionUsuarios/create | Formulario de creación |
| store | POST | /gestionUsuarios | Guardar nuevo usuario |
| edit | GET | /gestionUsuarios/{user}/edit | Edición de usuario |
| update | PUT | /gestionUsuarios/{user} | Actualización de usuario |
| destroy | DELETE | /gestionUsuarios/{user} | Eliminación de usuario |

---

## Detalle de Métodos / Method Details

---

### `index(Request $request)`

**ES:**  
Obtiene los usuarios del sistema mediante paginación y los envía a la vista principal de gestión de usuarios.

**EN:**  
Retrieves system users using pagination and sends them to the main user management view.

---

### `create()`

**ES:**  
Muestra el formulario para la creación de un nuevo usuario.

**EN:**  
Displays the form for creating a new user.

---

### `store(Request $request)`

**ES:**  
Registra un nuevo usuario en el sistema.

#### Funcionalidades clave:
- Valida los campos requeridos
- Crea el usuario en base de datos
- Calcula la página correcta de la paginación
- Redirige al listado resaltando el nuevo registro

**EN:**  
Registers a new user in the system.

#### Key features:
- Validates required fields
- Creates the user in the database
- Calculates the correct pagination page
- Redirects to the list highlighting the new record

---

### `edit(User $user)`

**ES:**  
Muestra el formulario de edición para un usuario específico.

**EN:**  
Displays the edit form for a specific user.

---

### `update(Request $request, User $user)`

**ES:**  
Actualiza la información de un usuario existente.

#### Funcionalidades clave:
- Validación flexible (campos opcionales)
- Actualización directa del modelo
- Cálculo de paginación
- Feedback visual de actualización

**EN:**  
Updates an existing user's information.

#### Key features:
- Flexible validation (optional fields)
- Direct model update
- Pagination calculation
- Visual update feedback

---

### `destroy(User $user)`

**ES:**  
Elimina un usuario del sistema y redirige correctamente según la paginación actual.

> ⚠️ Nota: Actualmente la eliminación es **definitiva**. Puede adaptarse a eliminación lógica (`soft deletes`) si el sistema lo requiere.

**EN:**  
Deletes a user from the system and redirects according to pagination.

> ⚠️ Note: Deletion is currently **permanent**. It can be adapted to soft deletes if required.

---

## Seguridad / Security

### Español
- Controlado mediante middleware de autenticación
- Recomendado limitar el acceso solo a usuarios ADMIN
- Validaciones del lado servidor
- Riesgo reducido de edición accidental

### English
- Controlled via authentication middleware
- Recommended restriction to ADMIN users only
- Server-side validation
- Reduced risk of accidental edits

---

## 🛠 Dependencias / Dependencies

- `App\Models\User`
- `Illuminate\Http\Request`

---

## Consideraciones de Escalabilidad / Scalability Notes

### Español
- Puede integrarse con:
  - Auditoría de acciones administrativas
  - Soft deletes para usuarios
  - Asignación de permisos más granular
- Fácil migración a `FormRequest` para validaciones

### English
- Can be integrated with:
  - Administrative action auditing
  - Soft deletes for users
  - Granular permission management
- Easy migration to `FormRequest` validation

---

## 📎 Notas Finales / Final Notes

Este controlador representa el **núcleo administrativo del sistema**, siendo crítico para la correcta gestión de accesos y responsabilidades.

This controller represents the **administrative core of the system**, making it critical for proper access and responsibility management.
